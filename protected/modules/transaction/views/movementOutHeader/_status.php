<?php
/* @var $this TransaksiOrderPembelianController */
/* @var $model TransaksiORderPembelian */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'movement-out-header-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>
	<div class="row">
		<div class="small-12 medium-6 columns">

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($model,'supervisor_id'); ?></label>
				  </div>
					<div class="small-8 columns">
							<?php echo $form->textField($model, 'supervisor_id',array('value'=>Yii::app()->user->getId(),'readonly'=>true)); ?>
							<?php echo $form->error($model,'supervisor_id'); ?>
					</div>
				</div>
		 	</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($model,'status'); ?></label>
				  </div>
					<div class="small-8 columns">
								<?php echo $form->dropDownList($model, 'status', array('Approved' => 'Approved','Decline'=>'Decline','Need Revise'=>'Need Revise'),array('prompt'=>'[--Select Approval Status--]'));?>
						<?php echo $form->error($model,'status'); ?>
					</div>
				</div>
		 	</div>	

		 	<div class="field buttons text-center">
				<?php echo CHtml::submitButton('Save', array('class'=>'button cbutton')); ?>
			</div>
		</div>

	</div>

	
	

<?php $this->endWidget(); ?>

</div><!-- form -->