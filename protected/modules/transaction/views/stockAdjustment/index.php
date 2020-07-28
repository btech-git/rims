<?php
/* @var $this StockAdjustmentController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Stock Adjustment Headers',
);

$this->menu=array(
	array('label'=>'Create StockAdjustmentHeader', 'url'=>array('create')),
	array('label'=>'Manage StockAdjustmentHeader', 'url'=>array('admin')),
);
?>

<h1>Stock Adjustment Headers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
