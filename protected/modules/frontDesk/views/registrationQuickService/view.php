<?php
/* @var $this RegistrationQuickServiceController */
/* @var $model RegistrationQuickService */

$this->breadcrumbs=array(
	'Registration Quick Services'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List RegistrationQuickService', 'url'=>array('index')),
	array('label'=>'Create RegistrationQuickService', 'url'=>array('create')),
	array('label'=>'Update RegistrationQuickService', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete RegistrationQuickService', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage RegistrationQuickService', 'url'=>array('admin')),
);
?>

<h1>View RegistrationQuickService #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'registration_transaction_id',
		'quick_service_id',
		'employee_id',
		'price',
		'hour',
	),
)); ?>
