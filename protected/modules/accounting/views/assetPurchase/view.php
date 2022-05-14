<?php
/* @var $this AssetPurchaseController */
/* @var $model AssetPurchase */

$this->breadcrumbs=array(
	'Asset Purchases'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List AssetPurchase', 'url'=>array('index')),
	array('label'=>'Create AssetPurchase', 'url'=>array('create')),
	array('label'=>'Update AssetPurchase', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AssetPurchase', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AssetPurchase', 'url'=>array('admin')),
);
?>

<h1>View Asset Purchase #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'transaction_number',
		'transaction_date',
		'transaction_time',
		'purchase_price',
		'monthly_useful_life',
		'depreciation_amount',
		'depreciation_start_date',
		'depreciation_end_date',
		'status',
		'note',
		'assetCategory.name',
		'user.username',
	),
)); ?>
