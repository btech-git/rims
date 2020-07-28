<?php
/* @var $this InvoiceDetailController */
/* @var $model InvoiceDetail */
/* @var $form CActiveForm */
?>

<div class="wide form" id="advSearch">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<div class="small-12 medium-6 columns">

		<!-- BEGIN FIELDS -->
		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($model,'id', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">
					<?php echo $form->textField($model,'id'); ?>
				</div>
			</div>
		</div>	

		<!-- BEGIN FIELDS -->
		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($model,'invoice_id', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">
					<?php echo $form->textField($model,'invoice_id'); ?>
				</div>
			</div>
		</div>	

		<!-- BEGIN FIELDS -->
		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($model,'service_id', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">
					<?php echo $form->textField($model,'service_id'); ?>
				</div>
			</div>
		</div>	

		<!-- BEGIN FIELDS -->
		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($model,'product_id', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">
					<?php echo $form->textField($model,'product_id'); ?>
				</div>
			</div>
		</div>	

		<!-- BEGIN FIELDS -->
		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($model,'quantity', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">
					<?php echo $form->textField($model,'quantity'); ?>
				</div>
			</div>
		</div>	

		<!-- BEGIN FIELDS -->
		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($model,'unit_price', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">
					<?php echo $form->textField($model,'unit_price',array('size'=>18,'maxlength'=>18)); ?>
				</div>
			</div>
		</div>	

		<!-- BEGIN FIELDS -->
		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($model,'total_price', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">
					<?php echo $form->textField($model,'total_price',array('size'=>18,'maxlength'=>18)); ?>
				</div>
			</div>
		</div>	

		<div class="field buttons text-right">
			<?php echo CHtml::submitButton('Search',array('class'=>'button cbutton')); ?>
		</div>
	</div>
</div>
<?php $this->endWidget(); ?>

</div><!-- search-form -->