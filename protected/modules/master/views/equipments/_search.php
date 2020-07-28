<?php
/* @var $this EquipmentsController */
/* @var $model Equipments */
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
							<?php echo $form->label($model,'name',array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'name',array('size'=>30,'maxlength'=>30)); ?>
						</div>
					</div>
				</div>
				
				<!-- BEGIN field -->
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'status',array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo  $form->dropDownList($model, 'status', array('0' => 'Active',
							'1' => 'Inactive', )); ?>
						</div>
					</div>
				</div>
				<div class="field text-right">
					<div class="row collapse">
						<div class="small-12 columns">
							<?php echo CHtml::submitButton('Search', array('class'=>'button cbutton')); ?>
						</div>
					</div>
				</div>
			</div>
		</div>


		<?php $this->endWidget(); ?>

</div><!-- search-form -->