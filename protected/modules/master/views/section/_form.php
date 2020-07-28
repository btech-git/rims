<?php
/* @var $this SectionController */
/* @var $model Section */
/* @var $form CActiveForm */
?>
<div class="clearfix page-action">
<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/section/admin';?>"><span class="fa fa-th-list"></span>Manage Section</a>
<h1><?php if($model->isNewRecord){ echo "New Section"; }else{ echo "Update Section";}?></h1>
<!-- begin FORM -->

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'section-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
	<hr>
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php //echo $form->errorSummary($model); ?>

	<div class="row">
		<div class="small-12 medium-6 columns">         
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($model,'code'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'code',array('size'=>20,'maxlength'=>20)); ?>
						<?php echo $form->error($model,'code'); ?>
					</div>
				</div>
			</div>		 
		</div>
   </div>

	<div class="row">
		<div class="small-12 medium-6 columns">         
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($model,'rack_number'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'rack_number',array('size'=>20,'maxlength'=>20)); ?>
						<?php echo $form->error($model,'rack_number'); ?>
					</div>
				</div>
			</div>		 
		</div>
   </div>

	<div class="row">
		<div class="small-12 medium-6 columns">         
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($model,'column'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'column',array('size'=>20,'maxlength'=>20)); ?>
						<?php echo $form->error($model,'column'); ?>
					</div>
				</div>
			</div>		 
		</div>
   </div>

	<div class="row">
		<div class="small-12 medium-6 columns">         
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($model,'row'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'row',array('size'=>20,'maxlength'=>20)); ?>
						<?php echo $form->error($model,'row'); ?>
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

</div>
</div>