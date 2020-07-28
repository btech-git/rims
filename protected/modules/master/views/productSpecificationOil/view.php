<?php
/* @var $this ProductSpecificationOilController */
/* @var $model ProductSpecificationOil */

$this->breadcrumbs=array(
	'Product Specification Oils'=>array('admin'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List ProductSpecificationOil', 'url'=>array('index')),
	array('label'=>'Create ProductSpecificationOil', 'url'=>array('create')),
	array('label'=>'Update ProductSpecificationOil', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ProductSpecificationOil', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ProductSpecificationOil', 'url'=>array('admin')),
);
?>

<h1>View ProductSpecificationOil #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'product_id',
		'category_usage',
		'oil_type',
		'transmission',
		'code_serial',
		'sub_brand_id',
		'sub_brand_series_id',
		'fuel',
		'dot_code',
		'viscosity_low_t',
		'viscosity_high',
		'api_code',
		'size_measurements',
		'size',
		'name',
		'description',
		'car_use',
	),
)); ?>
