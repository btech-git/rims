<?php
/* @var $this ConsignmentOutDetailController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Consignment Out Details',
);

$this->menu=array(
	array('label'=>'Create ConsignmentOutDetail', 'url'=>array('create')),
	array('label'=>'Manage ConsignmentOutDetail', 'url'=>array('admin')),
);
?>

<h1>Consignment Out Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
