<?php
/* @var $this InsuranceCompanyController */
/* @var $model InsuranceCompany */
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
							<?php echo $form->labelEx($model,'name', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'name',array('size'=>30,'maxlength'=>30)); ?>
						</div>
					</div>
				</div>

				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->labelEx($model,'address', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textArea($model,'address',array('rows'=>6, 'cols'=>50)); ?>
						</div>
					</div>
				</div>
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->labelEx($model,'email', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'email',array('size'=>50,'maxlength'=>50)); ?>
						</div>
					</div>
				</div>
			</div>
				<?php /*
				<div class="field">
				<div class="row collapse">
				<div class="small-4 columns">
				<label class="prefix">
				<?php echo $form->labelEx($model,'province_id'); ?> </label></div>
				<div class="small-8 columns">
				<?php echo $form->textField($model,'province_id',array('size'=>50,'maxlength'=>50)); ?>
				</div>
				</div>
				</div>

				<div class="field">
				<div class="row collapse">
				<div class="small-4 columns">
				<label class="prefix">
				<?php echo $form->labelEx($model,'city_id'); ?> </label></div>
				<div class="small-8 columns">
				<?php echo $form->textField($model,'city_id',array('size'=>50,'maxlength'=>50)); ?>
				</div>
				</div>
				</div>
				*/?>
			<div class="small-12 medium-6 columns">


				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->labelEx($model,'phone', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'phone',array('size'=>20,'maxlength'=>20)); ?>
						</div>
					</div>
				</div>

				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->labelEx($model,'fax', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'fax',array('size'=>20,'maxlength'=>20)); ?>
						</div>
					</div>
				</div>

				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->labelEx($model,'npwp', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'npwp',array('size'=>20,'maxlength'=>20)); ?>
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
				<div class="row buttons text-right">
					<?php echo CHtml::submitButton('Search', array('class'=>'button cbutton'));?>
				</div>
			</div>
		</div>

	<?php $this->endWidget(); ?>

</div><!-- search-form -->