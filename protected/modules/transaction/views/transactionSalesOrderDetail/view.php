<?php
/* @var $this TransactionSalesOrderDetailController */
/* @var $model TransactionSalesOrderDetail */

$this->breadcrumbs=array(
	'Transaction Sales Order Details'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TransactionSalesOrderDetail', 'url'=>array('index')),
	array('label'=>'Create TransactionSalesOrderDetail', 'url'=>array('create')),
	array('label'=>'Update TransactionSalesOrderDetail', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TransactionSalesOrderDetail', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TransactionSalesOrderDetail', 'url'=>array('admin')),
);
?>

<h1>View TransactionSalesOrderDetail #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'sales_order_id',
		'product_id',
		'unit_id',
		'retail_price',
		'quantity',
		'unit_price',
		'amount',
		'discount_step',
		'discount1_type',
		'discount1_nominal',
		'discount1_temp_quantity',
		'discount1_temp_price',
		'discount2_type',
		'discount2_nominal',
		'discount2_temp_quantity',
		'discount2_temp_price',
		'discount3_type',
		'discount3_nominal',
		'discount3_temp_quantity',
		'discount3_temp_price',
		'discount4_type',
		'discount4_nominal',
		'discount4_temp_quantity',
		'discount4_temp_price',
		'discount5_type',
		'discount5_nominal',
		'discount5_temp_quantity',
		'discount5_temp_price',
		'total_quantity',
		'total_price',
	),
)); ?>
