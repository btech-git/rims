<?php
/* @var $this JurnalPenyesuaianController */
/* @var $model JurnalPenyesuaian */
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
					<?php echo $form->label($model,'transaction_number', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">
					<?php echo $form->textField($model,'transaction_number',array('size'=>50,'maxlength'=>50)); ?>
				</div>
			</div>
		</div>	

		<!-- BEGIN FIELDS -->
		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($model,'transaction_date', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">
					<?php echo $form->textField($model,'transaction_date'); ?>
				</div>
			</div>
		</div>	

		<!-- BEGIN FIELDS -->
		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($model,'coa_biaya_id', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">
					<?php echo $form->textField($model,'coa_biaya_id'); ?>
				</div>
			</div>
		</div>	

		<!-- BEGIN FIELDS -->
		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($model,'coa_akumulasi_id', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">
					<?php echo $form->textField($model,'coa_akumulasi_id'); ?>
				</div>
			</div>
		</div>	

		<!-- BEGIN FIELDS -->
		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($model,'amount', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">
					<?php echo $form->textField($model,'amount',array('size'=>18,'maxlength'=>18)); ?>
				</div>
			</div>
		</div>	

		<!-- BEGIN FIELDS -->
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

		<!-- BEGIN FIELDS -->
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

		<div class="field buttons text-right">
			<?php echo CHtml::submitButton('Search',array('class'=>'button cbutton')); ?>
		</div>
	</div>
</div>
<?php $this->endWidget(); ?>

</div><!-- search-form -->