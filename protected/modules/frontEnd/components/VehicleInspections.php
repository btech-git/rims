<?php

class VehicleInspections extends CComponent {

    public $header;
    public $vehicleInspectionDetails;

    public function __construct($header, array $vehicleInspectionDetails) {
        $this->header = $header;
        $this->vehicleInspectionDetails = $vehicleInspectionDetails;
    }

    public function addVehicleInspectionDetail($inspectionId) {
        $inspectionSections = InspectionSections::model()->findAllByAttributes(array('inspection_id' => $inspectionId));

        foreach ($inspectionSections as $key => $inspectionSection) {
            $sectionModules = InspectionSectionModule::model()->findAllByAttributes(array('section_id' => $inspectionSection->section_id));

            foreach ($sectionModules as $key => $sectionModule) {
                $vehicleInspectionDetail = new VehicleInspectionDetail();
                $vehicleInspectionDetail->section_id = $inspectionSection->section_id;
                $vehicleInspectionDetail->module_id = $sectionModule->module_id;
                $vehicleInspectionDetail->checklist_type_id = $sectionModule->module->checklist_type_id;
                $this->vehicleInspectionDetails[] = $vehicleInspectionDetail;
            }
        }
    }

    public function removeDetailAt($index) {
        array_splice($this->vehicleInspectionDetails, $index, 1);
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

        if (!empty($this->vehicleInspectionDetails)) {
            foreach ($this->vehicleInspectionDetails as $vehicleInspectionDetail) {
                $valid = $vehicleInspectionDetail->validate() && $valid;
            }
        } else {
            $valid = true;
        }

        return $valid;
    }

    public function validateDetailsCount() {
        $valid = true;
        if (empty($this->vehicleInspectionDetails)) {
            $valid = false;
            $this->header->addError('error', 'Form tidak ada data untuk insert database. Minimal satu data detail untuk melakukan penyimpanan.');
        }

        return $valid;
    }

    public function flush() {
        $valid = $this->header->save();

        $vehicleInspectionDetails = VehicleInspectionDetail::model()->findAllByAttributes(array('vehicle_inspection_id' => $this->header->id));
        $vehicleInspectionDetailId = array();
        
        foreach ($vehicleInspectionDetails as $vehicleInspectionDetail) {
            $vehicleInspectionDetailId[] = $vehicleInspectionDetail->id;
        }
        $new_detail = array();

        //Vehicle Inspection Details
        foreach ($this->vehicleInspectionDetails as $vehicleInspectionDetail) {
            $vehicleInspectionDetail->vehicle_inspection_id = $this->header->id;

            $valid = $vehicleInspectionDetail->save(false) && $valid;
            $new_detail[] = $vehicleInspectionDetail->id;
        }

        $vehicleIns = VehicleInspection::model()->findAllByAttributes(array('work_order_number' => $this->header->work_order_number));
        if (!empty($vehicleIns)) {
            $registration = RegistrationTransaction::model()->findByAttributes(array('work_order_number' => $this->header->work_order_number));
            if (!empty($registration)) {
                $registrationRealization = RegistrationRealizationProcess::model()->findByAttributes(array('registration_transaction_id' => $registration->id, 'name' => 'Vehicle Inspection'));
                $registrationRealization->registration_transaction_id = $this->header->id;
                $registrationRealization->name = 'Vehicle Inspection';
                $registrationRealization->checked = 1;
                $registrationRealization->checked_by = Yii::app()->user->id;
                $registrationRealization->checked_date = date('Y-m-d');
                $registrationRealization->detail = 'Yes';
                $registrationRealization->save();
            }
        }

        //delete position
        $delete_array = array_diff($vehicleInspectionDetailId, $new_detail);
        if ($delete_array != NULL) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $delete_array);
            VehicleInspectionDetail::model()->deleteAll($criteria);
        }

        return $valid;
    }
}