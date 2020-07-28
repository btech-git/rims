<?php
/* @var $this UnitController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Units',
);

$this->menu=array(
	array('label'=>'Create Unit', 'url'=>array('create')),
	array('label'=>'Manage Unit', 'url'=>array('admin')),
);
?>

<h1>Units</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
