<?php
/* @var $this EquipmentMaintenancesController */
/* @var $model EquipmentMaintenances */

$this->breadcrumbs=array(
	'Product',
	'Equipment Maintenances'=>array('admin'),
	'Update Equipment Maintenances',
);

/* $this->menu=array(
	array('label'=>'List EquipmentMaintenances', 'url'=>array('index')),
	array('label'=>'Create EquipmentMaintenances', 'url'=>array('create')),
	array('label'=>'View EquipmentMaintenances', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage EquipmentMaintenances', 'url'=>array('admin')),
);*/
?>


	
		<div id="maincontent">
			<?php $this->renderPartial('_form', array('model'=>$model)); ?>			
		</div>