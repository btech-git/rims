<?php
/* @var $this CustomerServiceRateController */
/* @var $model CustomerServiceRate */
/* @var $form CActiveForm */
?>
<div class="clearfix page-action">
<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/customerServiceRate/admin';?>"><span class="fa fa-th-list"></span>Manage Customer Service Rate</a>
<h1><?php if($model->isNewRecord){ echo "New Customer Service Rate"; }else{ echo "Update Customer Service Rate";}?></h1>
<!-- begin FORM -->
<div class="form">


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'colors-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
	<hr>
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="row">
		<div class="small-12 medium-6 columns">         
			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($model,'customer_id'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'customer_id'); ?>
						<?php echo $form->error($model,'customer_id'); ?>
					</div>
				</div>
			 </div>		 
		</div>		
   </div>

	<div class="row">
		<div class="small-12 medium-6 columns">         
			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($model,'service_id'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'service_id'); ?>
						<?php echo $form->error($model,'service_id'); ?>
					</div>
				</div>
			 </div>		 
		</div>		
   </div>
   
   <div class="row">
		<div class="small-12 medium-6 columns">         
			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($model,'rate'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'rate',array('size'=>10,'maxlength'=>10)); ?>
						<?php echo $form->error($model,'rate'); ?>
					</div>
				</div>
			 </div>		 
		</div>		
   </div>
   
	<hr>

	
	<div class="field buttons text-center">
		  <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
</div>	