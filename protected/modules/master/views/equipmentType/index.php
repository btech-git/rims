<?php
/* @var $this EquipmentTypeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Equipment Types',
);

$this->menu=array(
	array('label'=>'Create EquipmentType', 'url'=>array('create')),
	array('label'=>'Manage EquipmentType', 'url'=>array('admin')),
);
?>

<h1>Equipment Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
