<?php
/* @var $this TransactionRequestOrderDetailController */
/* @var $model TransactionRequestOrderDetail */
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
						<?php echo $form->label($model,'request_order_id', array('class'=>'prefix'));?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'request_order_id');?>
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
						<?php echo $form->label($model,'supplier_id', array('class'=>'prefix'));?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'supplier_id');?>
			</div>
		</div>
	</div>

	
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->label($model,'unit_id', array('class'=>'prefix'));?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'unit_id');?>
			</div>
		</div>
	</div>

	
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->label($model,'discount_percent', array('class'=>'prefix'));?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'discount_percent');?>
			</div>
		</div>
	</div>
	</div>
		<div class="small-12 medium-6 columns">

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->label($model,'discount_nominal', array('class'=>'prefix'));?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'discount_nominal',array('size'=>10,'maxlength'=>10));?>
			</div>
		</div>
	</div>

	
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->label($model,'quantity', array('class'=>'prefix'));?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'quantity');?>
			</div>
		</div>
	</div>

	
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->label($model,'price', array('class'=>'prefix'));?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'price',array('size'=>10,'maxlength'=>10));?>
			</div>
		</div>
	</div>

	
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->label($model,'subtotal', array('class'=>'prefix'));?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'subtotal',array('size'=>10,'maxlength'=>10));?>
			</div>
		</div>
	</div>

	
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->label($model,'purchase_order_quantity', array('class'=>'prefix'));?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'purchase_order_quantity');?>
			</div>
		</div>
	</div>

	
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->label($model,'request_order_quantity', array('class'=>'prefix'));?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'request_order_quantity');?>
			</div>
		</div>
	</div>

	
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->label($model,'notes', array('class'=>'prefix'));?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textArea($model,'notes',array('rows'=>6, 'cols'=>50));?>
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