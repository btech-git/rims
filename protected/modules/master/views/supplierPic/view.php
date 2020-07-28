<?php
/* @var $this SupplierPicController */
/* @var $model SupplierPic */

$this->breadcrumbs=array(
	'Supplier Pics'=>array('admin'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List SupplierPic', 'url'=>array('index')),
	array('label'=>'Create SupplierPic', 'url'=>array('create')),
	array('label'=>'Update SupplierPic', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete SupplierPic', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SupplierPic', 'url'=>array('admin')),
);
?>

<h1>View SupplierPic #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'supplier_id',
		'date',
		'code',
		'name',
		'company',
		'position',
		'address',
		'province_id',
		'city_id',
		'zipcode',
		'fax',
		'email_personal',
		'email_company',
		'npwp',
		'description',
		'tenor',
	),
)); ?>
