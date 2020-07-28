<?php
/* @var $this EquipmentMaintenanceController */
/* @var $model EquipmentMaintenance */

$this->breadcrumbs=array(
	'Product',
	'Equipment Maintenances'=>array('admin'),
	'Update Equipment Maintenance',
);

/*$this->menu=array(
	array('label'=>'List EquipmentMaintenance', 'url'=>array('index')),
	array('label'=>'Create EquipmentMaintenance', 'url'=>array('create')),
	array('label'=>'View EquipmentMaintenance', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage EquipmentMaintenance', 'url'=>array('admin')),
);*/
?>



		<div id="maincontent">
			<?php $this->renderPartial('_form', array('model'=>$model)); ?>			
		</div>