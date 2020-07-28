<?php
/* @var $this ProductSpecificationTypeController */
/* @var $model ProductSpecificationType */

$this->breadcrumbs=array(
	'Product'=>Yii::app()->baseUrl.'/master/product/admin',
	'Product Specification Types'=>array('admin'),
	'View Product Specification Type '.$model->name,
);

$this->menu=array(
	array('label'=>'List ProductSpecificationType', 'url'=>array('index')),
	array('label'=>'Create ProductSpecificationType', 'url'=>array('create')),
	array('label'=>'Update ProductSpecificationType', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ProductSpecificationType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ProductSpecificationType', 'url'=>array('admin')),
);
?>

<h1>View ProductSpecificationType #<?php echo $model->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'description',
		'status',
	),
)); ?>
