<?php

class Cashs extends CComponent {

    public $actionType;
    public $header;
    public $details;

    public function __construct($actionType, $header, array $details) {
        $this->actionType = $actionType;
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
        $this->header->credit_amount = $this->totalDetails;
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

        foreach ($this->header->images as $file) {
            $contentImage = new CashTransactionImages();
            $contentImage->cash_transaction_id = $this->header->id;
            $contentImage->is_inactive = CashTransaction::STATUS_ACTIVE;
            $contentImage->extension = $file->extensionName;
            $valid = $contentImage->save(false) && $valid;

            $originalPath = dirname(Yii::app()->request->scriptFile) . '/images/uploads/cashTransaction/' . $contentImage->filename;
            $file->saveAs($originalPath);
//            $picture = Yii::app()->image->load($originalPath);
//            $picture->resize(500, 800);
//            $picture->save();
        }

        //delete details
        $delete_array = array_diff($detail_id, $new_detail);
        if ($delete_array != NULL) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $delete_array);
            CashTransactionDetail::model()->deleteAll($criteria);
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
        
        $newData['cashTransactionDetails'] = array();
        foreach($this->details as $detail) {
            $newData['cashTransactionDetails'][] = $detail->attributes;
        }
        
        $transactionLog->new_data = json_encode($newData);

        $transactionLog->save();
    }

    public function getTotalDetails() {
        $total = 0.00;
        
        foreach($this->details as $detail) {
            $total += $detail->amount;
        }
        
        return $total;
    }
}
