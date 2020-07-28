<?php
/* @var $this RegistrationProductController */
/* @var $model RegistrationProduct */

$this->breadcrumbs=array(
	'Registration Products'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List RegistrationProduct', 'url'=>array('index')),
	array('label'=>'Create RegistrationProduct', 'url'=>array('create')),
	array('label'=>'Update RegistrationProduct', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete RegistrationProduct', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage RegistrationProduct', 'url'=>array('admin')),
);
?>

<h1>View RegistrationProduct #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'registration_transaction_id',
		'product_id',
		'quantity',
		'retail_price',
		'hpp',
		'sale_price',
		'discount',
		'total_price',
	),
)); ?>
