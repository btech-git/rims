<?php
/* @var $this TransaksiOrderPembelianController */
/* @var $model TransaksiORderPembelian */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'transaction-request-order-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>
	<div class="row">
		<div class="small-12 medium-6 columns">

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($model,'branch_approved_id'); ?></label>
				  </div>
					<div class="small-8 columns">
							<?php echo $form->textField($model, 'branch_approved_id'); ?>
							<?php echo $form->error($model,'branch_approved_id'); ?>
					</div>
				</div>
		 	</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($model,'branch_approved_status'); ?></label>
				  </div>
					<div class="small-8 columns">
								<?php echo $form->dropDownList($model, 'branch_approved_status', array('Approved' => 'Approved','Decline'=>'Decline','Need Revise'=>'Need Revise'),array('prompt'=>'[--Select Approval Status--]'));
		?>
						<?php echo $form->error($model,'branch_approved_status'); ?>
					</div>
				</div>
		 	</div>	

		 	<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($model,'branch_approved_notes'); ?></label>
				  </div>
					<div class="small-8 columns">
								<?php echo $form->textArea($model, 'branch_approved_notes', array('rows'=>15, 'cols'=>50));
		?>
						<?php echo $form->error($model,'branch_approved_notes'); ?>
					</div>
				</div>
				<div class="field buttons text-center">
				<?php echo CHtml::submitButton('Save', array('class'=>'button cbutton')); ?>
			</div>
		 	</div>	
		 			
		</div>

	</div>

	
	

<?php $this->endWidget(); ?>

</div><!-- form -->