<?php

class ProductPricingRequest extends CComponent {

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
        $productPricingRequestHeader = ProductPricingRequestHeader::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND branch_id_request = :branch_id",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth], ':branch_id' => $branchId),
        ));

        if ($productPricingRequestHeader == null) {
            $branchCode = Branch::model()->findByPk($branchId)->code;
        } else {
            $branchCode = $productPricingRequestHeader->branchIdRequest->code;
            $this->header->transaction_number = $productPricingRequestHeader->transaction_number;
        }

        $this->header->setCodeNumberByNext('transaction_number', $branchCode, ProductPricingRequestHeader::CONSTANT, $currentMonth, $currentYear);
    }

    public function addDetail() {
        $detail = new ProductPricingRequestDetail();

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
            $this->header->addError('error', $e->getMessage());
        }

        return $valid;
    }

    public function delete($dbConnection) {
        $dbTransaction = $dbConnection->beginTransaction();
        try {
            $valid = true;

            foreach ($this->details as $detail) {
                $valid = $valid && $detail->delete();
            }

            $valid = $valid && $this->header->delete();

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
        
        if (!$valid) {
            $this->header->addError('error', 'Header Error');
        } else {
            $valid = $valid && $this->validateDetailsCount();
            if (!$valid) {
                $this->header->addError('error', 'Validate Details Error');
            }
        }
        
        if (count($this->details) > 0) {
            foreach ($this->details as $detail) {
                $fields = array('quantity', 'product_name', 'recommended_price');
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

    public function flush() {
        
        $valid = $this->header->save(false);

        foreach ($this->details as $detail) {
            
            if ($detail->quantity <= 0) {
                continue;
            }

            $detail->product_pricing_request_header_id = $this->header->id;
            $valid = $valid && $detail->save(false);
        }

        $fileName = CUploadedFile::getInstanceByName('file');
        if ($fileName !== null) {
            $this->header->file = $fileName;
            $this->header->extension = $fileName->getExtensionName();
            $this->header->update(array('extension'));
            
            $originalPath = dirname(Yii::app()->request->scriptFile) . '/images/uploads/product_pricing_request/' . $this->header->id . '.' . $this->header->extension;
            $fileName->saveAs($originalPath);
        }

        $this->saveTransactionLog();
        
        return $valid;
    }
    
    public function saveTransactionLog() {
        $transactionLog = new TransactionLog();
        $transactionLog->transaction_number = $this->header->transaction_number;
        $transactionLog->transaction_date = $this->header->request_date;
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
        
        $newData['productPricingRequestDetails'] = array();
        foreach($this->details as $detail) {
            $newData['productPricingRequestDetails'][] = $detail->attributes;
        }
        
        $transactionLog->new_data = json_encode($newData);

        $transactionLog->save();
    }
}
