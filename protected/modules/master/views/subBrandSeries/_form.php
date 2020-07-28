<?php
/* @var $this SubBrandSeriesController */
/* @var $model SubBrandSeries */
/* @var $form CActiveForm */
?>

<div class="clearfix page-action">
	<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/subBrandSeries/admin';?>"><span class="fa fa-th-list"></span>Manage Sub-Brand Series</a>
	<h1><?php if($model->isNewRecord){ echo "New Sub-Brand Series"; }else{ echo "Update Sub-Brand Series";}?></h1>
	<!-- begin FORM -->

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'sub-brand-series-form',
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
						<label class="prefix"><?php echo $form->labelEx($model,'sub_brand_id'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php //echo $form->textField($model,'sub_brand_id'); ?>
						<?php echo $form->dropDownList($model,'sub_brand_id', CHtml::listData(SubBrand::model()->findAll(),'id','name')); ?>
						<?php echo $form->error($model,'sub_brand_id'); ?>
					</div>
				</div>
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($model,'name'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'name',array('size'=>30,'maxlength'=>30)); ?>
						<?php echo $form->error($model,'name'); ?>
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