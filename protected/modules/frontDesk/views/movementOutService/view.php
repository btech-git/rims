<?php
/* @var $this RegistrationServiceController */
/* @var $model RegistrationService */

$this->breadcrumbs=array(
	'Registration Services'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List RegistrationService', 'url'=>array('index')),
	array('label'=>'Create RegistrationService', 'url'=>array('create')),
	array('label'=>'Update RegistrationService', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete RegistrationService', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage RegistrationService', 'url'=>array('admin')),
);
?>

<h1>View Registration Service #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'registrationTransaction.transaction_number',
		'service_id',
		'employee_id',
		'claim',
		'price',
		'service_exception_rate',
		'total_price',
		'hour',
	),
)); ?>
