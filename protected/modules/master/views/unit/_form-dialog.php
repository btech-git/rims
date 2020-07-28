<?php
/* @var $this LevelController */
/* @var $model Level */
/* @var $form CActiveForm */
?>
<div class="form">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'unit-form',
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
			<div class="small-12 columns">


				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<label class="prefix"><?php echo $form->labelEx($model,'name'); ?></label>  
						</div>
						<div class="small-8 columns">
							<?php echo $form->hiddenField($model,'id',array('size'=>60,'maxlength'=>100)); ?>
							<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>100, 'class'=>'error')); ?>
							<div class="errorMessage">Name cannot be blank.</div>
							<?php //echo $form->error($model,'name'); ?>
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
		</div>

		<hr>
		<div class="field buttons text-center">
			<?php //echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>

			<?php if ($model->isNewRecord): ?>
				<?php echo CHtml::submitButton('Create', array(
					'class'=>'button cbutton',
					'id'=>'createbtn',
					'onclick' => 'if (window.confirm("Are you sure you want to save?")) ' . CHtml::ajax(array(
						'type'=>'POST',
						'url'=>CController::createUrl('ajaxHtmlSave'),
						'update'=>'#unit_div',
						)),
						)); ?>
					<?php else: ?>
						<?php echo CHtml::submitButton('Save', array(
							'class'=>'button cbutton',
							'onclick' => 'if (window.confirm("Are you sure you want to save?")) ' . CHtml::ajax(array(
								'type'=>'POST',
								'url'=>CController::createUrl('ajaxHtmlSave'),
								'update'=>'#unit_div',
								)),
								)); ?>
							<?php endif; ?>

						</div>
						<?php $this->endWidget(); ?>

					</div>

<?php
Yii::app()->clientScript->registerScript('myjquery', '
	$(".errorMessage").hide();	
    $(\'#createbtn\').click(function(){
		var lname = $("#Unit_name").val();
		if (lname.length === 0) {
			$(".errorMessage").show();
			$("#Unit_name").addClass("error");
			return false;
		}else{
			return true;
		}
    })
');
?>