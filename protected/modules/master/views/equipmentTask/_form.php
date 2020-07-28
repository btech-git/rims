<?php
/* @var $this EquipmentTaskController */
/* @var $model EquipmentTask */
/* @var $form CActiveForm */
?>
<div class="clearfix page-action">
<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/equipmentTask/admin';?>"><span class="fa fa-th-list"></span>Manage Equipments</a>
<h1><?php if($model->isNewRecord){ echo "New Equipment Task"; }else{ echo "Update Equipment Task";}?></h1>
<!-- begin FORM -->
<div class="form">


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'equipments-form',
	'enableAjaxValidation'=>false,
)); ?>

	
	<hr>
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php //echo $form->errorSummary($model); ?>

	

   <div class="row">
		<div class="small-12 medium-6 columns">         
			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($model,'equipment_id'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->dropDownList($model, 'equipment_id', CHtml::listData(Equipments::model()->findAll(), 'id', 'name'),array(
										'prompt' => '[--Select Equipment--]'));?>
						<?php echo $form->error($model,'equipment_id'); ?>
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
					  <label class="prefix"><?php echo $form->labelEx($model,'task'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'task',array('size'=>60,'maxlength'=>100)); ?>
						<?php echo $form->error($model,'task'); ?>
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
					  <label class="prefix"><?php echo $form->labelEx($model,'check_period'); ?></label>
					</div>
					<div class="small-8 columns">						
						<?php //echo $form->textField($model,'check_period',array('size'=>30,'maxlength'=>30)); ?>
							<?php echo CHtml::activeDropDownList($model,"check_period", array('Daily' => 'Daily',
									'Weekly' => 'Weekly','Monthly'=> 'Monthly','Quarterly'=>'Quarterly','6 Months'=>'6 Months', 'Yearly' => 'Yearly'), array('prompt'=>'[-- Select Period --]')); ?>
				
						<?php echo $form->error($model,'check_period'); ?>
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

