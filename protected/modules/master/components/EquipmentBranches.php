<?php

class EquipmentBranches extends CComponent
{
	public $header;
	public $equipmentMaintenances;
	
	public function __construct($header, array $equipmentMaintenances) 
	{
		$this->header = $header;
		$this->equipmentMaintenances = $equipmentMaintenances;	
	}
	
	public function addMaintainanceDetail()
	{
		$maintainanceDetail = new EquipmentMaintenance();
		$this->equipmentMaintenances[] = $maintainanceDetail;
	}
	
	
	public function removeMaintainanceDetailAt($index)
	{
		array_splice($this->equipmentMaintenances, $index, 1);
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

		if (count($this->equipmentMaintenances) > 0)
		{
			foreach ($this->equipmentMaintenances as $equipmentMaintenance)
			{
				$fields = array('equipment_task_id','employee_id','maintenance_date','next_maintenance_date','check_date');
				$valid = $equipmentMaintenance->validate($fields) && $valid;
			}
		}
		else {
			$valid = true;
		}
		
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

		//maintenance
		$equipmentMaintenances = EquipmentMaintenance::model()->findAllByAttributes(array('equipment_branch_id'=>$this->header->id));
		$maintenanceId = array();
		foreach($equipmentMaintenances as $equipmentMaintenance)
		{
			$maintenanceId[]=$equipmentMaintenance->id;
		}
		$new_maintenance = array();
		
		//maintenance
		foreach ($this->equipmentMaintenances as $maintainanceDetail)
		{
			$maintainanceDetail->equipment_branch_id = $this->header->id;			
			$valid = $maintainanceDetail->save(false) && $valid;
			$new_maintenance[] = $maintainanceDetail->id;
		}

		//delete maintenance
		$delete_maintenance_array = array_diff($maintenanceId, $new_maintenance);
		if($delete_maintenance_array != NULL)
		{
			$maintainancecriteria = new CDbCriteria;
			$maintainancecriteria->addInCondition('id',$delete_maintenance_array);
			EquipmentMaintenance::model()->deleteAll($maintainancecriteria);
		}		

		return $valid;

	}
}
