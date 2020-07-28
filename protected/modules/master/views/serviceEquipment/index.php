<?php
/* @var $this ServiceEquipmentController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Service Equipments',
);

$this->menu=array(
	array('label'=>'Create ServiceEquipment', 'url'=>array('create')),
	array('label'=>'Manage ServiceEquipment', 'url'=>array('admin')),
);
?>

<h1>Service Equipments</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
