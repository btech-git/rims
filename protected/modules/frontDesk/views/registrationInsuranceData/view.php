<?php
/* @var $this RegistrationInsuranceDataController */
/* @var $model RegistrationInsuranceData */

$this->breadcrumbs=array(
	'Registration Insurance Datas'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List RegistrationInsuranceData', 'url'=>array('index')),
	array('label'=>'Create RegistrationInsuranceData', 'url'=>array('create')),
	array('label'=>'Update RegistrationInsuranceData', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete RegistrationInsuranceData', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage RegistrationInsuranceData', 'url'=>array('admin')),
);
?>

<h1>View RegistrationInsuranceData #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'registration_transaction_id',
		'insurance_company_id',
		'insured_name',
		'insurance_policy_number',
		'insurance_policy_period_start',
		'insurance_policy_period_end',
		'spk_insurance',
		'deductible_own_risk',
		'insured_occupation',
		'insured_telephone',
		'insured_handphone',
		'insured_email',
		'insured_address',
		'insured_province_id',
		'insured_city_id',
		'insured_zip_code',
		'driver_name',
		'driver_id_number',
		'relation_with_insured',
		'driver_occupation',
		'driver_telephone',
		'driver_handphone',
		'driver_email',
		'driver_address',
		'driver_province_id',
		'driver_city_id',
		'driver_zipcode',
		'other_passenger_name',
		'accident_place',
		'accident_date_time',
		'speed',
		'damage_description',
		'witness',
		'injury',
		'is_reported',
		'accident_description',
		'insurance_surveyor_request',
		'customer_request',
	),
)); ?>
