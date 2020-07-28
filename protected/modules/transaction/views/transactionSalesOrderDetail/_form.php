<?php
/* @var $this TransactionSalesOrderDetailController */
/* @var $model TransactionSalesOrderDetail */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'transaction-sales-order-detail-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'sales_order_id'); ?>
		<?php echo $form->textField($model,'sales_order_id'); ?>
		<?php echo $form->error($model,'sales_order_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_id'); ?>
		<?php echo $form->textField($model,'product_id'); ?>
		<?php echo $form->error($model,'product_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'unit_id'); ?>
		<?php echo $form->textField($model,'unit_id'); ?>
		<?php echo $form->error($model,'unit_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'retail_price'); ?>
		<?php echo $form->textField($model,'retail_price',array('size'=>18,'maxlength'=>18)); ?>
		<?php echo $form->error($model,'retail_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'quantity'); ?>
		<?php echo $form->textField($model,'quantity'); ?>
		<?php echo $form->error($model,'quantity'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'unit_price'); ?>
		<?php echo $form->textField($model,'unit_price',array('size'=>18,'maxlength'=>18)); ?>
		<?php echo $form->error($model,'unit_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'amount'); ?>
		<?php echo $form->textField($model,'amount'); ?>
		<?php echo $form->error($model,'amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'discount_step'); ?>
		<?php echo $form->textField($model,'discount_step'); ?>
		<?php echo $form->error($model,'discount_step'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'discount1_type'); ?>
		<?php echo $form->textField($model,'discount1_type'); ?>
		<?php echo $form->error($model,'discount1_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'discount1_nominal'); ?>
		<?php echo $form->textField($model,'discount1_nominal',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'discount1_nominal'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'discount1_temp_quantity'); ?>
		<?php echo $form->textField($model,'discount1_temp_quantity'); ?>
		<?php echo $form->error($model,'discount1_temp_quantity'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'discount1_temp_price'); ?>
		<?php echo $form->textField($model,'discount1_temp_price',array('size'=>18,'maxlength'=>18)); ?>
		<?php echo $form->error($model,'discount1_temp_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'discount2_type'); ?>
		<?php echo $form->textField($model,'discount2_type'); ?>
		<?php echo $form->error($model,'discount2_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'discount2_nominal'); ?>
		<?php echo $form->textField($model,'discount2_nominal',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'discount2_nominal'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'discount2_temp_quantity'); ?>
		<?php echo $form->textField($model,'discount2_temp_quantity'); ?>
		<?php echo $form->error($model,'discount2_temp_quantity'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'discount2_temp_price'); ?>
		<?php echo $form->textField($model,'discount2_temp_price',array('size'=>18,'maxlength'=>18)); ?>
		<?php echo $form->error($model,'discount2_temp_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'discount3_type'); ?>
		<?php echo $form->textField($model,'discount3_type'); ?>
		<?php echo $form->error($model,'discount3_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'discount3_nominal'); ?>
		<?php echo $form->textField($model,'discount3_nominal',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'discount3_nominal'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'discount3_temp_quantity'); ?>
		<?php echo $form->textField($model,'discount3_temp_quantity'); ?>
		<?php echo $form->error($model,'discount3_temp_quantity'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'discount3_temp_price'); ?>
		<?php echo $form->textField($model,'discount3_temp_price',array('size'=>18,'maxlength'=>18)); ?>
		<?php echo $form->error($model,'discount3_temp_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'discount4_type'); ?>
		<?php echo $form->textField($model,'discount4_type'); ?>
		<?php echo $form->error($model,'discount4_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'discount4_nominal'); ?>
		<?php echo $form->textField($model,'discount4_nominal',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'discount4_nominal'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'discount4_temp_quantity'); ?>
		<?php echo $form->textField($model,'discount4_temp_quantity'); ?>
		<?php echo $form->error($model,'discount4_temp_quantity'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'discount4_temp_price'); ?>
		<?php echo $form->textField($model,'discount4_temp_price',array('size'=>18,'maxlength'=>18)); ?>
		<?php echo $form->error($model,'discount4_temp_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'discount5_type'); ?>
		<?php echo $form->textField($model,'discount5_type'); ?>
		<?php echo $form->error($model,'discount5_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'discount5_nominal'); ?>
		<?php echo $form->textField($model,'discount5_nominal',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'discount5_nominal'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'discount5_temp_quantity'); ?>
		<?php echo $form->textField($model,'discount5_temp_quantity'); ?>
		<?php echo $form->error($model,'discount5_temp_quantity'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'discount5_temp_price'); ?>
		<?php echo $form->textField($model,'discount5_temp_price',array('size'=>18,'maxlength'=>18)); ?>
		<?php echo $form->error($model,'discount5_temp_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'total_quantity'); ?>
		<?php echo $form->textField($model,'total_quantity'); ?>
		<?php echo $form->error($model,'total_quantity'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'total_price'); ?>
		<?php echo $form->textField($model,'total_price',array('size'=>18,'maxlength'=>18)); ?>
		<?php echo $form->error($model,'total_price'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->