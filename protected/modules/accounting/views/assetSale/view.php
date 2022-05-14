<?php
/* @var $this AssetSaleController */
/* @var $model AssetSale */

$this->breadcrumbs=array(
	'Asset Sales'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List AssetSale', 'url'=>array('index')),
	array('label'=>'Create AssetSale', 'url'=>array('create')),
	array('label'=>'Update AssetSale', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AssetSale', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AssetSale', 'url'=>array('admin')),
);
?>

<h1>View AssetSale #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'transaction_number',
		'transaction_date',
		'transaction_time',
		'sale_price',
		'note',
		'assetPurchase.description',
		'user.username',
	),
)); ?>
