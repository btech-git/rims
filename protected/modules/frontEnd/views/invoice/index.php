<?php
/* @var $this InvoiceHeaderController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Invoice Headers',
);

$this->menu=array(
	array('label'=>'Create InvoiceHeader', 'url'=>array('create')),
	array('label'=>'Manage InvoiceHeader', 'url'=>array('admin')),
);
?>

<h1>Invoice Headers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
