<?php
/* @var $this WarehouseSectionController */
/* @var $model WarehouseSection */

$this->breadcrumbs=array(
	'Warehouse Sections'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List WarehouseSection', 'url'=>array('index')),
	array('label'=>'Create WarehouseSection', 'url'=>array('create')),
	array('label'=>'Update WarehouseSection', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete WarehouseSection', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage WarehouseSection', 'url'=>array('admin')),
);
?>

<h1>View WarehouseSection #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'warehouse_id',
		'code',
		'product_id',
		'rack_number',
		'status',
	),
)); ?>
