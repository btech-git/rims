<?php
/* @var $this InvoiceDetailController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Invoice Details',
);

$this->menu=array(
	array('label'=>'Create InvoiceDetail', 'url'=>array('create')),
	array('label'=>'Manage InvoiceDetail', 'url'=>array('admin')),
);
?>

<h1>Invoice Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
