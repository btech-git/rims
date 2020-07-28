<?php

class Warehouses extends CComponent
{
	public $header;
	public $branchDetails;
	public $divisionDetails;
	public $sectionDetails;
	

	public function __construct($header, array $branchDetails, array $divisionDetails, array $sectionDetails) 
	{
		$this->header = $header;
		$this->branchDetails = $branchDetails;
		$this->divisionDetails = $divisionDetails;
		$this->sectionDetails = $sectionDetails;
	}

	public function addDetail($branchId)
	{
		$branchDetail = new BranchWarehouse();
		$branchDetail->branch_id = $branchId;
		$branchData = Branch::model()->findByPk($branchDetail->branch_id);
		$branchDetail->branch_name = $branchData->name;
		$this->branchDetails[] = $branchDetail;
	}
	
	
	public function removeDetailAt($index)
	{
		array_splice($this->branchDetails, $index, 1);
		//var_dump(CJSON::encode($this->details));
	}

	public function addDivisionDetail($divisionId)
	{
		$divisionDetail = new WarehouseDivision();
		$divisionDetail->division_id = $divisionId;
		$divisionData = Division::model()->findByPk($divisionDetail->division_id);
		$divisionDetail->division_name = $divisionData->name;
		$this->divisionDetails[] = $divisionDetail;
	}
	
	public function removeDivisionDetailAt($index)
	{
		array_splice($this->divisionDetails, $index, 1);
		//var_dump(CJSON::encode($this->details));
	}
	
	public function addSectionDetail($column,$row)
	{
		$oldSectionDetails = $this->sectionDetails;

		$this->sectionDetails = array();
		$c = $column;
		$r = $row;
		//$column = $header->warehouse->column;
		//$row = $header->warehouse->row;
		$totalSection = $c * $r;
		$alphabet = range('A', 'Z');

		//echo(count($this->sectionDetails));
			
		//var_dump($totalSection);
		$index = 0;
		for($i=0; $i<$c; $i++){
			for($j=0; $j<$r; $j++){
				$sectionDetail = new WarehouseSection();
				$sectionDetail->code = $alphabet[$i] . $j;
				if(isset($_POST['WarehouseSection']) && isset($_POST['WarehouseSection'][$index]['rack_number'])){
					$sectionDetail->rack_number = $_POST['WarehouseSection'][$index]['rack_number'];
				}
				if(isset($_POST['WarehouseSection']) && isset($_POST['WarehouseSection'][$index]['product_id'])){
					if(isset($_POST['WarehouseSection'][$index]['product_id']) && $_POST['WarehouseSection'][$index]['product_id'] != NULL){
						$sectionDetail->product_id = $_POST['WarehouseSection'][$index]['product_id'];
						$sectionDetail->product_name = Product::model()->findByPk($_POST['WarehouseSection'][$index]['product_id'])->name;
					}
					if(isset($_POST['WarehouseSection'][$index]['rack_number']) && $_POST['WarehouseSection'][$index]['rack_number'] != NULL){
						$sectionDetail->rack_number = $_POST['WarehouseSection'][$index]['rack_number'];
					}
				}
				if(isset($_POST['WarehouseSection']) && isset($_POST['WarehouseSection'][$index]['rack_number'])){
					$sectionDetail->rack_number = $_POST['WarehouseSection'][$index]['rack_number'];
				}
				$this->sectionDetails[] = $sectionDetail;
				$index++;
			}
		}
	}

	public function assignSection($id)
	{
		$warehouses = $_POST['Warehouse']['warehouses'];
		//print_r($warehouses);
		//print_r($id);
		$main = Warehouse::model()->findByPk($id);

		//print_r($main->warehouseSections);
		foreach ($warehouses as $w) {
			WarehouseSection::model()->deleteAll('`warehouse_id` = :warehouse_id',array(
			    ':warehouse_id'=>$w,
			));
			foreach($main->warehouseSections as $section){
				$newSection = new WarehouseSection();
				$newSection->warehouse_id = $w;
				$newSection->code = $section->code;
				$newSection->product_id = $section->product_id;
				$newSection->rack_number = $section->rack_number;
				$newSection->save(false);
			}

		}
		
		
	}

	/*public function addSectionDetail()
	{
		$sectionDetail = new WarehouseSection();
		//$sectionDetail->division_id = $divisionId;
		//$divisionData = Division::model()->findByPk($sectionDetail->division_id);
		//$sectionDetail->division_name = $divisionData->name;
		$this->sectionDetails[] = $sectionDetail;
	}*/

	public function removeSectionDetailAt($index)
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

		if (count($this->divisionDetails) > 0)
		{
			foreach ($this->divisionDetails as $divisionDetail)
			{
				$fields = array('division_id');
				$valid = $divisionDetail->validate($fields) && $valid;
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
		if (count($this->branchDetails) === 0)
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
		

		$warehouseBranches = BranchWarehouse::model()->findAllByAttributes(array('warehouse_id'=>$this->header->id));
		$branchId = array();
		foreach($warehouseBranches as $warehouseBranch)
		{
			$branchId[]=$warehouseBranch->id;
		}
		$new_detail = array();

		$warehouseDivisions = WarehouseDivision::model()->findAllByAttributes(array('warehouse_id'=>$this->header->id));
		$divisionId = array();
		foreach($warehouseDivisions as $warehouseDivision)
		{
			$divisionId[]=$warehouseDivision->id;
		}
		$new_division = array();

		$warehouseSections = WarehouseSection::model()->findAllByAttributes(array('warehouse_id'=>$this->header->id));
		$sectionId = array();
		foreach($warehouseSections as $warehouseSection)
		{
			$sectionId[]=$warehouseSection->id;
		}
		$new_section = array();


		//Branch
		foreach ($this->branchDetails as $branchDetail)
		{
			$branchDetail->warehouse_id = $this->header->id;
			
			$valid = $branchDetail->save(false) && $valid;
			$new_detail[] = $branchDetail->id;
			//echo 'test phone added';
		}

		//Division
		foreach ($this->divisionDetails as $divisionDetail)
		{
			$divisionDetail->warehouse_id = $this->header->id;
			
			$valid = $divisionDetail->save(false) && $valid;
			$new_division[] = $divisionDetail->id;
			//echo 'test phone added';
		}

		//Section
		foreach ($this->sectionDetails as $sectionDetail)
		{
			$sectionDetail->warehouse_id = $this->header->id;
			if($sectionDetail->product_id != NULL && $sectionDetail->rack_number != NULL){
				$valid = $sectionDetail->save(false) && $valid;
				$new_section[] = $sectionDetail->id;
			}
			//echo 'test phone added';
		}
		

		//delete Branch
		$delete_array = array_diff($branchId, $new_detail);
		if($delete_array != NULL)
		{
			$criteria = new CDbCriteria;
			$criteria->addInCondition('id',$delete_array);
			BranchWarehouse::model()->deleteAll($criteria);
		}

		//Division
		$division_delete_array = array_diff($divisionId, $new_division);
		if($division_delete_array != NULL)
		{
			$divisioncriteria = new CDbCriteria;
			$divisioncriteria->addInCondition('id',$division_delete_array);
			WarehouseDivision::model()->deleteAll($divisioncriteria);
		}

		//Division
		$section_delete_array = array_diff($sectionId, $new_section);
		if($section_delete_array != NULL)
		{
			$sectioncriteria = new CDbCriteria;
			$sectioncriteria->addInCondition('id',$section_delete_array);
			WarehouseSection::model()->deleteAll($sectioncriteria);
		}

		

		return $valid;

	}
}
