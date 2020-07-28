<?php
/* @var $this EquipmentBranchController */
/* @var $model EquipmentBranch */
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
			<?php echo $form->label($model,'branch_id', array('class'=>'prefix')); ?>
			</div>
			<div class="small-8 columns">
			<?php echo $form->dropDownList($model, 'branch_id', CHtml::listData(Branch::model()->findAll(), 'id', 'name'),array(
										'prompt' => '[--Select Branch--]'));?>
			</div>
		</div>
	</div>

	<!-- BEGIN field -->
	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
			<?php echo $form->label($model,'purchase_date', array('class'=>'prefix')); ?>
			</div>
			<div class="small-8 columns">
			<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
											'model' => $model,
											 'attribute' => "purchase_date",
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
</div>
<div class="small-12 medium-6 columns">
	<!-- BEGIN field -->
	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
			<?php echo $form->label($model,'age', array('class'=>'prefix')); ?>
			</div>
			<div class="small-8 columns">
			<?php echo $form->textField($model,'age'); ?>
			</div>
		</div>
	</div>
	
	 <!-- BEGIN field -->
	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
			<?php echo $form->label($model,'brand', array('class'=>'prefix')); ?>
			</div>
			<div class="small-8 columns">
			<?php echo $form->textField($model,'brand',array('size'=>30,'maxlength'=>30)); ?>
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