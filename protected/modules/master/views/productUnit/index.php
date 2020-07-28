<?php
/* @var $this ProductUnitController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Product Units',
);

$this->menu=array(
	array('label'=>'Create ProductUnit', 'url'=>array('create')),
	array('label'=>'Manage ProductUnit', 'url'=>array('admin')),
);
?>

<h1>Product Units</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
