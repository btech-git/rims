<?php
/* @var $this EquipmentMaintenanceController */
/* @var $model EquipmentMaintenance */

$this->breadcrumbs=array(
	'Product',
	'Equipment Maintenances'=>array('admin'),
	'Create Equipment Maintenance',
);

/*$this->menu=array(
	array('label'=>'List EquipmentMaintenance', 'url'=>array('index')),
	array('label'=>'Manage EquipmentMaintenance', 'url'=>array('admin')),
);*/
?>



		<div id="maincontent">
			<?php $this->renderPartial('_form', array('model'=>$model)); ?>			
		</div>