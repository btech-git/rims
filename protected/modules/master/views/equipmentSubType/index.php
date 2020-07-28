<?php
/* @var $this EquipmentSubTypeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Equipment Sub Types',
);

$this->menu=array(
	array('label'=>'Create EquipmentSubType', 'url'=>array('create')),
	array('label'=>'Manage EquipmentSubType', 'url'=>array('admin')),
);
?>

<h1>Equipment Sub Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
