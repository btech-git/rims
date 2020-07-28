<?php
/* @var $this EquipmentTaskController */
/* @var $model EquipmentTask */
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
			<?php echo $form->label($model,'equipment_id', array('class'=>'prefix')); ?>
			</div>
			<div class="small-8 columns">
			<?php echo $form->dropDownList($model, 'equipment_id', CHtml::listData(Equipments::model()->findAll(), 'id', 'name'),array(
										'prompt' => '[--Select Equipment--]'));?>
			</div>
		</div>
	</div>

	  <!-- BEGIN field -->
	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
			<?php echo $form->label($model,'task', array('class'=>'prefix')); ?>
			</div>
			<div class="small-8 columns">
			<?php echo $form->textField($model,'task',array('size'=>20,'maxlength'=>20)); ?>
			</div>
		</div>
	</div>
	  
	<!-- BEGIN field -->
	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
			<?php echo $form->label($model,'check_period', array('class'=>'prefix')); ?>
			</div>
			<div class="small-8 columns">
			<?php echo $form->textField($model,'check_period',array('size'=>20,'maxlength'=>20)); ?>
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