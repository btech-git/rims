<?php
/* @var $this EquipmentSubTypeController */
/* @var $model EquipmentSubType */
/* @var $form CActiveForm */
?>

<div class="clearfix page-action">
	<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/equipmentSubType/admin';?>"><span class="fa fa-th-list"></span>Manage Equipment Sub Type</a>
	<h1><?php if($model->isNewRecord){ echo "New Equipment Sub Type"; }else{ echo "Update Equipment Sub Type";}?></h1>
	<!-- begin FORM -->

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'equipment-sub-type-form',
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
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
						<label class="prefix"><?php echo $form->labelEx($model,'equipment_type_id'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->dropDownList($model, 'equipment_type_id', CHtml::listData(EquipmentType::model()->findAll(), 'id', 'name'),array(
			               		'prompt' => '[--Select Equipment Type--]')); ?>
						<?php echo $form->error($model,'equipment_type_id'); ?>
					</div>
				</div>
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($model,'name'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>100)); ?>
						<?php echo $form->error($model,'name'); ?>
					</div>
				</div>
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($model,'description'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
						<?php echo $form->error($model,'description'); ?>
					</div>
				</div>
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($model,'status'); ?>
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
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
	</div>

	<?php $this->endWidget(); ?>
</div><!-- form -->

	