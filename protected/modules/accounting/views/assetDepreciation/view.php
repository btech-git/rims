<?php
/* @var $this AssetDepreciationController */
/* @var $model AssetDepreciation */

$this->breadcrumbs=array(
	'Asset Depreciations'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List AssetDepreciation', 'url'=>array('index')),
	array('label'=>'Create AssetDepreciation', 'url'=>array('create')),
	array('label'=>'Update AssetDepreciation', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AssetDepreciation', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AssetDepreciation', 'url'=>array('admin')),
);
?>

<h1>View Asset Depreciation #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'transaction_number',
		'transaction_date',
		'transaction_time',
		'amount',
		'number_of_month',
		'asset.name',
		'user.username',
	),
)); ?>
