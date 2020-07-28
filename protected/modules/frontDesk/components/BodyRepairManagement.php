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

    public function flush() {
        $valid = false;
        if ($this->runningDetail->is_passed) {
            $nextServiceName = $this->nextServiceName($this->runningDetail->service_name);
            $this->header->service_status = $nextServiceName === null ? 'Finish' : $nextServiceName . ' - Pending';
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
    
    private function nextServiceName($serviceName) {
        $nextServiceNameList = array(
            'Bongkar' => 'Sparepart',
            'Sparepart' => 'Ketok/Las',
            'Ketok/Las' => 'Dempul',
            'Dempul' => 'Epoxy',
            'Epoxy' => 'Cat',
            'Cat' => 'Pasang',
            'Pasang' => 'Poles',
            'Poles' => 'Cuci',
            'Cuci' => null,
        );
        
        return $nextServiceNameList[$serviceName];
    }
}
