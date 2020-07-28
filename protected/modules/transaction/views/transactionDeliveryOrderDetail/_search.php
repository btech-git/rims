<?php
/* @var $this TransactionDeliveryOrderDetailController */
/* @var $model TransactionDeliveryOrderDetail */
/* @var $form CActiveForm */
?>

<div class="wide form" id="advSearch">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
	<div class="row">
	<div class="small-12 medium-6 columns">
	
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->label($model,'id', array('class'=>'prefix'));?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'id');?>
			</div>
		</div>
	</div>

	
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->label($model,'delivery_order_id', array('class'=>'prefix'));?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'delivery_order_id');?>
			</div>
		</div>
	</div>

	
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->label($model,'product_id', array('class'=>'prefix'));?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'product_id');?>
			</div>
		</div>
	</div>

	
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->label($model,'quantity_request', array('class'=>'prefix'));?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'quantity_request');?>
			</div>
		</div>
	</div>
	</div>
	<div class="small-12 medium-6 columns">

	
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->label($model,'quantity_delivery', array('class'=>'prefix'));?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'quantity_delivery');?>
			</div>
		</div>
	</div>

	
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->label($model,'quantity_request_left', array('class'=>'prefix'));?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'quantity_request_left');?>
			</div>
		</div>
	</div>

	
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->label($model,'note', array('class'=>'prefix'));?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textArea($model,'note',array('rows'=>6, 'cols'=>50));?>
			</div>
		</div>
	</div>

	
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->label($model,'barcode_product', array('class'=>'prefix'));?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'barcode_product',array('size'=>50,'maxlength'=>50));?>
			</div>
		</div>
	</div>

	<div class="row buttons text-right">
		<?php echo CHtml::submitButton('Search', array('class'=>'button cbutton'));?>
			</div>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->