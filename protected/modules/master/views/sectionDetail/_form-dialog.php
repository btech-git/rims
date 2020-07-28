<?php
/* @var $this LevelController */
/* @var $model Level */
/* @var $form CActiveForm */
?>
<div class="form">

   <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'section-detail-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('onsubmit' => 'return false;'),
)); ?>
 <hr>
   <p class="note">Fields with <span class="required">*</span> are required.</p>
	
   
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
		 
	</div>
	<div class="small-12 medium-5b columns"></div>
   </div>

   <hr>
	<div class="field buttons text-center">
		  <?php //echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>

		  <?php if ($model->isNewRecord): ?>
			<?php echo CHtml::submitButton('Create', array(
				'class'=>'button larger radius',
				'onclick' => 'if (window.confirm("Are you sure you want to save?")) ' . CHtml::ajax(array(
					'type'=>'POST',
					'url'=>CController::createUrl('ajaxHtmlCreate'),
					'update'=>'#section_detail_div',
				)),
			)); ?>
		<?php else: ?>
			<?php echo CHtml::submitButton('Save', array(
				'class'=>'button larger radius',
				'onclick' => 'if (window.confirm("Are you sure you want to save?")) ' . CHtml::ajax(array(
					'type'=>'POST',
					'url'=>CController::createUrl('ajaxHtmlUpdate', array('id' => $model->id)),
					'update'=>'#section_detail_div',
				)),
			)); ?>
		<?php endif; ?>

	</div>
<?php $this->endWidget(); ?>

</div>
</div>
