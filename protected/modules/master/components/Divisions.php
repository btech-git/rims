<?php

class Divisions extends CComponent
{
	public $header;
	public $positions;
	public $branchDetails;
	public $warehouseDetails;
	

	public function __construct($header, array $positions, array $branchDetails, array $warehouseDetails) 
	{
		$this->header = $header;
		$this->positions = $positions;
		$this->branchDetails = $branchDetails;
		$this->warehouseDetails = $warehouseDetails;
		
	}

	public function addDetail($positionId)
	{
		$position = new DivisionPosition();
		$position->position_id = $positionId;
		$positionData = Position::model()->findByPk($position->position_id);
		$position->position_name = $positionData->name;
		$this->positions[] = $position;
	}
	
	
	public function removeDetailAt($index)
	{
		array_splice($this->positions, $index, 1);
		//var_dump(CJSON::encode($this->details));
	}
	
	public function addBranchDetail($branchId)
	{
		$branchDetail = new DivisionBranch();
		$branchDetail->branch_id = $branchId;
		$branchData = Branch::model()->findByPk($branchDetail->branch_id);
		$branchDetail->branch_name = $branchData->name;
		$this->branchDetails[] = $branchDetail;
	}
	
	
	public function removeBranchDetailAt($index)
	{
		array_splice($this->branchDetails, $index, 1);
		//var_dump(CJSON::encode($this->details));
	}

	public function addWarehouseDetail($warehouseId)
	{
		$warehouseDetail = new WarehouseDivision();
		$warehouseDetail->warehouse_id = $warehouseId;
		$warehouseData = Warehouse::model()->findByPk($warehouseDetail->warehouse_id);
		$warehouseDetail->warehouse_name = $warehouseData->name;
		$this->warehouseDetails[] = $warehouseDetail;
	}
	
	
	public function removeWarehouseDetailAt($index)
	{
		array_splice($this->warehouseDetails, $index, 1);
		//var_dump(CJSON::encode($this->warehouseDetails));
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

		if (count($this->positions) > 0)
		{
			foreach ($this->positions as $position)
			{
				$fields = array('position_id');
				$valid = $position->validate($fields) && $valid;
			}
		}
		else {
			$valid = true;
		}

		if (count($this->branchDetails) > 0)
		{
			foreach ($this->branchDetails as $branchDetail)
			{
				$fields = array('branch_id');
				$valid = $branchDetail->validate($fields) && $valid;
			}
		}
		else {
			$valid = true;
		}

		if (count($this->warehouseDetails) > 0)
		{
			foreach ($this->warehouseDetails as $warehouseDetail)
			{
				$fields = array('warehouse_id');
				$valid = $warehouseDetail->validate($fields) && $valid;
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
		

		$positionDivs = DivisionPosition::model()->findAllByAttributes(array('division_id'=>$this->header->id));
		$divId = array();
		foreach($positionDivs as $positionDiv)
		{
			$divId[]=$positionDiv->id;
		}
		$new_detail = array();

		$divisionBranchs = DivisionBranch::model()->findAllByAttributes(array('division_id'=>$this->header->id));
		$branchId = array();
		foreach($divisionBranchs as $divisionBranch)
		{
			$branchId[]=$divisionBranch->id;
		}
		$new_branch = array();

		$divisionWarehouses = WarehouseDivision::model()->findAllByAttributes(array('division_id'=>$this->header->id));
		$warehouseId = array();
		foreach($divisionWarehouses as $divisionWarehouse)
		{
			$warehouseId[]=$divisionWarehouse->id;
		}
		$new_warehouse = array();
		

		//position
		foreach ($this->positions as $position)
		{
			$position->division_id = $this->header->id;
			
			$valid = $position->save(false) && $valid;
			$new_detail[] = $position->id;
			//echo 'test phone added';
		}

		//branch
		foreach ($this->branchDetails as $branchDetail)
		{
			$branchDetail->division_id = $this->header->id;
			
			$valid = $branchDetail->save(false) && $valid;
			$new_branch[] = $branchDetail->id;
			//echo 'test phone added';
		}

		//warehouse
		foreach ($this->warehouseDetails as $warehouseDetail)
		{
			$warehouseDetail->division_id = $this->header->id;
			
			$valid = $warehouseDetail->save(false) && $valid;
			$new_warehouse[] = $warehouseDetail->id;
			//echo 'test phone added';
		}

	
		//var_dump(CJSON::encode($this->phoneDetails));

		//delete position
		$delete_array = array_diff($divId, $new_detail);
		if($delete_array != NULL)
		{
			$criteria = new CDbCriteria;
			$criteria->addInCondition('id',$delete_array);
			DivisionPosition::model()->deleteAll($criteria);
		}

		//delete branch
		$delete_branch_array = array_diff($branchId, $new_branch);
		if($delete_branch_array != NULL)
		{
			$branchcriteria = new CDbCriteria;
			$branchcriteria->addInCondition('id',$delete_branch_array);
			DivisionBranch::model()->deleteAll($branchcriteria);
		}

		//delete warehouse
		$delete_warehouse_array = array_diff($warehouseId, $new_warehouse);
		if($delete_warehouse_array != NULL)
		{
			$warehousecriteria = new CDbCriteria;
			$warehousecriteria->addInCondition('id',$delete_warehouse_array);
			//print_r($warehousecriteria); exit;
			WarehouseDivision::model()->deleteAll($warehousecriteria);
		}

		

		return $valid;

	}
}
