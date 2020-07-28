<?php

class Positions extends CComponent
{
	public $header;
	//public $divisonDetails;
	public $levelDetails;
	

	public function __construct($header, array $levelDetails) 
	{
		$this->header = $header;
		//$this->divisonDetails = $divisonDetails;
		$this->levelDetails = $levelDetails;
		
	}

	public function addLevelDetail($levelId)
	{
		$level = new PositionLevel();
		$level->level_id = $levelId;
		$levelData = Level::model()->findByPk($level->level_id);
		//$level->position_name = $positionData->name;
		$this->levelDetails[] = $level;
	}
	
	
	public function removeDetailAt($index)
	{
		array_splice($this->levelDetails, $index, 1);
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
				// print_r('1');
			} else {
				$dbTransaction->rollback();
				// print_r('2');
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

		if (count($this->levelDetails) > 0)
		{
			foreach ($this->levelDetails as $levelDetail)
			{
				$fields = array('level_id');
				$valid = $levelDetail->validate($fields) && $valid;
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
		

		$posLevels = PositionLevel::model()->findAllByAttributes(array('position_id'=>$this->header->id));
		$posId = array();
		foreach($posLevels as $posLevel)
		{
			$posId[]=$posLevel->id;
		}
		$new_detail = array();

		

		//level
		foreach ($this->levelDetails as $levelDetail)
		{
			$levelDetail->position_id = $this->header->id;
			
			$valid = $levelDetail->save(false) && $valid;
			$new_detail[] = $levelDetail->id;
			// echo "test";
			//echo 'test phone added';
		}

	
		//var_dump(CJSON::encode($this->phoneDetails));

		//delete position
		$delete_array = array_diff($posId, $new_detail);
		if($delete_array != NULL)
		{
			$criteria = new CDbCriteria;
			$criteria->addInCondition('id',$delete_array);
			PositionLevel::model()->deleteAll($criteria);
		}

		

		return $valid;

	}
}
