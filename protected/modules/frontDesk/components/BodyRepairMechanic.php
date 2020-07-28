<?php

class BodyRepairMechanic extends CComponent {

    public $header;
    public $runningDetail;
    public $runningDetailTimesheet;

    public function __construct($header, $runningDetail, $runningDetailTimesheet) {
        $this->header = $header;
        $this->runningDetail = $runningDetail;
        $this->runningDetailTimesheet = $runningDetailTimesheet;
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
        if ($this->runningDetailTimesheet->isNewRecord) {
            $this->runningDetailTimesheet->start_date_time = date('Y-m-d H:i:s');
            $this->runningDetailTimesheet->registration_body_repair_detail_id = $this->runningDetail->id;
            $valid = $this->runningDetailTimesheet->save(false);

            if ($this->runningDetail->start_date_time === null) {
                $this->runningDetail->start_date_time = $this->runningDetailTimesheet->start_date_time;
                $valid = $valid && $this->runningDetail->save(false);
            
                $this->header->service_status = $this->runningDetail->service_name . ' - Started';
                $valid = $valid && $this->header->save(false);
            }
        } else {
            $this->runningDetailTimesheet->finish_date_time = date('Y-m-d H:i:s');
            $startTime = strtotime($this->runningDetailTimesheet->start_date_time); 
            $finishTime = strtotime($this->runningDetailTimesheet->finish_date_time);
            $totalTime = $finishTime - $startTime;
            $this->runningDetailTimesheet->total_time = $totalTime;
            $valid = $this->runningDetailTimesheet->save(false);

            if ($this->runningDetail->to_be_checked) {
                $this->runningDetail->finish_date_time = $this->runningDetailTimesheet->finish_date_time;
                $runningDetailTotalTime = 0;
                foreach ($this->runningDetail->registrationBodyRepairDetailTimesheets as $timesheet) {
                    $runningDetailTotalTime += $timesheet->total_time;
                }
                $this->runningDetail->total_time = $runningDetailTotalTime;
                $valid = $valid && $this->runningDetail->save(false);
                
                $this->header->total_time += $this->runningDetail->total_time;
                $this->header->service_status = $this->runningDetail->service_name . ' - Checking';
                $valid = $valid && $this->header->save(false);
            }
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