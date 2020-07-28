<?php
/* @var $this CustomerPicController */
/* @var $model CustomerPic */

$this->breadcrumbs=array(
	'Customer Pics'=>array('admin'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List CustomerPic', 'url'=>array('index')),
	array('label'=>'Create CustomerPic', 'url'=>array('create')),
	array('label'=>'Update CustomerPic', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CustomerPic', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CustomerPic', 'url'=>array('admin')),
);
?>

<h1>View CustomerPic #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'customer_id',
		'name',
		'address',
		'city',
		'ziocode',
		'phone',
		'mobile_phone',
		'fax',
		'email',
		'note',
		'customer_type',
		'status',
		'birthdate',
	),
)); ?>
