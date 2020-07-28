<?php

class Inspections extends CComponent
{
	public $header;
	//public $divisonDetails;
	public $sectionDetails;
	

	public function __construct($header, array $sectionDetails) 
	{
		$this->header = $header;
		//$this->divisonDetails = $divisonDetails;
		$this->sectionDetails = $sectionDetails;
		
	}

	public function addSectionDetail($sectionId)
	{
		$section = new InspectionSections();
		$section->section_id = $sectionId;
		//$levelData = Level::model()->findByPk($level->level_id);
		//$level->position_name = $positionData->name;
		$this->sectionDetails[] = $section;
	}
	
	
	public function removeDetailAt($index)
	{
		array_splice($this->sectionDetails, $index, 1);
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

		if (count($this->sectionDetails) > 0)
		{
			foreach ($this->sectionDetails as $sectionDetail)
			{
				$fields = array('section_id');
				$valid = $sectionDetail->validate($fields) && $valid;
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
		if (count($this->sectionDetails) === 0)
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
		

		$inspectionSections = InspectionSections::model()->findAllByAttributes(array('inspection_id'=>$this->header->id));
		$inspectionId = array();
		foreach($inspectionSections as $inspectionSection)
		{
			$inspectionId[]=$inspectionSection->id;
		}
		$new_detail = array();

		//Checklist Module
		foreach ($this->sectionDetails as $sectionDetail)
		{
			$sectionDetail->inspection_id = $this->header->id;
			
			$valid = $sectionDetail->save(false) && $valid;
			$new_detail[] = $sectionDetail->id;
			//echo "test";
			//echo 'test phone added';
		}

	
		//var_dump(CJSON::encode($this->phoneDetails));

		//delete position
		$delete_array = array_diff($inspectionId, $new_detail);
		if($delete_array != NULL)
		{
			$criteria = new CDbCriteria;
			$criteria->addInCondition('id',$delete_array);
			InspectionSections::model()->deleteAll($criteria);
		}

		return $valid;

	}
}
