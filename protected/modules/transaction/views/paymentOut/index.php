<?php
/* @var $this PaymentOutController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Payment Outs',
);

$this->menu=array(
	array('label'=>'Create PaymentOut', 'url'=>array('create')),
	array('label'=>'Manage PaymentOut', 'url'=>array('admin')),
);
?>

<h1>Payment Outs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
