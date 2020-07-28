<?php
/* @var $this EquipmentDetailsController */
/* @var $model EquipmentDetails */

$this->breadcrumbs=array(
	'Product',
	'Equipment Details'=>array('admin'),
	//$model->id=>array('view','id'=>$model->id),
	'Update Equipment Details',
);

/*$this->menu=array(
	array('label'=>'List EquipmentDetails', 'url'=>array('index')),
	array('label'=>'Create EquipmentDetails', 'url'=>array('create')),
	array('label'=>'View EquipmentDetails', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage EquipmentDetails', 'url'=>array('admin')),
);*/
?>


	
		<div id="maincontent">
			<?php 
			$this->renderPartial('update_details_form', 
				array(
			'equipmentDetails' 		=>$equipmentDetails,
			'dailyTasks' 	  		=>$dailyTasks,
			'weeklyTasks'     		=>$weeklyTasks,
			'monthlyTasks'    		=>$monthlyTasks,
			'quarterlyTasks'  		=>$quarterlyTasks,
			'halfyearlyTasks' 		=>$halfyearlyTasks,
			'yearlyTasks'     		=>$yearlyTasks,
			'tasksCount'      		=>$tasksCount,
			'maintenanceCount' 		=>$maintenanceCount,
			'detailEquipments'      =>$detailEquipments,)); ?>	

				
		</div>
