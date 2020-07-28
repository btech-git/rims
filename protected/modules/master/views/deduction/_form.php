<?php
/* @var $this DeductionController */
/* @var $model Deduction */
/* @var $form CActiveForm */
?>

<div class="clearfix page-action">
<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/deduction/admin';?>"><span class="fa fa-th-list"></span>Manage Deduction</a>
<h1><?php if($model->isNewRecord){ echo "New Deduction"; }else{ echo "Update Deduction";}?></h1>
<hr />
<!-- begin FORM -->

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'deduction-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php //echo $form->errorSummary($model); ?>

	<div class="row">
    <div class="small-12 medium-6 columns">

         
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
	

		<!-- <div class="field">
            <div class="row collapse">
                <div class="small-4 columns">
                  <label class="prefix"><?php //echo $form->labelEx($model,'amount'); ?></label>
                </div>
                <div class="small-8 columns">
				    <?php //echo $form->textField($model,'amount',array('size'=>60,'maxlength'=>100)); ?>
					<?php //echo $form->error($model,'amount'); ?>
				</div>
            </div>
         </div> -->
		 
	</div>
	</div>
		

	<hr>
	<div class="field buttons text-center">
		  <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
	</div>
<?php $this->endWidget(); ?>

</div>
</div>
