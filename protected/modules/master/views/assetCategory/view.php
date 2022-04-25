<?php
/* @var $this AssetCategoryController */
/* @var $model AssetCategory */

$this->breadcrumbs=array(
	'Asset Categories'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List AssetCategory', 'url'=>array('index')),
	array('label'=>'Create AssetCategory', 'url'=>array('create')),
	array('label'=>'Update AssetCategory', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AssetCategory', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AssetCategory', 'url'=>array('admin')),
);
?>

<h1>View AssetCategory #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'code',
		'description',
		'status',
	),
)); ?>
