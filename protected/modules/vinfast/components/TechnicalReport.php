<?php

class TechnicalReport extends CComponent {

    public $actionType;
    public $header;

    public function __construct($actionType, $header) {
        $this->actionType = $actionType;
        $this->header = $header;
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

    public function validate() {
        $valid = $this->header->validate();

        return $valid;
    }

    public function flush() {
        $valid = $this->header->save(false);

        $this->header->failedPartImages = CUploadedFile::getInstances($this->header, 'failedPartImages');
        foreach ($this->header->failedPartImages as $file) {
            $contentImage = new TechnicalReportFailedPartPhoto();
            $contentImage->technical_report_header_id = $this->header->id;
            $contentImage->extension = $file->extensionName;
            $contentImage->filename = $file->name;
            $valid = $contentImage->save(false) && $valid;

            $originalPath = dirname(Yii::app()->request->scriptFile) . '/images/uploads/failedPart/' . $contentImage->fullFilename;
            $file->saveAs($originalPath);
        }
        
        $this->header->failedPartSerialNumberImages = CUploadedFile::getInstances($this->header, 'failedPartSerialNumberImages');
        foreach ($this->header->failedPartSerialNumberImages as $file) {
            $contentImage = new TechnicalReportFailedPartSerialNumberPhoto();
            $contentImage->technical_report_header_id = $this->header->id;
            $contentImage->extension = $file->extensionName;
            $contentImage->filename = $file->name;
            $valid = $contentImage->save(false) && $valid;

            $originalPath = dirname(Yii::app()->request->scriptFile) . '/images/uploads/failedPartSerialNumber/' . $contentImage->fullFilename;
            $file->saveAs($originalPath);
        }
        
        $this->header->newPartImages = CUploadedFile::getInstances($this->header, 'newPartImages');
        foreach ($this->header->newPartImages as $file) {
            $contentImage = new TechnicalReportNewPartPhoto();
            $contentImage->technical_report_header_id = $this->header->id;
            $contentImage->extension = $file->extensionName;
            $contentImage->filename = $file->name;
            $valid = $contentImage->save(false) && $valid;

            $originalPath = dirname(Yii::app()->request->scriptFile) . '/images/uploads/newPart/' . $contentImage->fullFilename;
            $file->saveAs($originalPath);
        }
        
        $this->header->odometerImages = CUploadedFile::getInstances($this->header, 'odometerImages');
        foreach ($this->header->odometerImages as $file) {
            $contentImage = new TechnicalReportOdometerPhoto();
            $contentImage->technical_report_header_id = $this->header->id;
            $contentImage->extension = $file->extensionName;
            $contentImage->filename = $file->name;
            $valid = $contentImage->save(false) && $valid;

            $originalPath = dirname(Yii::app()->request->scriptFile) . '/images/uploads/odometer/' . $contentImage->fullFilename;
            $file->saveAs($originalPath);
        }
        
        $this->saveTransactionLog();
        
        return $valid;
    }
    
    public function saveTransactionLog() {
        $transactionLog = new TransactionLog();
        $transactionLog->transaction_number = $this->header->warranty_claim_number;
        $transactionLog->transaction_date = date('Y-m-d');
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
        $transactionLog->new_data = json_encode($newData);
        $transactionLog->save();
    }
}