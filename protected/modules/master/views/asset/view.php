<?php
/* @var $this AssetController */
/* @var $model Asset */

$this->breadcrumbs=array(
	'Assets'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Asset', 'url'=>array('index')),
	array('label'=>'Create Asset', 'url'=>array('create')),
	array('label'=>'Update Asset', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Asset', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Asset', 'url'=>array('admin')),
);
?>

<h1>View Asset #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'code',
		'description',
		'memo',
		'status',
		'is_taxable',
		'is_zero_book_value',
		'assetCategory.name',
	),
)); ?>
