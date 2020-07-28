<?php
/* @var $this UnitController */
/* @var $model Unit */
/* @var $form CActiveForm */
?>

<div class="clearfix page-action">
	<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/unit/admin';?>"><span class="fa fa-th-list"></span>Manage Unit</a>
	<h1><?php if($model->isNewRecord){ echo "New Unit"; }else{ echo "Update Unit";}?></h1>
	<!-- begin FORM -->
	
	<div class="form">
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'unit-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
			'enableAjaxValidation'=>false,
			)
		); 
		?>


		<hr>
		<p class="note">Fields with <span class="required">*</span> are required.</p>

		<?php echo $form->errorSummary($model); ?>

		<div class="row">
			<div class="small-12 medium-6 columns">

				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->labelEx($model,'name', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'name',array('size'=>30,'maxlength'=>30)); ?>
							<?php echo $form->error($model,'name'); ?>
						</div>
					</div>
				</div>



				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<label class="prefix"><?php echo $form->labelEx($model,'status'); ?></label>  
						</div>
						<div class="small-8 columns">
							<?php echo $form->dropDownList($model, 'status', array('Active' => 'Active',
							'Inactive' => 'Inactive', )); ?>
							<?php echo $form->error($model,'status'); ?>
						</div>
					</div>
				</div>
			</div>

			<hr>
			<div class="field buttons text-center">
				<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
			</div>
			<?php $this->endWidget(); ?>

		</div>
	</div>
</div>