<?php
/* @var $this PaymentTypeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Payment Types',
);

$this->menu=array(
	array('label'=>'Create PaymentType', 'url'=>array('create')),
	array('label'=>'Manage PaymentType', 'url'=>array('admin')),
);
?>

<h1>Payment Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
