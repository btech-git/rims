<?php
/* @var $this ConsignmentOutHeaderController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Consignment Out Headers',
);

$this->menu=array(
	array('label'=>'Create ConsignmentOutHeader', 'url'=>array('create')),
	array('label'=>'Manage ConsignmentOutHeader', 'url'=>array('admin')),
);
?>

<h1>Consignment Out Headers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
