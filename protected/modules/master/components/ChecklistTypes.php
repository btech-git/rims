<?php

class ChecklistTypes extends CComponent
{
	public $header;
	//public $divisonDetails;
	public $checklistModuleDetails;
	

	public function __construct($header, array $checklistModuleDetails) 
	{
		$this->header = $header;
		//$this->divisonDetails = $divisonDetails;
		$this->checklistModuleDetails = $checklistModuleDetails;
		
	}

	public function addChecklistModuleDetail($checklistModuleId)
	{
		$checklistModule = new InspectionChecklistTypeModule();
		$checklistModule->checklist_module_id = $checklistModuleId;
		//$levelData = Level::model()->findByPk($level->level_id);
		//$level->position_name = $positionData->name;
		$this->checklistModuleDetails[] = $checklistModule;
	}
	
	
	public function removeDetailAt($index)
	{
		array_splice($this->checklistModuleDetails, $index, 1);
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
				print_r('1');
			} else {
				$dbTransaction->rollback();
				print_r('2');
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

		if (count($this->checklistModuleDetails) > 0)
		{
			foreach ($this->checklistModuleDetails as $checklistModuleDetail)
			{
				$fields = array('checklist_module_id');
				$valid = $checklistModuleDetail->validate($fields) && $valid;
				echo $valid;
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
		if (count($this->levelDetails) === 0)
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
		

		$checklistTypeModules = InspectionChecklistTypeModule::model()->findAllByAttributes(array('checklist_type_id'=>$this->header->id));
		$checklistTypeId = array();
		foreach($checklistTypeModules as $checklistTypeModule)
		{
			$checklistTypeId[]=$checklistTypeModule->id;
		}
		$new_detail = array();

		

		//Checklist Module
		foreach ($this->checklistModuleDetails as $checklistModuleDetail)
		{
			$checklistModuleDetail->checklist_type_id = $this->header->id;
			
			$valid = $checklistModuleDetail->save(false) && $valid;
			$new_detail[] = $checklistModuleDetail->id;
			//echo "test";
			echo 'test phone added';
		}

	
		//var_dump(CJSON::encode($this->phoneDetails));

		//delete position
		$delete_array = array_diff($checklistTypeId, $new_detail);
		if($delete_array != NULL)
		{
			$criteria = new CDbCriteria;
			$criteria->addInCondition('id',$delete_array);
			InspectionChecklistTypeModule::model()->deleteAll($criteria);
		}

		return $valid;

	}
}
