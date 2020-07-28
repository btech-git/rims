<?php
/* @var $this CustomerServiceRateController */
/* @var $model CustomerServiceRate */
/* @var $form CActiveForm */
?>


<div class="wide form" id="advSearch">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>


<div class="row">
	<div class="small-12 medium-6 columns">

	  <!-- BEGIN field -->
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
	
	<!-- BEGIN field -->
	<div class="field">
         <div class="row collapse">
            <div class="small-4 columns">
				<?php echo $form->label($model,'customer_id', array('class'=>'prefix')); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'customer_id',array('size'=>10,'maxlength'=>10)); ?>
			</div>
		</div>
	</div>	
</div>
	<div class="small-12 medium-6 columns">
	<!-- BEGIN field -->
	<div class="field">
         <div class="row collapse">
            <div class="small-4 columns">
				<?php echo $form->label($model,'service_id', array('class'=>'prefix')); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'service_id',array('size'=>10,'maxlength'=>10)); ?>
			</div>
		</div>
	</div>	

	<!-- BEGIN field -->
			<div class="field">
				 <div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->label($model,'rate', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
							<?php echo $form->textField($model,'rate',array('size'=>10,'maxlength'=>10)); ?>
					</div>
				</div>
			</div>
		</div>
</div>

<div class="field buttons text-right">
   <?php echo CHtml::submitButton('Search', array('class' => 'button cbutton')); ?>
</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->


 