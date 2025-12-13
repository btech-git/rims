<?php
/* @var $this TireSizeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Tire Sizes',
);

$this->menu=array(
	array('label'=>'Create TireSize', 'url'=>array('create')),
	array('label'=>'Manage TireSize', 'url'=>array('admin')),
);
?>

<h1>Tire Sizes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
