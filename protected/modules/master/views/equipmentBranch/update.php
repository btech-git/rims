<?php
/* @var $this EquipmentBranchController */
/* @var $model EquipmentBranch */

$this->breadcrumbs=array(
	'Product',
	'Equipment Branches'=>array('admin'),
	'Update Equipment Branch',
);

/*$this->menu=array(
	array('label'=>'List EquipmentBranch', 'url'=>array('index')),
	array('label'=>'Create EquipmentBranch', 'url'=>array('create')),
	array('label'=>'View EquipmentBranch', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage EquipmentBranch', 'url'=>array('admin')),
);
*/
?>



		<div id="maincontent">
			<?php $this->renderPartial('update_branch_form', 
			array(
			'equipmentBranch'=>$equipmentBranch,
			'dailyTasks' =>$dailyTasks,
			'weeklyTasks' =>$weeklyTasks,
			'monthlyTasks' =>$monthlyTasks,
			'quarterlyTasks' =>$quarterlyTasks,
			'halfyearlyTasks' =>$halfyearlyTasks,
			'yearlyTasks' => $yearlyTasks,
			//'equipmentBranchTasks'=>$equipmentBranchTasks,			
			'tasksCount'      		=>$tasksCount,
			'maintenanceCount' 		=>$maintenanceCount,
			'branchEquipments'      =>$branchEquipments,)); ?>			
		</div>