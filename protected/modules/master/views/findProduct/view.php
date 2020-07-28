<?php
/* @var $this FindProductController */
/* @var $model Product */

$this->breadcrumbs=array(
	'Products'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Product', 'url'=>array('index')),
	array('label'=>'Create Product', 'url'=>array('create')),
	array('label'=>'Update Product', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Product', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Product', 'url'=>array('admin')),
);
?>

<h1>View Product #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'code',
		'manufacturer_code',
		'barcode',
		'name',
		'description',
		'production_year',
		'brand_id',
		'extension',
		'product_master_category_id',
		'product_sub_master_category_id',
		'product_sub_category_id',
		'vehicle_car_make_id',
		'vehicle_car_model_id',
		'purchase_price',
		'recommended_selling_price',
		'hpp',
		'retail_price',
		'stock',
		'minimum_stock',
		'margin_type',
		'margin_amount',
		'is_usable',
		'status',
	),
)); ?>
