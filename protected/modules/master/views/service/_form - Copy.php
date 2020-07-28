<?php
/* @var $this ServiceController */
/* @var $model Service */
/* @var $form CActiveForm */
?>

<div class="clearfix page-action">
<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/service/admin';?>"><span class="fa fa-th-list"></span>Manage Services</a>
<h1><?php if($model->isNewRecord){ echo "New Service"; }else{ echo "Update Service";}?></h1>
<!-- begin FORM -->
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'service-form',
	'enableAjaxValidation'=>false,
)); ?>

	<hr>
	<p class="note">Fields with <span class="required">*</span> are required.</p>
	
   <div class="row">
		<div class="small-12 medium-6 columns">         
			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($model,'service_type_id'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->dropDownList($model,'service_type_id', CHtml::listData(ServiceType::model()->findAll(), 'id', 'name'),array('prompt'=>'[--Select Service Type --]'));?>
						<?php echo $form->error($model,'service_type_id'); ?>
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
					  <label class="prefix"><?php echo $form->labelEx($model,'service_category_id'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->dropDownList($model,'service_category_id', CHtml::listData(ServiceCategory::model()->findAll(), 'id', 'name'),array('prompt'=>'[--Select Service Category --]'));?>
						<?php echo $form->error($model,'service_category_id'); ?>
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
					  <label class="prefix"><?php echo $form->labelEx($model,'code'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'code',array('size'=>20,'maxlength'=>20)); ?>
						<?php echo $form->error($model,'code'); ?>
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
					  <label class="prefix"><?php echo $form->labelEx($model,'name'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'name',array('size'=>30,'maxlength'=>30)); ?>
						<?php echo $form->error($model,'name'); ?>
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
					  <label class="prefix"><?php echo $form->labelEx($model,'price'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'price'); ?>
						<?php echo $form->error($model,'price'); ?>
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
					  <label class="prefix"><?php echo $form->labelEx($model,'description'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'description',array('size'=>60,'maxlength'=>60)); ?>
						<?php echo $form->error($model,'description'); ?>
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
					  <label class="prefix"><?php echo $form->labelEx($model,'difficulty_level'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'difficulty_level'); ?>
						<?php echo $form->error($model,'difficulty_level'); ?>
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
					  <label class="prefix"><?php echo $form->labelEx($model,'status'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo  $form->dropDownList($model, 'status', array('Active' => 'Active',
									'Inactive' => 'Inactive', )); ?>
						<?php echo $form->error($model,'status'); ?>
					</div>
				</div>
			 </div>		 
		</div>		
   </div>

		<hr>

	
	<div class="field buttons text-center">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>


</div><!-- form -->
</div>	