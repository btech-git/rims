<?php

class JournalAdjustment extends CComponent {

    public $header;
    public $details;

    public function __construct($header, array $details) {
        $this->header = $header;
        $this->details = $details;
    }

    public function generateCodeNumber($currentMonth, $currentYear, $branchId) {
        $arr = array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $cnYearCondition = "substring_index(substring_index(substring_index(transaction_number, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(transaction_number, '/', 2), '/', -1), '.', -1)";
        $journalAdjustmentHeader = JournalAdjustmentHeader::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND branch_id = :branch_id",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth], ':branch_id' => $branchId),
        ));

        if ($journalAdjustmentHeader == null) {
            $branchCode = Branch::model()->findByPk($branchId)->code;
        } else {
            $branchCode = $journalAdjustmentHeader->branch->code;
            $this->header->transaction_number = $journalAdjustmentHeader->transaction_number;
        }

        $this->header->setCodeNumberByNext('transaction_number', $branchCode, JournalAdjustmentHeader::CONSTANT, $currentMonth, $currentYear);
    }

    public function addDetail($id) {
//        $account = Coa::model()->findByPk($id);

//        if ($account !== null) {
                $detail = new JournalAdjustmentDetail();
                $detail->coa_id = $id;
                $this->details[] = $detail;
//        }
    }

    public function removeAccountDetailAt($index) {
        array_splice($this->details, $index, 1);
    }

    public function validate() {
        $valid = $this->header->validate();

        $valid = $valid && $this->validateDetailsCount();
        $valid = $valid && $this->validateDebitCreditBalance();

        if (count($this->details) > 0) {
            foreach ($this->details as $detail) {
                $fields = array('debit', 'credit', 'account_id');
                $valid = $valid && $detail->validate($fields);
            }
        } else {
            $valid = false;
        }

        return $valid;
    }

    public function validateDetailsCount() {
        $valid = true;
        if (count($this->details) === 0) {
            $valid = false;
            $this->header->addError('error', 'Form tidak ada data untuk insert database. Minimal satu data detail untuk melakukan penyimpanan.');
        }

        return $valid;
    }

    public function validateDebitCreditBalance() {
        $valid = true;

        if ($this->totalDebit !== $this->totalCredit) {
            $valid = false;
            $this->header->addError('error', 'Total Debit dan Credit tidak sama!!!');
        }
        
        return $valid;
    }

    public function flush() {
        $valid = $this->header->save(false);

        //save Product
        $accounts = JournalAdjustmentDetail::model()->findAllByAttributes(array('journal_adjustment_header_id' => $this->header->id));
        $account_id = array();
        
        foreach ($accounts as $account) {
            $account_id[] = $account->id;
        }
        $new_account = array();

        foreach ($this->details as $detail) {
            if ($detail->isNewRecord) {
                $detail->journal_adjustment_header_id = $this->header->id;
            }

            $valid = $valid && $detail->save(false);
            $new_account[] = $detail->id;
        }

        //delete 
        $delete_account_array = array_diff($account_id, $new_account);
        if ($delete_account_array != NULL) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $delete_account_array);
            JournalAdjustmentDetail::model()->deleteAll($criteria);
        }

        return $valid;
    }

    public function save($dbConnection) {
        $dbTransaction = $dbConnection->beginTransaction();
        try {
            $valid = $this->validate() && IdempotentManager::build()->save() && $this->flush();
            if ($valid)
                $dbTransaction->commit();
            else
                $dbTransaction->rollback();
        } catch (Exception $e) {
            $dbTransaction->rollback();
            $valid = false;
        }

        return $valid;
    }

    public function getTotalDebit() {
        $total = 0.00;
        foreach ($this->details as $detail) {
            $total += $detail->debit;
        }

        return $total;
    }

    public function getTotalCredit() {
        $total = 0.00;
        foreach ($this->details as $detail) {
            $total += $detail->credit;
        }

        return $total;
    }
}