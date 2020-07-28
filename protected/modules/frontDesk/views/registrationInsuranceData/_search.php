<?php
/* @var $this RegistrationInsuranceDataController */
/* @var $model RegistrationInsuranceData */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'registration_transaction_id'); ?>
		<?php echo $form->textField($model,'registration_transaction_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'insurance_company_id'); ?>
		<?php echo $form->textField($model,'insurance_company_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'insured_name'); ?>
		<?php echo $form->textField($model,'insured_name',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'insurance_policy_number'); ?>
		<?php echo $form->textField($model,'insurance_policy_number',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'insurance_policy_period_start'); ?>
		<?php echo $form->textField($model,'insurance_policy_period_start'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'insurance_policy_period_end'); ?>
		<?php echo $form->textField($model,'insurance_policy_period_end'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'spk_insurance'); ?>
		<?php echo $form->textField($model,'spk_insurance',array('size'=>5,'maxlength'=>5)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'deductible_own_risk'); ?>
		<?php echo $form->textField($model,'deductible_own_risk',array('size'=>18,'maxlength'=>18)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'insured_occupation'); ?>
		<?php echo $form->textField($model,'insured_occupation',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'insured_telephone'); ?>
		<?php echo $form->textField($model,'insured_telephone',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'insured_handphone'); ?>
		<?php echo $form->textField($model,'insured_handphone',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'insured_email'); ?>
		<?php echo $form->textField($model,'insured_email',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'insured_address'); ?>
		<?php echo $form->textArea($model,'insured_address',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'insured_province_id'); ?>
		<?php echo $form->textField($model,'insured_province_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'insured_city_id'); ?>
		<?php echo $form->textField($model,'insured_city_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'insured_zip_code'); ?>
		<?php echo $form->textField($model,'insured_zip_code',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'driver_name'); ?>
		<?php echo $form->textField($model,'driver_name',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'driver_id_number'); ?>
		<?php echo $form->textField($model,'driver_id_number',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'relation_with_insured'); ?>
		<?php echo $form->textField($model,'relation_with_insured',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'driver_occupation'); ?>
		<?php echo $form->textField($model,'driver_occupation',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'driver_telephone'); ?>
		<?php echo $form->textField($model,'driver_telephone',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'driver_handphone'); ?>
		<?php echo $form->textField($model,'driver_handphone',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'driver_email'); ?>
		<?php echo $form->textField($model,'driver_email',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'driver_address'); ?>
		<?php echo $form->textArea($model,'driver_address',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'driver_province_id'); ?>
		<?php echo $form->textField($model,'driver_province_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'driver_city_id'); ?>
		<?php echo $form->textField($model,'driver_city_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'driver_zipcode'); ?>
		<?php echo $form->textField($model,'driver_zipcode',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'other_passenger_name'); ?>
		<?php echo $form->textField($model,'other_passenger_name',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'accident_place'); ?>
		<?php echo $form->textArea($model,'accident_place',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'accident_date_time'); ?>
		<?php echo $form->textField($model,'accident_date_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'speed'); ?>
		<?php echo $form->textField($model,'speed',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'damage_description'); ?>
		<?php echo $form->textArea($model,'damage_description',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'witness'); ?>
		<?php echo $form->textField($model,'witness',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'injury'); ?>
		<?php echo $form->textField($model,'injury',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'is_reported'); ?>
		<?php echo $form->textField($model,'is_reported'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'accident_description'); ?>
		<?php echo $form->textArea($model,'accident_description',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'insurance_surveyor_request'); ?>
		<?php echo $form->textArea($model,'insurance_surveyor_request',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'customer_request'); ?>
		<?php echo $form->textArea($model,'customer_request',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->