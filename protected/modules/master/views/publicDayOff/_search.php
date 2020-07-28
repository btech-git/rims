<?php
/* @var $this PublicDayOffController */
/* @var $model PublicDayOff */
/* @var $form CActiveForm */
?>

<div class="wide form" id="advSearch">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<div class="small-12 medium-6 columns">

		<!-- BEGIN FIELDS -->
		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($model,'id', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">
					<?php echo $form->textField($model,'id'); ?>
				</div>
			</div>
		</div>	

		<!-- BEGIN FIELDS -->
		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($model,'date', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">
					<?php echo $form->textField($model,'date'); ?>
				</div>
			</div>
		</div>	

		<!-- BEGIN FIELDS -->
		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($model,'description', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">
					<?php echo $form->textField($model,'description',array('size'=>60,'maxlength'=>255)); ?>
				</div>
			</div>
		</div>	

		<div class="field buttons text-right">
			<?php echo CHtml::submitButton('Search',array('class'=>'button cbutton')); ?>
		</div>
	</div>
</div>
<?php $this->endWidget(); ?>

</div><!-- search-form -->