<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */
/* @var $form CActiveForm */
?>

<div class="clearfix page-action">
	
<!-- begin FORM -->
<div class="form">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'registration-transaction-form',
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation'=>false,
	)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<div class="small-12 medium-6 columns">

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($model,'WO Status'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php //echo $registrationService->service->status; ?>
						<?php //echo $form->textField($registrationService,'status',array('size'=>30,'maxlength'=>30)); ?>
						<?php echo $form->dropDownList($model,'status',array(
                            'Pending'=>'Pending',
                            'Available'=>'Available',
                            'On Progress'=>'On Progress',
                            'Finished'=>'Finished'
                        )); ?>
						<?php echo $form->error($model,'status'); ?>
					</div>
				</div>			
			</div>

			

		</div>
	</div>
	<div class="field buttons text-center">
		  <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->