<?php

class JournalBeginning extends CComponent {

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
        $journalBeginningHeader = JournalBeginningHeader::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND branch_id = :branch_id",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth], ':branch_id' => $branchId),
        ));

        if ($journalBeginningHeader == null) {
            $branchCode = Branch::model()->findByPk($branchId)->code;
        } else {
            $branchCode = $journalBeginningHeader->branch->code;
            $this->header->transaction_number = $journalBeginningHeader->transaction_number;
        }

        $this->header->setCodeNumberByNext('transaction_number', $branchCode, JournalBeginningHeader::CONSTANT, $currentMonth, $currentYear);
    }

    public function addDetail($id) {

//        $coa = Coa::model()->findByPk($id);
        $detail = new JournalBeginningDetail();
        $detail->coa_id = $id;
//        $detail->current_balance = '0.00';
//        $detail->difference_balance = $detail->current_balance - $detail->adjustment_balance;
        $this->details[] = $detail;
    }

    public function removeAccountDetailAt($index) {
        array_splice($this->details, $index, 1);
    }

    public function validate() {
        $valid = $this->header->validate();

        $valid = $valid && $this->validateDetailsCount();

        if (count($this->details) > 0) {
            foreach ($this->details as $detail) {
                $fields = array('current_balance', 'adjustment_balance', 'difference_balance', 'coa_id');
                $valid = $valid && $detail->validate($fields);
            }
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

    public function flush() {
        $valid = $this->header->save(false);

        foreach ($this->details as $detail) {
            if ($detail->isNewRecord) {
                $detail->journal_beginning_header_id = $this->header->id;
            }

            $valid = $valid && $detail->save(false);
        }

        return $valid;
    }

    public function save($dbConnection) {
        $dbTransaction = $dbConnection->beginTransaction();
        try {
            $valid = $this->validate() && IdempotentManager::build()->save() && $this->flush();
            if ($valid) {
                $dbTransaction->commit();
            } else {
                $dbTransaction->rollback();
            }
        } catch (Exception $e) {
            $dbTransaction->rollback();
            $valid = false;
        }

        return $valid;
    }
}