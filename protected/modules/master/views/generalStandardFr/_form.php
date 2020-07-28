<?php
/* @var $this GeneralStandardFrController */
/* @var $model GeneralStandardFr */
/* @var $form CActiveForm */
?>

<div class="clearfix page-action">
<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/generalStandardFr/admin';?>"><span class="fa fa-th-list"></span>Manage Standard Flat Rate</a>
<h1><?php if($model->isNewRecord){ echo "New Standard Flat Rate"; }else{ echo "Update Standard Flat Rate";}?></h1>
<!-- begin FORM -->
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'general-standard-fr-form',
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
					  <label class="prefix"><?php echo $form->labelEx($model,'flat_rate'); ?></label>
					</div>
					<div class="small-8 columns">
		
						<?php echo $form->textField($model,'flat_rate',array('size'=>10,'maxlength'=>10)); ?>
						<?php echo $form->error($model,'flat_rate'); ?>
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
</div>	