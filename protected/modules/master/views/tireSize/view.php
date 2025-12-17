<?php
/* @var $this TireSizeController */
/* @var $model TireSize */

$this->breadcrumbs=array(
	'Tire Sizes'=>array('index'),
	$model->section_width,
);

$this->menu=array(
	array('label'=>'List TireSize', 'url'=>array('index')),
	array('label'=>'Create TireSize', 'url'=>array('create')),
	array('label'=>'Update TireSize', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TireSize', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TireSize', 'url'=>array('admin')),
);
?>

<h1>View Tire Specifications #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        'id',
        'section_width',
        'aspect_ratio',
        'construction_type',
        'rim_diameter',
        'load_rating',
        'speed_rating',
    ),
)); ?>
