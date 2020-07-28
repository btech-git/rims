<?php
/* @var $this InspectionModuleController */
/* @var $model InspectionModule */
/* @var $form CActiveForm */
?>

<div class="clearfix page-action">
<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/inspectionModule/admin';?>"><span class="fa fa-th-list"></span>Manage Inspection Modules</a>
<h1><?php if($model->isNewRecord){ echo "New Inspection Module"; }else{ echo "Update Inspection Module";}?></h1>
<!-- begin FORM -->

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'inspection-module-form',
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation'=>false,
	)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<div class="row">
		<div class="small-12 medium-6 columns">
			
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"> <?php echo $form->labelEx($model,'code'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'code'); ?>
						<?php echo $form->error($model,'code'); ?>
					</div>
				</div>
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($model,'name'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'name',array('size'=>50,'maxlength'=>50)); ?>
						<?php echo $form->error($model,'name'); ?>
					</div>
				</div>
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"> <?php echo $form->labelEx($model,'checklist_type_id'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->dropDownList($model,'checklist_type_id',CHtml::listData(InspectionChecklistType::model()->findAll(),'id','name')); ?>
						<?php echo $form->error($model,'checklist_type_id'); ?>
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