<?php
/* @var $this CompanyController */
/* @var $model Company */
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
							<?php echo $form->labelEx($model,'name',array('class'=>'prefix')); ?></div>
					<div class="small-8 columns">
							<?php echo $form->textField($model,'name',array('size'=>30,'maxlength'=>30)); ?>
					</div>
				</div>
			 </div>			

			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  
							<?php echo $form->labelEx($model,'address',array('class'=>'prefix')); ?></div>
					<div class="small-8 columns">
							<?php echo $form->textArea($model,'address',array('rows'=>3, 'cols'=>40)); ?>
					</div>
				</div>
			 </div>
		</div>	 
 		<div class="small-12 medium-6 columns">
			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  
							<?php echo $form->labelEx($model,'phone',array('class'=>'prefix')); ?></div>
					<div class="small-8 columns">
							<?php echo $form->textField($model,'phone',array('size'=>20,'maxlength'=>20)); ?>
					</div>
				</div>
			 </div>

			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  
							<?php echo $form->labelEx($model,'npwp',array('class'=>'prefix')); ?></div>
					<div class="small-8 columns">
							<?php echo $form->textField($model,'npwp',array('size'=>20,'maxlength'=>20)); ?>
					</div>
				</div>
			 </div>

			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  
							<?php echo $form->labelEx($model,'tax_status',array('class'=>'prefix')); ?></div>
					<div class="small-8 columns">
							<?php echo $form->textField($model,'tax_status',array('size'=>20,'maxlength'=>20)); ?>
					</div>
				</div>
			 </div>
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'is_deleted', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo  $form->dropDownList($model, 'is_deleted', array(1=> 'Show Deleted',
							0 => 'Hide Deleted', ), array('prompt' => 'Select',)); ?>
						</div>
					</div>
				</div>

	<div class="field buttons text-right">
		<?php echo CHtml::submitButton('Search' , array('class'=>'button cbutton'));?>
			</div>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->