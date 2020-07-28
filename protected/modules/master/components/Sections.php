<?php

class Sections extends CComponent
{
	public $header;
	//public $divisonDetails;
	public $moduleDetails;
	

	public function __construct($header, array $moduleDetails) 
	{
		$this->header = $header;
		//$this->divisonDetails = $divisonDetails;
		$this->moduleDetails = $moduleDetails;
		
	}

	public function addModuleDetail($moduleId)
	{
		$module = new InspectionSectionModule();
		$module->module_id = $moduleId;
		//$levelData = Level::model()->findByPk($level->level_id);
		//$level->position_name = $positionData->name;
		$this->moduleDetails[] = $module;
	}
	
	
	public function removeDetailAt($index)
	{
		array_splice($this->moduleDetails, $index, 1);
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

		if (count($this->moduleDetails) > 0)
		{
			foreach ($this->moduleDetails as $moduleDetail)
			{
				$fields = array('module_id');
				$valid = $moduleDetail->validate($fields) && $valid;
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
		if (count($this->moduleDetails) === 0)
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
		

		$sectionModules = InspectionSectionModule::model()->findAllByAttributes(array('section_id'=>$this->header->id));
		$sectionId = array();
		foreach($sectionModules as $sectionModule)
		{
			$sectionId[]=$sectionModule->id;
		}
		$new_detail = array();

		

		//Checklist Module
		foreach ($this->moduleDetails as $moduleDetail)
		{
			$moduleDetail->section_id = $this->header->id;
			
			$valid = $moduleDetail->save(false) && $valid;
			$new_detail[] = $moduleDetail->id;
			//echo "test";
			//echo 'test phone added';
		}

	
		//var_dump(CJSON::encode($this->phoneDetails));

		//delete position
		$delete_array = array_diff($sectionId, $new_detail);
		if($delete_array != NULL)
		{
			$criteria = new CDbCriteria;
			$criteria->addInCondition('id',$delete_array);
			InspectionSectionModule::model()->deleteAll($criteria);
		}

		return $valid;

	}
}
