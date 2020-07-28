<?php

class Equipment extends CComponent
{
	public $header;
	public $equipmentDetails;
	public $taskDetails;
	public $equipmentMaintenances1;

	//public function __construct($header, array $branchDetails, array $taskDetails) 
	public function __construct($header, array $equipmentDetails, array $taskDetails, array $equipmentMaintenances1) 
	{
		$this->header = $header;
		$this->equipmentDetails = $equipmentDetails;	
		$this->taskDetails = $taskDetails;	
		$this->equipmentMaintenances1 = $equipmentMaintenances1;	
	}
	
	public function addMaintenanceDetail()
	{
		$equipmentMaintenances1 = new equipmentMaintenances();
		$this->equipmentMaintenances1[] = $equipmentMaintenances1;
	}
	
	
	public function removeMaintenanceDetailAt($index)
	{
		array_splice($this->equipmentMaintenances1, $index, 1);
	}
	
	public function addEquipmentDetail()
	{
		$equipmentDetail = new EquipmentDetails();
		$this->equipmentDetails[] = $equipmentDetail;
	}
	
	
	public function removeEquipmentDetailAt($index)
	{
		array_splice($this->equipmentDetails, $index, 1);
	}
	
	public function addTaskDetail()
	{
		$taskDetail = new EquipmentTask();
		$this->taskDetails[] = $taskDetail;
	}
	
	public function removeTaskDetailAt($index)
	{
		array_splice($this->taskDetails, $index, 1);
	}

	
	public function save($dbConnection)
	{
		$dbTransaction = $dbConnection->beginTransaction();
		try
		{
			$valid = $this->validate() && $this->flush();
			if ($valid){
				$dbTransaction->commit();
			} else {
				$dbTransaction->rollback();
			}

		}
		catch (Exception $e)
		{
			$dbTransaction->rollback();
			$valid = false;
			//echo "in catch";
			//echo "<pre>";
			//print_r($e);
		}

		return $valid;
		//echo "123";
		//print_r('success');
	}

	public function validate()
	{
		$valid = $this->header->validate();

		//$valid = $this->validateDetailsCount() && $valid;

		if (count($this->equipmentDetails) > 0)
		{
			foreach ($this->equipmentDetails as $equipmentDetail)
			{
				$fields = array('purchase_date','age');
				$valid = $equipmentDetail->validate($fields) && $valid;
			}
		}
		else {
			$valid = true;
		}
		
		
		if (count($this->taskDetails) > 0)
		{
			foreach ($this->taskDetails as $taskDetail)
			{
				$fields = array('task','check_period');
				$valid = $taskDetail->validate($fields) && $valid;
			}
		}
		else {
			$valid = true;
		}
		
		if (count($this->equipmentMaintenances1) > 0)
		{
			foreach ($this->equipmentMaintenances1 as $equipmentMaintenance)
			{
				$fields = array('maintenance_date','next_maintenance_date');
				$valid = $equipmentMaintenance->validate($fields) && $valid;
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
		if (count($this->positions) === 0)
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
		//exit;
		//equipment details
		$equipmentDetails = EquipmentDetails::model()->findAllByAttributes(array('equipment_id'=>$this->header->id));
		$detailId = array();
		foreach($equipmentDetails as $equipmentDetail)
		{
			$detailId[]=$equipmentDetail->id;
		}
		$new_detail = array();
		
		//detail
		foreach ($this->equipmentDetails as $equipmentDetail)
		{
			$equipmentDetail->equipment_id = $this->header->id;			
			$valid = $equipmentDetail->save(false) && $valid;
			$new_branch[] = $equipmentDetail->id;
			//echo 'test detail added';
		}
		
		//delete detail
		/*$delete_detail_array = array_diff($detailId, $new_detail);
		if($delete_detail_array != NULL)
		{
			$detailcriteria = new CDbCriteria;
			$detailcriteria->addInCondition('id',$delete_detail_array);
			EquipmentDetails::model()->deleteAll($detailcriteria);
		}*/
		
		
		// equipment Tasks
		$equipmentTasks = EquipmentTask::model()->findAllByAttributes(array('equipment_id'=>$this->header->id));
		$taskId = array();
		foreach($equipmentTasks as $equipmentTask)
		{
			$taskId[]=$equipmentTask->id;
		}
		$new_task = array();

		//task
		foreach($this->taskDetails as $taskDetail)
		{
			$taskDetail->equipment_id = $this->header->id;
			$valid = $taskDetail->save(false) && $valid;
			$new_task[] = $taskDetail->id;
		}		
		
		// Delete Task
		/*$delete_task = array_diff($taskId,$new_task);
		if($delete_task != NULL)
		{
			$task_criteria = new CDbCriteria;
			$task_criteria->addInCondition('id',$delete_task);
			EquipmentTask::model()->deleteAll($task_criteria);
		}*/	
		
		// equipment Maintenances
		$equipmentMaintenances1 = EquipmentMaintenances::model()->findAllByAttributes(array('equipment_id'=>$this->header->id));
		$maintenanceId = array();
		foreach($equipmentMaintenances1 as $equipmentMaintenance)
		{
			$maintenanceId[]=$equipmentMaintenance->id;
		}
		$new_maintenance = array();

		//Maintenances
		foreach($this->equipmentMaintenances1 as $equipmentMaintenance)
		{
			$equipmentMaintenance->equipment_id = $this->header->id;
			$valid = $equipmentMaintenance->save(false) && $valid;
			$new_maintenance[] = $equipmentMaintenance->id;
			//echo "1"; exit;
		}		
		
		//print_r($new_maintenance); exit;
		// Delete Maintenances
		/*$delete_maintenance = array_diff($maintenanceId,$new_maintenance);
		if($delete_maintenance != NULL)
		{
			$maintenance_criteria = new CDbCriteria;
			$maintenance_criteria->addInCondition('id',$delete_maintenance);
			EquipmentMaintenances::model()->deleteAll($z);
		}*/	
		
		
		

		return $valid;

	}
}
