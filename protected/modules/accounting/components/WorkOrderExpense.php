<?php

class WorkOrderExpense extends CComponent {

    public $actionType;
    public $header;
    public $details;

    public function __construct($actionType, $header, array $details) {
        $this->actionType = $actionType;
        $this->header = $header;
        $this->details = $details;
    }

    public function generateCodeNumber($currentMonth, $currentYear, $branchId) {
        $arr = array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $cnYearCondition = "substring_index(substring_index(substring_index(transaction_number, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(transaction_number, '/', 2), '/', -1), '.', -1)";
        $workOrderExpenseHeader = WorkOrderExpenseHeader::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND branch_id = :branch_id",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth], ':branch_id' => $branchId),
        ));

        if ($workOrderExpenseHeader == null) {
            $branchCode = Branch::model()->findByPk($branchId)->code;
        } else {
            $branchCode = $workOrderExpenseHeader->branch->code;
            $this->header->transaction_number = $workOrderExpenseHeader->transaction_number;
        }

        $this->header->setCodeNumberByNext('transaction_number', $branchCode, WorkOrderExpenseHeader::CONSTANT, $currentMonth, $currentYear);
    }

    public function addDetail() {

        $detail = new WorkOrderExpenseDetail;
        $this->details[] = $detail;
    }

    public function removeDetailAt($index) {
        array_splice($this->details, $index, 1);
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
            $this->header->addError('error', $e->getMessage());
        }

        return $valid;
    }

    public function delete($dbConnection) {
        $dbTransaction = $dbConnection->beginTransaction();
        try {
            $valid = true;

            foreach ($this->details as $detail)
                $valid = $valid && $detail->delete();

            $valid = $valid && $this->header->delete();

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

    public function validate() {
        $valid = $this->header->validate();

//        $valid = $this->validateDetailsCount() && $valid;
//        $valid = $this->validateDetailsUnique() && $valid;

        if (count($this->details) > 0) {
            foreach ($this->details as $detail) {
                $fields = array('memo', 'amount');
                $valid = $detail->validate($fields) && $valid;
            }
        } else
            $valid = false;

        return $valid;
    }

//    public function validateDetailsCount() {
//        $valid = true;
//        if (count($this->details) === 0) {
//            $valid = false;
//            $this->header->addError('error', 'Form tidak ada data untuk insert database. Minimal satu data detail untuk melakukan penyimpanan.');
//        }
//
//        return $valid;
//    }
//
//    public function validateDetailsUnique() {
//        $valid = true;
//
//        $detailsCount = count($this->details);
//        for ($i = 0; $i < $detailsCount; $i++) {
//            for ($j = $i; $j < $detailsCount; $j++) {
//                if ($i === $j)
//                    continue;
//
//                if ($this->details[$i]->receive_item_id === $this->details[$j]->receive_item_id) {
//                    $valid = false;
//                    $this->header->addError('error', 'Invoice tidak boleh sama.');
//                    break;
//                }
//            }
//        }
//
//        return $valid;
//    }

    public function flush() {
        $this->header->grand_total = $this->totalDetail;
        $this->header->total_payment = 0.00;
        $this->header->payment_remaining = $this->totalDetail;
        
        $valid = $this->header->save(false);

        foreach ($this->details as $detail) {
            if ($detail->amount <= 0.00) {
                continue;
            }

            if ($detail->isNewRecord) {
                $detail->work_order_expense_header_id = $this->header->id;
            }

            $valid = $detail->save(false) && $valid;
        }

        $this->saveTransactionLog();
        
        return $valid;
    }
    
    public function saveTransactionLog() {
        $transactionLog = new TransactionLog();
        $transactionLog->transaction_number = $this->header->transaction_number;
        $transactionLog->transaction_date = $this->header->transaction_date;
        $transactionLog->log_date = date('Y-m-d');
        $transactionLog->log_time = date('H:i:s');
        $transactionLog->table_name = $this->header->tableName();
        $transactionLog->table_id = $this->header->id;
        $transactionLog->user_id = Yii::app()->user->id;
        $transactionLog->username = Yii::app()->user->username;
        $transactionLog->controller_class = Yii::app()->controller->module->id  . '/' . Yii::app()->controller->id;
        $transactionLog->action_name = Yii::app()->controller->action->id;
        $transactionLog->action_type = $this->actionType;
        
        $newData = $this->header->attributes;
        
        $newData['workOrderExpenseDetails'] = array();
        foreach($this->details as $detail) {
            $newData['workOrderExpenseDetails'][] = $detail->attributes;
        }
        
        $transactionLog->new_data = json_encode($newData);

        $transactionLog->save();
    }
    
    public function getTotalDetail() {
        $total = 0.00;
        
        foreach ($this->details as $detail) {
            $total += $detail->amount;
        }
        
        return $total;
    }
}
