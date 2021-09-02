<?php

class Cashs extends CComponent {

    public $header;
    public $details;

    public function __construct($header, array $details) {
        $this->header = $header;
        $this->details = $details;
    }

    public function generateCodeNumber($currentMonth, $currentYear, $requesterBranchId) {
        $arr = array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $cnYearCondition = "substring_index(substring_index(substring_index(transaction_number, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(transaction_number, '/', 2), '/', -1), '.', -1)";
        $cashTransaction = CashTransaction::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND branch_id = :branch_id",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth], ':branch_id' => $requesterBranchId),
                ));

        if ($cashTransaction == null) {
            $branchCode = Branch::model()->findByPk($requesterBranchId)->code;
        } else {
            $branchCode = $cashTransaction->branch->code;
            $this->header->transaction_number = $cashTransaction->transaction_number;
        }

        $this->header->setCodeNumberByNext('transaction_number', $branchCode, CashTransaction::CONSTANT, $currentMonth, $currentYear);
    }

    public function addDetail($coaId) {
        $detail = new CashTransactionDetail();
        $coa = Coa::model()->findByPk($coaId);
        $detail->coa_id = $coa->id;
        $detail->coa_name = $coa->name;
        $detail->coa_normal_balance = $coa->normal_balance;
        $detail->coa_debit = $coa->debit == "" ? 0 : $coa->debit;
        $detail->coa_credit = $coa->credit == "" ? 0 : $coa->credit;
        $this->details[] = $detail;
    }

    public function removeDetailAt($index) {
        array_splice($this->details, $index, 1);
        //var_dump(CJSON::encode($this->details));
    }

    public function save($dbConnection) {
        $dbTransaction = $dbConnection->beginTransaction();
        try {
            $valid = $this->validate() && $this->flush();
            if ($valid) {
                $dbTransaction->commit();
                //print_r('1');
            } else {
                $dbTransaction->rollback();
                //print_r('2');
            }
        } catch (Exception $e) {
            $dbTransaction->rollback();
            $valid = false;
            //print_r($e);
        }

        return $valid;
        //print_r('success');
    }

    public function validate() {
        $valid = $this->header->validate();


        if (count($this->details) > 0) {
            foreach ($this->details as $detail) {

                $fields = array('price');
                $valid = $detail->validate($fields) && $valid;
            }
        } else {
            $valid = true;
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
//        $isNewRecord = $this->header->isNewRecord;
        $this->header->debit_amount = $this->totalDetails;
        $valid = $this->header->save();

        $cashDetails = CashTransactionDetail::model()->findAllByAttributes(array('cash_transaction_id' => $this->header->id));
        $detail_id = array();
        foreach ($cashDetails as $cashDetail) {
            $detail_id[] = $cashDetail->id;
        }
        $new_detail = array();

        //save request detail
        foreach ($this->details as $detail) {
            $detail->cash_transaction_id = $this->header->id;
            $valid = $detail->save(false) && $valid;
            $new_detail[] = $detail->id;
        }


        //delete details
        $delete_array = array_diff($detail_id, $new_detail);
        if ($delete_array != NULL) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $delete_array);
            CashTransactionDetail::model()->deleteAll($criteria);
        }

        return $valid;
    }

    public function getTotalDetails() {
        $total = 0.00;
        
        foreach($this->details as $detail) {
            $total += $detail->amount;
        }
        
        return $total;
    }
}
