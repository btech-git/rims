<?php
/* @var $this ConsignmentInDetailController */
/* @var $model ConsignmentInDetail */

$this->breadcrumbs=array(
	'Consignment In Details'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ConsignmentInDetail', 'url'=>array('index')),
	array('label'=>'Create ConsignmentInDetail', 'url'=>array('create')),
	array('label'=>'Update ConsignmentInDetail', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ConsignmentInDetail', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ConsignmentInDetail', 'url'=>array('admin')),
);
?>

<h1>View ConsignmentInDetail #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'consignment_in_id',
		'product_id',
		'quantity',
		'note',
		'barcode_product',
		'price',
	),
)); ?>
