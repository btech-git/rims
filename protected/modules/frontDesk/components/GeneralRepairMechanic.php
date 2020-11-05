<?php

class GeneralRepairMechanic extends CComponent {

    public $detail;

    public function __construct($detail) {
        $this->detail = $detail;
    }

    public function validate() {
        return true;
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
        
        if ($this->detail->service_activity === 'StartService') {
            $this->detail->start = date('Y-m-d H:i:s');
            $this->detail->status = 'On Progress';
            $this->detail->start_mechanic_id = Yii::app()->user->id;
            $this->detail->resume_mechanic_id = null;
            $this->detail->pause_mechanic_id = null;
            $this->detail->finish_mechanic_id = null;
        } else if ($this->detail->service_activity === 'ResumeService') {
            $this->detail->resume = date('Y-m-d H:i:s');
            $resume = strtotime($this->detail->resume); 
            $pause = strtotime($this->detail->pause);
            $this->detail->pause_time += $resume - $pause;
        } else if ($this->detail->service_activity === 'PauseService') {
            $this->detail->pause = date('Y-m-d H:i:s');
        } else if ($this->detail->service_activity === 'FinishService') {
            $this->detail->end = date('Y-m-d H:i:s');
            $this->detail->status = 'Finished';
            $end = strtotime($this->detail->end); 
            $start = strtotime($this->detail->start);
            $this->detail->total_time = $end - $start - $this->detail->pause_time;
        }

        $valid = $this->detail->save();

//        $registrationRealizationProcess = RegistrationRealizationProcess::model()->findByAttributes(array(
//            'registration_transaction_id' => $this->detail->registration_id,
//            'service_id' => $this->detail->service_id,
//        ));
//        $registrationRealizationProcess->checked_date = date('Y-m-d');
//        $registrationRealizationProcess->checked_by = Yii::app()->user->id;
//        $registrationRealizationProcess->detail = $this->detail->status;
//        $valid = $valid && $registrationRealizationProcess->update(array('checked_by', 'checked_date', 'detail'));
        
        return $valid;
    }
}