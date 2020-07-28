<?php
/* @var $this IncentiveController */
/* @var $model Incentive */
/* @var $form CActiveForm */
?>

<div class="wide form" id="advSearch">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
	<div class="row">
		<div class="small-12 medium-6 columns">

	
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->label($model,'id', array('class'=>'prefix'));?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'id');?>
			</div>
		</div>
	</div>

	
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->label($model,'name', array('class'=>'prefix'));?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>100));?>
			</div>
		</div>
	</div>
</div>
		<div class="small-12 medium-6 columns">
	
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->label($model,'description', array('class'=>'prefix'));?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textArea($model,'description',array('rows'=>3, 'cols'=>50));?>
			</div>
		</div>
	</div>

	<div class="row">
		<?php //echo $form->label($model,'amount'); ?>
		<?php //echo $form->textField($model,'amount',array('size'=>60,'maxlength'=>100));?>
	</div>
	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->label($model,'is_deleted', array('class'=>'prefix'));?>
			</div>
			<div class="small-8 columns">
				<?php echo  $form->dropDownList($model, 'is_deleted', array(1=> 'Show Deleted',
				0 => 'Hide Deleted', ), array('prompt' => 'Select',)); ?>
			</div>
		</div>
	</div>

	<div class="row buttons text-right">
		<?php echo CHtml::submitButton('Search', array('class'=>'button cbutton'));?>
			</div>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->