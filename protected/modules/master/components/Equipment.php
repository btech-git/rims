<?php

class Equipment extends CComponent {

    public $header;
    public $equipmentDetails;
    public $taskDetails;
    public $equipmentMaintenances1;

    //public function __construct($header, array $branchDetails, array $taskDetails) 
    public function __construct($header, array $equipmentDetails, array $taskDetails, array $equipmentMaintenances1) {
        $this->header = $header;
        $this->equipmentDetails = $equipmentDetails;
        $this->taskDetails = $taskDetails;
        $this->equipmentMaintenances1 = $equipmentMaintenances1;
    }

    public function addMaintenanceDetail() {
        $equipmentMaintenances1 = new equipmentMaintenances();
        $this->equipmentMaintenances1[] = $equipmentMaintenances1;
    }

    public function removeMaintenanceDetailAt($index) {
        array_splice($this->equipmentMaintenances1, $index, 1);
    }

    public function addEquipmentDetail() {
        $equipmentDetail = new EquipmentDetails();
        $this->equipmentDetails[] = $equipmentDetail;
    }

    public function removeEquipmentDetailAt($index) {
        array_splice($this->equipmentDetails, $index, 1);
    }

    public function addTaskDetail() {
        $taskDetail = new EquipmentTask();
        $this->taskDetails[] = $taskDetail;
    }

    public function removeTaskDetailAt($index) {
        array_splice($this->taskDetails, $index, 1);
    }

    public function save($dbConnection) {
        $dbTransaction = $dbConnection->beginTransaction();
        try {
            $valid = $this->validate() && $this->flush();
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

        if (count($this->equipmentDetails) > 0) {
            foreach ($this->equipmentDetails as $equipmentDetail) {
                $fields = array('purchase_date', 'age');
                $valid = $equipmentDetail->validate($fields) && $valid;
            }
        } else {
            $valid = true;
        }


        if (count($this->taskDetails) > 0) {
            foreach ($this->taskDetails as $taskDetail) {
                $fields = array('task', 'check_period');
                $valid = $taskDetail->validate($fields) && $valid;
            }
        } else {
            $valid = true;
        }

        if (count($this->equipmentMaintenances1) > 0) {
            foreach ($this->equipmentMaintenances1 as $equipmentMaintenance) {
                $fields = array('maintenance_date', 'next_maintenance_date');
                $valid = $equipmentMaintenance->validate($fields) && $valid;
            }
        } else {
            $valid = true;
        }

        return $valid;
    }

    public function validateDetailsCount() {
        $valid = true;
        if (count($this->positions) === 0) {
            $valid = false;
            $this->header->addError('error', 'Form tidak ada data untuk insert database. Minimal satu data detail untuk melakukan penyimpanan.');
        }

        return $valid;
    }

    public function flush() {
        $isNewRecord = $this->header->isNewRecord;
        $valid = $this->header->save();
        
        $equipmentDetails = EquipmentDetails::model()->findAllByAttributes(array('equipment_id' => $this->header->id));
        $detailId = array();
        foreach ($equipmentDetails as $equipmentDetail) {
            $detailId[] = $equipmentDetail->id;
        }
        $new_detail = array();

        //detail
        foreach ($this->equipmentDetails as $equipmentDetail) {
            $equipmentDetail->equipment_id = $this->header->id;
            $valid = $equipmentDetail->save(false) && $valid;
            $new_branch[] = $equipmentDetail->id;
        }

        // equipment Tasks
        $equipmentTasks = EquipmentTask::model()->findAllByAttributes(array('equipment_id' => $this->header->id));
        $taskId = array();
        foreach ($equipmentTasks as $equipmentTask) {
            $taskId[] = $equipmentTask->id;
        }
        $new_task = array();

        //task
        foreach ($this->taskDetails as $taskDetail) {
            $taskDetail->equipment_id = $this->header->id;
            $valid = $taskDetail->save(false) && $valid;
            $new_task[] = $taskDetail->id;
        }

        // equipment Maintenances
        $equipmentMaintenances1 = EquipmentMaintenances::model()->findAllByAttributes(array('equipment_id' => $this->header->id));
        $maintenanceId = array();
        foreach ($equipmentMaintenances1 as $equipmentMaintenance) {
            $maintenanceId[] = $equipmentMaintenance->id;
        }
        $new_maintenance = array();

        //Maintenances
        foreach ($this->equipmentMaintenances1 as $equipmentMaintenance) {
            $equipmentMaintenance->equipment_id = $this->header->id;
            $valid = $equipmentMaintenance->save(false) && $valid;
            $new_maintenance[] = $equipmentMaintenance->id;
        }

        $this->saveTransactionLog();
        
        return $valid;
    }
    
    public function saveTransactionLog() {
        $transactionLog = new MasterLog();
        $transactionLog->name = $this->header->name;
        $transactionLog->log_date = date('Y-m-d');
        $transactionLog->log_time = date('H:i:s');
        $transactionLog->table_name = $this->header->tableName();
        $transactionLog->table_id = $this->header->id;
        $transactionLog->user_id = Yii::app()->user->id;
        $transactionLog->username = Yii::app()->user->username;
        $transactionLog->controller_class = Yii::app()->controller->module->id  . '/' . Yii::app()->controller->id;
        $transactionLog->action_name = Yii::app()->controller->action->id;
        
        $newData = $this->header->attributes;
        $transactionLog->new_data = json_encode($newData);

        $transactionLog->save();
    }
}