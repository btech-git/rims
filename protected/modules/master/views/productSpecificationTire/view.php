<?php
/* @var $this ProductSpecificationTireController */
/* @var $model ProductSpecificationTire */

$this->breadcrumbs=array(
	'Product Specification Tires'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ProductSpecificationTire', 'url'=>array('index')),
	array('label'=>'Create ProductSpecificationTire', 'url'=>array('create')),
	array('label'=>'Update ProductSpecificationTire', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ProductSpecificationTire', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ProductSpecificationTire', 'url'=>array('admin')),
);
?>

<h1>View ProductSpecificationTire #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'product_id',
		'serial_number',
		'type',
		'sub_brand_id',
		'sub_brand_series_id',
		'attribute',
		'overall_diameter',
		'section_width_inches',
		'section_width_mm',
		'aspect_ration',
		'radial_type',
		'rim_diameter',
		'load_index',
		'speed_symbol',
		'ply_rating',
		'lettering',
		'terrain',
		'local_import',
		'car_type',
	),
)); ?>
