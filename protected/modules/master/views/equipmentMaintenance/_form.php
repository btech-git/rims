<?php
/* @var $this EquipmentMaintenanceController */
/* @var $model EquipmentMaintenance */
/* @var $form CActiveForm */
?>

<div class="clearfix page-action">
<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/equipmentMaintenance/admin';?>"><span class="fa fa-th-list"></span>Manage Equipment Maintenance</a>
<h1><?php if($model->isNewRecord){ echo "New Equipment Maintenance"; }else{ echo "Update Equipment Maintenance";}?></h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'equipment-maintenance-form',
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
					  <label class="prefix"><?php echo $form->labelEx($model,'equipment_branch_id'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php
						$models = EquipmentBranch::model()->findAll();
						$branch = array();

						foreach ($models as $model1)
								$branch[$model1->id] =  $model1->branch->name;   
						
						//print_r($branch); exit;
						?>
						<?php echo $form->dropDownList($model, 'equipment_branch_id',  $branch,array(
										'prompt' => '[--Select Equipment Branch--]',
										'onchange'=> 'jQuery.ajax({
											type: "POST",
											//dataType: "JSON",
											url: "' . CController::createUrl('ajaxGetTask') . '" ,
											data: jQuery("form").serialize(),
											success: function(data){
												console.log(data);
												jQuery("#EquipmentMaintenance_equipment_task_id").html(data);
												//jQuery("#task").html(data);
											},
										});'										
										));?>
						<?php echo $form->error($model,'equipment_branch_id'); ?>
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
					  <label class="prefix"><?php echo $form->labelEx($model,'equipment_id'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->dropDownList($model, 'equipment_id', CHtml::listData(Equipments::model()->findAll(), 'id', 'name'),array(
										'prompt' => '[--Select Equipment --]'));?>
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
					  <label class="prefix"><?php echo $form->labelEx($model,'equipment_task_id'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->dropDownList($model, 'equipment_task_id', CHtml::listData(EquipmentTask::model()->findAll(), 'id', 'task'),array(
										'prompt' => '[--Select Equipment Task--]'));?>
						<?php //echo $form->hiddenField('task','task'); ?>	
						<?php echo $form->error($model,'equipment_task_id'); ?>
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
					  <label class="prefix"><?php echo $form->labelEx($model,'employee_id'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->dropDownList($model, 'employee_id', CHtml::listData(Employee::model()->findAll(), 'id', 'name'),array(
										'prompt' => '[--Select Employee--]'));?>
						<?php echo $form->error($model,'employee_id'); ?>
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
					  <label class="prefix"><?php echo $form->labelEx($model,'maintenance_date'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
											'model' => $model,
											 'attribute' => "maintenance_date",
											 // additional javascript options for the date picker plugin
											 'options'=>array(
												'dateFormat' => 'yy-mm-dd',
												'changeMonth'=>true,
															 'changeYear'=>true,
															 'yearRange'=>'1900:2020',
											),	
											'htmlOptions'=>array(
												'onchange'=>  'jQuery.ajax({
															type: "POST",
															//dataType: "JSON",
															url: "' . CController::createUrl('AjaxGetNext') . '" ,
															data: jQuery("form").serialize(),
															success: function(data){
																jQuery("#EquipmentMaintenance_next_maintenance_date").val(data);
															},
														});',
											),	

															 
										 ));?>
						<?php echo $form->error($model,'maintenance_date'); ?>
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
					  <label class="prefix"><?php echo $form->labelEx($model,'next_maintenance_date'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model, 'next_maintenance_date');?>
						<?php echo $form->error($model,'next_maintenance_date'); ?>
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
					  <label class="prefix"><?php echo $form->labelEx($model,'check_date'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
											'model' => $model,
											 'attribute' => "check_date",
											 // additional javascript options for the date picker plugin
											 'options'=>array(
												'dateFormat' => 'yy-mm-dd',
												'changeMonth'=>true,
															 'changeYear'=>true,
															 'yearRange'=>'1900:2020',
											)						 
										 ));?>
						<?php echo $form->error($model,'check_date'); ?>
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
					  <label class="prefix"><?php echo $form->labelEx($model,'notes'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textArea($model, 'notes');?>
						<?php echo $form->error($model,'notes'); ?>
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
					  <label class="prefix"><?php echo $form->labelEx($model,'equipment_condition'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->dropDownList($model, 'equipment_condition', 
										array('Good' => 'Good',
											  'Bad' => 'Bad',
											  'Need Further Check' => 'Need Further Check',
											  'Need Replacement' => 'Need Replacement')); ?>
						<?php echo $form->error($model,'equipment_condition'); ?>
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
					  <label class="prefix"><?php echo $form->labelEx($model,'checked'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo  $form->dropDownList($model, 'checked', array('Checked' => 'Checked',
									'not-checked' => 'Unchecked', )); ?>
						<?php echo $form->error($model,'checked'); ?>
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