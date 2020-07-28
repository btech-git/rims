<?php
/* @var $this ConsignmentInDetailController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Consignment In Details',
);

$this->menu=array(
	array('label'=>'Create ConsignmentInDetail', 'url'=>array('create')),
	array('label'=>'Manage ConsignmentInDetail', 'url'=>array('admin')),
);
?>

<h1>Consignment In Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
