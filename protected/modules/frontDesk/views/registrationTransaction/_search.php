<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */
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
				<?php echo $form->label($model,'id', array('class'=>'prefix')); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'id'); ?>
			</div>
		</div>
	</div>	

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->label($model,'transaction_number', array('class'=>'prefix')); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'transaction_number',array('size'=>30,'maxlength'=>30)); ?>
			</div>
		</div>
	</div>	

	<?php /*
	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->label($model,'transaction_date', array('class'=>'prefix')); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'transaction_date'); ?>
			</div>
		</div>
	</div>	*/?>

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->label($model,'repair_type', array('class'=>'prefix')); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'repair_type',array('size'=>30,'maxlength'=>30)); ?>
			</div>
		</div>
	</div>	

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->label($model,'problem', array('class'=>'prefix')); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textArea($model,'problem',array('rows'=>6, 'cols'=>50)); ?>
			</div>
		</div>
	</div>	

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->label($model,'customer_id', array('class'=>'prefix')); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'customer_id'); ?>
			</div>
		</div>
	</div>	

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->label($model,'pic_id', array('class'=>'prefix')); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'pic_id'); ?>
			</div>
		</div>
	</div>	

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->label($model,'vehicle_id', array('class'=>'prefix')); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'vehicle_id'); ?>
			</div>
		</div>
	</div>	

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->label($model,'branch_id', array('class'=>'prefix')); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'branch_id'); ?>
			</div>
		</div>
	</div>
	</div>
	<div class="small-12 medium-6 columns">
	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->label($model,'user_id', array('class'=>'prefix')); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'user_id'); ?>
			</div>
		</div>
	</div>	

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->label($model,'total_quickservice', array('class'=>'prefix')); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'total_quickservice'); ?>
			</div>
		</div>
	</div>	

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->label($model,'total_quickservice_price', array('class'=>'prefix')); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'total_quickservice_price',array('size'=>18,'maxlength'=>18)); ?>
			</div>
		</div>
	</div>	

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->label($model,'total_service', array('class'=>'prefix')); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'total_service'); ?>
			</div>
		</div>
	</div>	

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->label($model,'subtotal_service', array('class'=>'prefix')); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'subtotal_service',array('size'=>18,'maxlength'=>18)); ?>
			</div>
		</div>
	</div>	

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->label($model,'discount_service', array('class'=>'prefix')); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'discount_service',array('size'=>18,'maxlength'=>18)); ?>
			</div>
		</div>
	</div>	

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->label($model,'total_service_price', array('class'=>'prefix')); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'total_service_price',array('size'=>18,'maxlength'=>18)); ?>
			</div>
		</div>
	</div>	

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->label($model,'total_product', array('class'=>'prefix')); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'total_product',array('size'=>10,'maxlength'=>10)); ?>
			</div>
		</div>
	</div>	

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->label($model,'subtotal_product', array('class'=>'prefix')); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'subtotal_product',array('size'=>18,'maxlength'=>18)); ?>
			</div>
		</div>
	</div>	

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->label($model,'discount_product', array('class'=>'prefix')); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'discount_product',array('size'=>18,'maxlength'=>18)); ?>
			</div>
		</div>
	</div>	

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->label($model,'total_product_price', array('class'=>'prefix')); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'total_product_price',array('size'=>18,'maxlength'=>18)); ?>
			</div>
		</div>
	</div>	

	<div class="row buttons text-right">
		<?php echo CHtml::submitButton('Search', array('class'=>'button cbutton')); ?>
	</div>
	</div>
</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->