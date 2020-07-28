<?php
/* @var $this EquipmentMaintenancesController */
/* @var $model EquipmentMaintenances */

$this->breadcrumbs=array(
	'Product',
	'Equipment Maintenances'=>array('admin'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List EquipmentMaintenances', 'url'=>array('index')),
	array('label'=>'Manage EquipmentMaintenances', 'url'=>array('admin')),
);*/
?>



		<div id="maincontent">
			<?php $this->renderPartial('_form', array('model'=>$model)); ?>			
		</div>