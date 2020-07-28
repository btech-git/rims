<?php
/* @var $this VehicleController */
/* @var $model Vehicle */
/* @var $form CActiveForm */
?>

<div class="clearfix page-action">
<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/vehicle/admin';?>"><span class="fa fa-th-list"></span>Manage Customer Vehicles</a>
<h1>Vehicle Inspection</h1>
	
<!-- begin FORM -->
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'vehicle-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
	<hr>
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($vehicle->header); ?>

	<div class="row">
		<div class="small-12 medium-6 columns">

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<label class="prefix"><?php echo $form->labelEx($vehicle->header,'customer_id'); ?></label>
			</div>
			<div class="small-8 columns">
				<?php echo $form->hiddenField($vehicle->header, 'customer_id'); ?>
				<?php echo $form->textField($vehicle->header,'customer_name',array(
					//'onclick' => 'jQuery("#customer-dialog").dialog("open"); return false;',
					'value' => $vehicle->header->customer_id != Null ? $vehicle->header->customer->name : '',
					'disabled' => 'disabled'
				)); ?>

				

				<?php echo $form->error($vehicle->header,'customer_id'); ?>
			</div>
		</div>			
	</div>

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<label class="prefix"><?php echo $form->labelEx($vehicle->header,'plate_number'); ?></label>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($vehicle->header,'plate_number',array('size'=>10,'maxlength'=>10,'disabled'=>'disabled')); ?>
				<?php echo $form->error($vehicle->header,'plate_number'); ?>	
			</div>
		</div>			
	</div>
	
	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<label class="prefix"><?php echo $form->labelEx($vehicle->header,'machine_number'); ?></label>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($vehicle->header,'machine_number',array('size'=>30,'maxlength'=>30,'disabled'=>'disabled')); ?>
				<?php echo $form->error($vehicle->header,'machine_number'); ?>
			</div>
		</div>			
	</div>
	
	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<label class="prefix"><?php echo $form->labelEx($vehicle->header,'frame_number'); ?></label>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($vehicle->header,'frame_number',array('size'=>30,'maxlength'=>30,'disabled'=>'disabled')); ?>
				<?php echo $form->error($vehicle->header,'frame_number'); ?>
			</div>
		</div>			
	</div>

	
	<!-- end RIGHT -->
	
	 </div>
   </div>
   <hr>
	<div class="field buttons text-center">
		  <?php echo CHtml::submitButton($vehicle->header->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
</div>	