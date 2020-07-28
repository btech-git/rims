<?php
/* @var $this EquipmentMaintenanceController */
/* @var $model EquipmentMaintenance */
/* @var $form CActiveForm */
?>


<div class="wide form" id="advSearch">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

<div class="row">
	<div class="small-12 medium-6 columns">

	<!-- BEGIN field -->
	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
			<?php echo $form->label($model,'equipment_branch_id'); ?>
			</div>
			<div class="small-8 columns">
			<?php echo $form->dropDownList($model, 'equipment_branch_id', CHtml::listData(EquipmentBranch::model()->findAll(), 'id', 'branch.name'),array(
										'prompt' => '[--Select Equipment Branch--]',
										'onchange'=> 'jQuery.ajax({
											type: "POST",
											//dataType: "JSON",
											url: "' . CController::createUrl('ajaxGetTask') . '" ,
											data: jQuery("form").serialize(),
											success: function(data){
												//console.log(data);
												jQuery("#EquipmentMaintenance_equipment_task_id").html(data);
												//jQuery("#task").html(data);
											},
										});'	
										));?>
			</div>
		</div>
	</div>
	
	<!-- BEGIN field -->
	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
			<?php echo $form->label($model,'equipment_task_id'); ?>
			</div>
			<div class="small-8 columns">
			<?php echo $form->dropDownList($model, 'equipment_task_id', CHtml::listData(EquipmentTask::model()->findAll(), 'id', 'task'),array(
										'prompt' => '[--Select Equipment Task--]'));?>
			</div>
		</div>
	</div>
	
	<!-- BEGIN field -->
	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
			<?php echo $form->label($model,'employee_id'); ?>
			</div>
			<div class="small-8 columns">
			<?php echo $form->dropDownList($model, 'employee_id', CHtml::listData(Employee::model()->findAll(), 'id', 'name'),array(
										'prompt' => '[--Select Employee--]'));?>
			</div>
		</div>
	</div>
</div>
	<div class="small-12 medium-6 columns">
	<!-- BEGIN field -->
	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
			<?php echo $form->label($model,'maintenance_date'); ?>
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
															 'yearRange'=>'1900:2020'),
										 ));?>
			</div>
		</div>
	</div>

	<!-- BEGIN field -->
	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
			<?php echo $form->label($model,'next_maintenance_date'); ?>
			</div>
			<div class="small-8 columns">
			<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
											'model' => $model,
											 'attribute' => "next_maintenance_date",
											 // additional javascript options for the date picker plugin
											 'options'=>array(
												 'dateFormat' => 'yy-mm-dd',
												 'changeMonth'=>true,
															 'changeYear'=>true,
															 'yearRange'=>'1900:2020'),
										 ));?>
			</div>
		</div>
	</div>
	
	<!-- BEGIN field -->
	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
			<?php echo $form->label($model,'check_date'); ?>
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
															 'yearRange'=>'1900:2020'),
										 ));?>
			</div>
		</div>
	</div>
	<div class="field buttons text-right">
		<?php echo CHtml::submitButton('Search', array('class'=>'button cbutton'));?>
			</div>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->