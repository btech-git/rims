<?php

class VehicleInspections extends CComponent
{
	public $header;
	//public $divisonDetails;
	public $vehicleInspectionDetails;
	

	public function __construct($header, array $vehicleInspectionDetails) 
	{
		$this->header = $header;
		//$this->divisonDetails = $divisonDetails;
		$this->vehicleInspectionDetails = $vehicleInspectionDetails;
		
	}

	public function addVehicleInspectionDetail($inspectionId)
	{
		$inspectionSections = InspectionSections::model()->findAllByAttributes(array('inspection_id'=>$inspectionId));

		foreach ($inspectionSections as $key => $inspectionSection) {

			$sectionModules = InspectionSectionModule::model()->findAllByAttributes(array('section_id'=>$inspectionSection->section_id));

			foreach ($sectionModules as $key => $sectionModule) {

				$vehicleInspectionDetail = new VehicleInspectionDetail();
				$vehicleInspectionDetail->section_id = $inspectionSection->section_id;
				$vehicleInspectionDetail->module_id = $sectionModule->module_id;
				$vehicleInspectionDetail->checklist_type_id = $sectionModule->module->checklist_type_id;
				$this->vehicleInspectionDetails[] = $vehicleInspectionDetail;
			}
		}
	}
	
	
	public function removeDetailAt($index)
	{
		array_splice($this->vehicleInspectionDetails, $index, 1);
		//var_dump(CJSON::encode($this->details));
	}
	
	
	public function save($dbConnection)
	{
		$dbTransaction = $dbConnection->beginTransaction();
		try
		{
			$valid = $this->validate() && $this->flush();
			if ($valid){
				$dbTransaction->commit();
				//print_r('1');
			} else {
				$dbTransaction->rollback();
				//print_r('2');
			}

		}
		catch (Exception $e)
		{
			$dbTransaction->rollback();
			$valid = false;
			//print_r($e);
		}

		return $valid;
		//print_r('success');
	}

	public function validate()
	{
		$valid = $this->header->validate();

		//$valid = $this->validateDetailsCount() && $valid;

		if (count($this->vehicleInspectionDetails) > 0)
		{
			foreach ($this->vehicleInspectionDetails as $vehicleInspectionDetail)
			{
				//$fields = array('vehicle_inspection_id');
				$valid = $vehicleInspectionDetail->validate() && $valid;
				//echo $valid;
			}
		}
		else {
			$valid = true;
		}

		

		//print_r($valid);
		return $valid;
	}

	public function validateDetailsCount()
	{
		$valid = true;
		if (count($this->vehicleInspectionDetails) === 0)
		{
			$valid = false;
			$this->header->addError('error', 'Form tidak ada data untuk insert database. Minimal satu data detail untuk melakukan penyimpanan.');
		}

		return $valid;
	}


	public function flush()
	{
		$isNewRecord = $this->header->isNewRecord;
		$valid = $this->header->save();
		//echo $valid;
		

		$vehicleInspectionDetails = VehicleInspectionDetail::model()->findAllByAttributes(array('vehicle_inspection_id'=>$this->header->id));
		$vehicleInspectionDetailId = array();
		foreach($vehicleInspectionDetails as $vehicleInspectionDetail)
		{
			$vehicleInspectionDetailId[]=$vehicleInspectionDetail->id;
		}
		$new_detail = array();

		//Vehicle Inspection Details
		foreach ($this->vehicleInspectionDetails as $vehicleInspectionDetail)
		{
			$vehicleInspectionDetail->vehicle_inspection_id = $this->header->id;
			
			$valid = $vehicleInspectionDetail->save(false) && $valid;
			$new_detail[] = $vehicleInspectionDetail->id;
			//echo "test";
			//echo 'test phone added';
			//var_dump($model->getErrors());
		}
		
		$vehicleIns = VehicleInspection::model()->findAllByAttributes(array('work_order_number'=>$this->header->work_order_number));
		if(count($vehicleIns)<=1)
		{
			$registration = RegistrationTransaction::model()->findByAttributes(array('work_order_number'=>$this->header->work_order_number));
			if(count($registration))
			$registrationRealization = RegistrationRealizationProcess::model()->findByAttributes(array('registration_transaction_id'=>$registration->id,'name'=>'Vehicle Inspection'));
			//$registrationRealization->registration_transaction_id = $this->header->id;
			//$registrationRealization->name = 'Vehicle Inspection';
			$registrationRealization->checked = 1;
			$registrationRealization->checked_by = Yii::app()->user->id;
			$registrationRealization->checked_date = date('Y-m-d');
			$registrationRealization->detail = 'Yes';
			$registrationRealization->save();
		}

		

	
		//var_dump(CJSON::encode($this->phoneDetails));

		//delete position
		$delete_array = array_diff($vehicleInspectionDetailId, $new_detail);
		if($delete_array != NULL)
		{
			$criteria = new CDbCriteria;
			$criteria->addInCondition('id',$delete_array);
			VehicleInspectionDetail::model()->deleteAll($criteria);
		}

		return $valid;

	}
}
