<?php

class VehicleInspectionAfterService extends CComponent {

    public $header;
    public $vehicleInspectionDetails;

    public function __construct($header, array $vehicleInspectionDetails) {
        $this->header = $header;
        $this->vehicleInspectionDetails = $vehicleInspectionDetails;
    }

    public function save($dbConnection) {
        $dbTransaction = $dbConnection->beginTransaction();
        try {
            $valid = $this->flush();
            
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

    public function flush() {

        $valid = TRUE;
        
        //Vehicle Inspection Details
        foreach ($this->vehicleInspectionDetails as $vehicleInspectionDetail) {
            $valid = $vehicleInspectionDetail->update(array('checklist_module_id_after_service', 'value_after_service')) && $valid;
        }

        $registration = RegistrationTransaction::model()->findByAttributes(array('work_order_number' => $this->header->work_order_number));
        $registrationRealization = new RegistrationRealizationProcess();
        $registrationRealization->registration_transaction_id = $registration->id;
        $registrationRealization->name = 'Inspection After Service';
        $registrationRealization->checked = 1;
        $registrationRealization->checked_by = Yii::app()->user->id;
        $registrationRealization->checked_date = date('Y-m-d');
        $registrationRealization->detail = 'Yes';
        $registrationRealization->save();

        return $valid;
    }
}