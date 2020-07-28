<?php
/* @var $this RegistrationInsuranceDataController */
/* @var $model RegistrationInsuranceData */

$this->breadcrumbs=array(
	'Registration Insurance Datas'=>array('admin'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List RegistrationInsuranceData', 'url'=>array('index')),
	array('label'=>'Create RegistrationInsuranceData', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#registration-insurance-data-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Registration Insurance Datas</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'registration-insurance-data-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'registration_transaction_id',
		'insurance_company_id',
		'insured_name',
		'insurance_policy_number',
		'insurance_policy_period_start',
		/*
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
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
