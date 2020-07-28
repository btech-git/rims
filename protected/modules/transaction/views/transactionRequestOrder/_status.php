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
					  <label class="prefix"><?php echo $form->labelEx($model,'approved_by'); ?></label>
				  </div>
					<div class="small-8 columns">
							<?php echo $form->textField($model, 'approved_by'); ?>
							<?php echo $form->error($model,'approved_by'); ?>
					</div>
				</div>
		 	</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($model,'approved_status'); ?></label>
				  </div>
					<div class="small-8 columns">
								<?php echo $form->dropDownList($model, 'approved_status', array('Approved' => 'Approved','Decline'=>'Decline','Need Revise'=>'Need Revise'),array('prompt'=>'[--Select Approval Status--]'));
		?>
						<?php echo $form->error($model,'approved_status'); ?>
					</div>
				</div>
		 	</div>	

		 	<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($model,'decline_memo'); ?></label>
				  </div>
					<div class="small-8 columns">
								<?php echo $form->textArea($model, 'decline_memo', array('rows'=>15, 'cols'=>50));
		?>
						<?php echo $form->error($model,'decline_memo'); ?>
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