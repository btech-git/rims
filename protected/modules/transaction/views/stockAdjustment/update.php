<?php
/* @var $this StockAdjustmentController */
/* @var $model StockAdjustmentHeader */

$this->breadcrumbs=array(
	'Stock Adjustment Headers'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List StockAdjustmentHeader', 'url'=>array('index')),
	array('label'=>'Create StockAdjustmentHeader', 'url'=>array('create')),
	array('label'=>'View StockAdjustmentHeader', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage StockAdjustmentHeader', 'url'=>array('admin')),
);
?>

<h1>Update StockAdjustmentHeader <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model,
	'modelDetail'=>$modelDetail,
	'product'=>$product,
	'warehouse'=>$warehouse,
	'modelApproval'=>$modelApproval,
	'listApproval'=>$listApproval,
)); ?>