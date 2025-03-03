<?php

class Vehicles extends CComponent {

    public $header;
    public $inspectionDetails;

    public function __construct($header, array $inspectionDetails) {
        $this->header = $header;
        $this->inspectionDetails = $inspectionDetails;
    }

    public function addInspectionDetail() {
        $inspectionDetail = new VehicleInspection();
        $this->inspectionDetails[] = $inspectionDetail;
    }

    public function removeInspectionDetailAt($index) {
        array_splice($this->inspectionDetails, $index, 1);
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

        //$valid = $this->validateDetailsCount() && $valid;



        if (count($this->inspectionDetails) > 0) {
            foreach ($this->inspectionDetails as $inspectionDetail) {
                $fields = array('vehicle_id', 'inspection_id');
                $valid = $inspectionDetail->validate($fields) && $valid;
            }
        } else {
            $valid = true;
        }

        //print_r($valid);
        return $valid;
    }

    public function validateDetailsCount() {
        $valid = true;
        if (count($this->phoneDetails) === 0) {
            $valid = false;
            $this->header->addError('error', 'Form tidak ada data untuk insert database. Minimal satu data detail untuk melakukan penyimpanan.');
        }

        return $valid;
    }

    public function flush() {
        $this->header->plate_number = $this->header->getPlateNumberCombination();
        $valid = $this->header->save();
        //echo $valid;

        $vehicleInspections = VehicleInspection::model()->findAllByAttributes(array('vehicle_id' => $this->header->id));
        $inspectionId = array();
        foreach ($vehicleInspections as $vehicleInspection) {
            $inspectionId[] = $vehicleInspection->id;
        }
        $new_inspection = array();

        //vehicle
        foreach ($this->inspectionDetails as $inspectionDetail) {
            $inspectionDetail->vehicle_id = $this->header->id;

            $valid = $inspectionDetail->save(false) && $valid;
            $new_inspection[] = $inspectionDetail->id;
        }

        $delete_inspection = array_diff($inspectionId, $new_inspection);
        if ($delete_inspection != NULL) {
            $inspection_criteria = new CDbCriteria;
            $inspection_criteria->addInCondition('id', $delete_inspection);
            VehicleInspection::model()->deleteAll($inspection_criteria);
        }

        return $valid;
    }
}