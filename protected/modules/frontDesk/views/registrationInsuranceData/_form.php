<?php
/* @var $this RegistrationInsuranceDataController */
/* @var $model RegistrationInsuranceData */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'registration-insurance-data-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'registration_transaction_id'); ?>
		<?php echo $form->textField($model,'registration_transaction_id'); ?>
		<?php echo $form->error($model,'registration_transaction_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'insurance_company_id'); ?>
		<?php echo $form->textField($model,'insurance_company_id'); ?>
		<?php echo $form->error($model,'insurance_company_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'insured_name'); ?>
		<?php echo $form->textField($model,'insured_name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'insured_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'insurance_policy_number'); ?>
		<?php echo $form->textField($model,'insurance_policy_number',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'insurance_policy_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'insurance_policy_period_start'); ?>
		<?php echo $form->textField($model,'insurance_policy_period_start'); ?>
		<?php echo $form->error($model,'insurance_policy_period_start'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'insurance_policy_period_end'); ?>
		<?php echo $form->textField($model,'insurance_policy_period_end'); ?>
		<?php echo $form->error($model,'insurance_policy_period_end'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'spk_insurance'); ?>
		<?php echo $form->textField($model,'spk_insurance',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'spk_insurance'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'deductible_own_risk'); ?>
		<?php echo $form->textField($model,'deductible_own_risk',array('size'=>18,'maxlength'=>18)); ?>
		<?php echo $form->error($model,'deductible_own_risk'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'insured_occupation'); ?>
		<?php echo $form->textField($model,'insured_occupation',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'insured_occupation'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'insured_telephone'); ?>
		<?php echo $form->textField($model,'insured_telephone',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'insured_telephone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'insured_handphone'); ?>
		<?php echo $form->textField($model,'insured_handphone',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'insured_handphone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'insured_email'); ?>
		<?php echo $form->textField($model,'insured_email',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'insured_email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'insured_address'); ?>
		<?php echo $form->textArea($model,'insured_address',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'insured_address'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'insured_province_id'); ?>
		<?php echo $form->textField($model,'insured_province_id'); ?>
		<?php echo $form->error($model,'insured_province_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'insured_city_id'); ?>
		<?php echo $form->textField($model,'insured_city_id'); ?>
		<?php echo $form->error($model,'insured_city_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'insured_zip_code'); ?>
		<?php echo $form->textField($model,'insured_zip_code',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'insured_zip_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'driver_name'); ?>
		<?php echo $form->textField($model,'driver_name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'driver_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'driver_id_number'); ?>
		<?php echo $form->textField($model,'driver_id_number',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'driver_id_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'relation_with_insured'); ?>
		<?php echo $form->textField($model,'relation_with_insured',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'relation_with_insured'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'driver_occupation'); ?>
		<?php echo $form->textField($model,'driver_occupation',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'driver_occupation'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'driver_telephone'); ?>
		<?php echo $form->textField($model,'driver_telephone',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'driver_telephone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'driver_handphone'); ?>
		<?php echo $form->textField($model,'driver_handphone',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'driver_handphone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'driver_email'); ?>
		<?php echo $form->textField($model,'driver_email',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'driver_email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'driver_address'); ?>
		<?php echo $form->textArea($model,'driver_address',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'driver_address'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'driver_province_id'); ?>
		<?php echo $form->textField($model,'driver_province_id'); ?>
		<?php echo $form->error($model,'driver_province_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'driver_city_id'); ?>
		<?php echo $form->textField($model,'driver_city_id'); ?>
		<?php echo $form->error($model,'driver_city_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'driver_zipcode'); ?>
		<?php echo $form->textField($model,'driver_zipcode',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'driver_zipcode'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'other_passenger_name'); ?>
		<?php echo $form->textField($model,'other_passenger_name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'other_passenger_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'accident_place'); ?>
		<?php echo $form->textArea($model,'accident_place',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'accident_place'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'accident_date_time'); ?>
		<?php echo $form->textField($model,'accident_date_time'); ?>
		<?php echo $form->error($model,'accident_date_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'speed'); ?>
		<?php echo $form->textField($model,'speed',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'speed'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'damage_description'); ?>
		<?php echo $form->textArea($model,'damage_description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'damage_description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'witness'); ?>
		<?php echo $form->textField($model,'witness',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'witness'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'injury'); ?>
		<?php echo $form->textField($model,'injury',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'injury'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_reported'); ?>
		<?php echo $form->textField($model,'is_reported'); ?>
		<?php echo $form->error($model,'is_reported'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'accident_description'); ?>
		<?php echo $form->textArea($model,'accident_description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'accident_description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'insurance_surveyor_request'); ?>
		<?php echo $form->textArea($model,'insurance_surveyor_request',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'insurance_surveyor_request'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'customer_request'); ?>
		<?php echo $form->textArea($model,'customer_request',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'customer_request'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->