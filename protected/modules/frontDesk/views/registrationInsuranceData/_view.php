<?php
/* @var $this RegistrationInsuranceDataController */
/* @var $data RegistrationInsuranceData */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('registration_transaction_id')); ?>:</b>
	<?php echo CHtml::encode($data->registration_transaction_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('insurance_company_id')); ?>:</b>
	<?php echo CHtml::encode($data->insurance_company_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('insured_name')); ?>:</b>
	<?php echo CHtml::encode($data->insured_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('insurance_policy_number')); ?>:</b>
	<?php echo CHtml::encode($data->insurance_policy_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('insurance_policy_period_start')); ?>:</b>
	<?php echo CHtml::encode($data->insurance_policy_period_start); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('insurance_policy_period_end')); ?>:</b>
	<?php echo CHtml::encode($data->insurance_policy_period_end); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('spk_insurance')); ?>:</b>
	<?php echo CHtml::encode($data->spk_insurance); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('deductible_own_risk')); ?>:</b>
	<?php echo CHtml::encode($data->deductible_own_risk); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('insured_occupation')); ?>:</b>
	<?php echo CHtml::encode($data->insured_occupation); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('insured_telephone')); ?>:</b>
	<?php echo CHtml::encode($data->insured_telephone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('insured_handphone')); ?>:</b>
	<?php echo CHtml::encode($data->insured_handphone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('insured_email')); ?>:</b>
	<?php echo CHtml::encode($data->insured_email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('insured_address')); ?>:</b>
	<?php echo CHtml::encode($data->insured_address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('insured_province_id')); ?>:</b>
	<?php echo CHtml::encode($data->insured_province_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('insured_city_id')); ?>:</b>
	<?php echo CHtml::encode($data->insured_city_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('insured_zip_code')); ?>:</b>
	<?php echo CHtml::encode($data->insured_zip_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('driver_name')); ?>:</b>
	<?php echo CHtml::encode($data->driver_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('driver_id_number')); ?>:</b>
	<?php echo CHtml::encode($data->driver_id_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('relation_with_insured')); ?>:</b>
	<?php echo CHtml::encode($data->relation_with_insured); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('driver_occupation')); ?>:</b>
	<?php echo CHtml::encode($data->driver_occupation); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('driver_telephone')); ?>:</b>
	<?php echo CHtml::encode($data->driver_telephone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('driver_handphone')); ?>:</b>
	<?php echo CHtml::encode($data->driver_handphone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('driver_email')); ?>:</b>
	<?php echo CHtml::encode($data->driver_email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('driver_address')); ?>:</b>
	<?php echo CHtml::encode($data->driver_address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('driver_province_id')); ?>:</b>
	<?php echo CHtml::encode($data->driver_province_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('driver_city_id')); ?>:</b>
	<?php echo CHtml::encode($data->driver_city_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('driver_zipcode')); ?>:</b>
	<?php echo CHtml::encode($data->driver_zipcode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('other_passenger_name')); ?>:</b>
	<?php echo CHtml::encode($data->other_passenger_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('accident_place')); ?>:</b>
	<?php echo CHtml::encode($data->accident_place); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('accident_date_time')); ?>:</b>
	<?php echo CHtml::encode($data->accident_date_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('speed')); ?>:</b>
	<?php echo CHtml::encode($data->speed); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('damage_description')); ?>:</b>
	<?php echo CHtml::encode($data->damage_description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('witness')); ?>:</b>
	<?php echo CHtml::encode($data->witness); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('injury')); ?>:</b>
	<?php echo CHtml::encode($data->injury); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_reported')); ?>:</b>
	<?php echo CHtml::encode($data->is_reported); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('accident_description')); ?>:</b>
	<?php echo CHtml::encode($data->accident_description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('insurance_surveyor_request')); ?>:</b>
	<?php echo CHtml::encode($data->insurance_surveyor_request); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('customer_request')); ?>:</b>
	<?php echo CHtml::encode($data->customer_request); ?>
	<br />

	*/ ?>

</div>