<?php
/* @var $this GeneralStandardValueController */
/* @var $model GeneralStandardValue */
/* @var $form CActiveForm */
?>

<div class="clearfix page-action">
<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/generalStandardFr/admin';?>"><span class="fa fa-th-list"></span>Manage Standard Flat Rate</a>
<h1><?php if($model->isNewRecord){ echo "New Standard Flat Rate"; }else{ echo "Update Standard Flat Rate";}?></h1>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'general-standard-value-form',
	'enableAjaxValidation'=>false,
)); ?>

		<hr>
	<p class="note">Fields with <span class="required">*</span> are required.</p>
		<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<div class="small-12 medium-6 columns">

			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($model,'difficulty'); ?></label>
					</div>
					<div class="small-8 columns">
		
						<?php echo $form->textField($model,'difficulty',array('size'=>10,'maxlength'=>10)); ?>
						<?php echo $form->error($model,'difficulty'); ?>
					</div>
				</div>
			 </div>		 

			  <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($model,'difficulty_value'); ?></label>
					</div>
					<div class="small-8 columns">
		
						<?php echo $form->textField($model,'difficulty_value',array('size'=>10,'maxlength'=>10)); ?>
						<?php echo $form->error($model,'difficulty_value'); ?>
					</div>
				</div>
			 </div>		 
						
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($model,'regular'); ?></label>
					</div>
					<div class="small-8 columns">
		
						<?php echo $form->textField($model,'regular',array('size'=>10,'maxlength'=>10)); ?>
						<?php echo $form->error($model,'regular'); ?>
					</div>
				</div>
			 </div>
			
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($model,'luxury'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'luxury',array('size'=>10,'maxlength'=>10)); ?>
						<?php echo $form->error($model,'luxury'); ?>
					</div>
				</div>
			 </div>

			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($model,'luxury_value'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'luxury_value',array('size'=>10,'maxlength'=>10)); ?>
						<?php echo $form->error($model,'luxury_value'); ?>
					</div>
				</div>
			 </div>

			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($model,'luxury_calc'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'luxury_calc',array('size'=>10,'maxlength'=>10)); ?>
						<?php echo $form->error($model,'luxury_calc'); ?>
					</div>
				</div>
			 </div>

			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($model,'flat_rate_hour'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'flat_rate_hour',array('size'=>10,'maxlength'=>10)); ?>
						<?php echo $form->error($model,'flat_rate_hour'); ?>
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