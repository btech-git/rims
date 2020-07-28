<?php
/* @var $this EquipmentTaskController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Equipment Tasks',
);

$this->menu=array(
	array('label'=>'Create EquipmentTask', 'url'=>array('create')),
	array('label'=>'Manage EquipmentTask', 'url'=>array('admin')),
);
?>

<h1>Equipment Tasks</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
