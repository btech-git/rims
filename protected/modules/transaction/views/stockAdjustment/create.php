<?php
/* @var $this StockAdjustmentController */
/* @var $model StockAdjustmentHeader */

$this->breadcrumbs=array(
	'Stock Adjustment Headers'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List StockAdjustmentHeader', 'url'=>array('index')),
	array('label'=>'Manage StockAdjustmentHeader', 'url'=>array('admin')),
);
?>

<h1>Create Stock Adjustment</h1>

<?php $this->renderPartial('_form', array(
	'model'=>$model,
	'modelDetail'=>$modelDetail,
	'product'=>$product,
	'warehouse'=>$warehouse)
	); 
?>