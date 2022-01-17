<?php

class BodyRepairManagement extends CComponent {

    public $header;
    public $runningDetail;

    public function __construct($header, $runningDetail) {
        $this->header = $header;
        $this->runningDetail = $runningDetail;
    }

    public function validate() {
        $valid = $this->header->validate();

        return $valid;
    }

    public function save($dbConnection) {
        $dbTransaction = $dbConnection->beginTransaction();
        try {
            $valid = $this->validate() && $this->flush();
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

    public function saveForFail($dbConnection, $serviceName) {
        $dbTransaction = $dbConnection->beginTransaction();
        try {
            $valid = $this->validate() && $this->flushForFail($serviceName);
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

    public function flush() {
        $valid = false;
        if ($this->runningDetail->is_passed) {
            $nextServiceName = $this->nextServiceName($this->runningDetail->service_name);
            $this->header->status = $nextServiceName === null ? 'Repair Completed' : 'Queue ' . $nextServiceName;
            $this->header->service_status = $nextServiceName === null ? 'Finished' : $nextServiceName . ' - Pending';
            $valid = $this->header->save(false);
            $this->runningDetail->mechanic_head_id = Yii::app()->user->id;
            $valid = $valid && $this->runningDetail->save(false);
        } else {
            $this->header->service_status = $this->runningDetail->service_name . ' - Started';
            $this->header->total_time = 0;
            $valid = $this->header->save(false);
            $this->runningDetail->finish_date_time = null;
            $this->runningDetail->total_time = 0;
            $this->runningDetail->to_be_checked = false;
            $valid = $valid && $this->runningDetail->save(false);
        }
        return $valid;
    }

    public function flushForFail($serviceName) {
        $valid = true;
        
        $registrationTransaction = RegistrationTransaction::model()->findByPk($this->runningDetail->registration_transaction_id);
        
        $bodyRepairDetail = RegistrationBodyRepairDetail::model()->findByAttributes(array(
            'service_name' => $serviceName,
            'registration_transaction_id' => $this->runningDetail->registration_transaction_id,
        ));
        
        $bodyRepairDetails = RegistrationBodyRepairDetail::model()->findAll(array(
            'condition' => 'registration_transaction_id = :registration_transaction_id AND id >= :id',
            'params' => array(
                ':registration_transaction_id' => $this->runningDetail->registration_transaction_id,
                ':id' => $bodyRepairDetail->id,
            ),
        ));
        
        $registrationTransaction->service_status = $serviceName . ' - Pending';
        $valid = $registrationTransaction->save() && $valid;
        
        foreach ($bodyRepairDetails as $detail) {
            $detail->start_date_time = NULL;
            $detail->finish_date_time = NULL;
            $detail->total_time = 0;
            $detail->to_be_checked = 0;
            $detail->is_passed = 0;
            $detail->mechanic_id = NULL;
            $detail->mechanic_head_id = NULL;
            $detail->mechanic_assigned_id = NULL;
            $valid = $detail->save() && $valid;
        }
        
        return $valid;
    }
    
    private function nextServiceName($serviceName) {
        $nextServiceNameList = array(
            'Bongkar' => 'Sparepart',
            'Sparepart' => 'KetokLas',
            'KetokLas' => 'Dempul',
            'Dempul' => 'Epoxy',
            'Epoxy' => 'Cat',
            'Cat' => 'Pasang',
            'Pasang' => 'Cuci',
            'Cuci' => 'Poles',
            'Poles' => null,
        );
        
        return $nextServiceNameList[$serviceName];
    }
}
