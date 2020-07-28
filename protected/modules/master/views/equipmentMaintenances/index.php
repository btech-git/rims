<?php
/* @var $this EquipmentMaintenancesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Equipment Maintenances',
);

$this->menu=array(
	array('label'=>'Create EquipmentMaintenances', 'url'=>array('create')),
	array('label'=>'Manage EquipmentMaintenances', 'url'=>array('admin')),
);
?>

<h1>Equipment Maintenances</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
