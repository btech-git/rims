<?php
/* @var $this ProductSpecificationInfoController */
/* @var $model ProductSpecificationInfo */

$this->breadcrumbs=array(
	'Product'=>Yii::app()->baseUrl.'/master/product/admin',
	'Product Specification Infos'=>array('index'),
	'View Product Specification Info '.$model->name,
);

$this->menu=array(
	array('label'=>'List ProductSpecificationInfo', 'url'=>array('index')),
	array('label'=>'Create ProductSpecificationInfo', 'url'=>array('create')),
	array('label'=>'Update ProductSpecificationInfo', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ProductSpecificationInfo', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ProductSpecificationInfo', 'url'=>array('admin')),
);
?>

<h1>View ProductSpecificationInfo #<?php echo $model->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'product_specification_type_id',
		'name',
	),
)); ?>
