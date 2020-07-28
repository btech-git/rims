<?php
/* @var $this VehicleCarSubDetailController */
/* @var $model VehicleCarSubDetail */
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
			<?php echo $form->label($model,'name'); ?>
			</div>
			<div class="small-8 columns">
			<?php echo $form->textField($model,'name'); ?>
			</div>
		</div>
	</div>	
		</div>
		<div class="small-12 medium-6 columns">

	<!-- BEGIN field -->
	<div class="field">
         <div class="row collapse">
            <div class="small-4 columns">
				<?php echo $form->label($model,'car_make_id'); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->dropDownList($model,'car_make_id', CHtml::listData(VehicleCarMake::model()->findAll(),'id','name'),  array('prompt' => 'Select',)); ?>
			</div>
		</div>
	</div>	

	</div>

	<div class="small-12 medium-6 columns">

	<!-- BEGIN field -->
	<div class="field">
         <div class="row collapse">
            <div class="small-4 columns">
				<?php echo $form->label($model,'car_model_id'); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->dropDownList($model,'car_model_id', CHtml::listData(VehicleCarModel::model()->findAll(),'id','name'),  array('prompt' => 'Select',)); ?>
			</div>
		</div>
	</div>	
	
	</div>
</div>

<div class="field buttons text-right">
   <?php echo CHtml::submitButton('Search', array('class' => 'button cbutton')); ?>
</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
