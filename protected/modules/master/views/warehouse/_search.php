<?php
/* @var $this WarehouseController */
/* @var $model Warehouse */
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
				<?php echo $form->label($model,'id',array('class'=>'prefix'));?>
				</div>
				<div class="small-8 columns">
				<?php echo $form->textField($model,'id'); ?>
				</div>
			</div>
		</div>
		
	<!-- BEGIN field -->
	<!-- BEGIN field -->
			<div class="field">
				 <div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->label($model,'description',array('class'=>'prefix'));?>
					</div>
					<div class="small-8 columns">
						<?php echo  $form->textArea($model, 'description',array('row'=>20,'column'=>20)); ?>
					</div>
				</div>
			</div>
	</div>
	<div class="small-12 medium-6 columns">

	<div class="field">
         <div class="row collapse">
            <div class="small-4 columns">
				<?php echo $form->label($model,'code',array('class'=>'prefix'));?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'code',array('size'=>20,'maxlength'=>20)); ?>
			</div>
		</div>
	</div>

	<!-- BEGIN field -->
	<div class="field">
         <div class="row collapse">
            <div class="small-4 columns">
				<?php echo $form->label($model,'name',array('class'=>'prefix'));?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'name',array('size'=>20,'maxlength'=>20)); ?>
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
						<?php echo  $form->dropDownList($model, 'status', array( 
							'Active' => 'Active','Inactive' => 'Inactive', 
							), array('prompt' => 'Select',)); 
						?>
					</div>
				</div>
			</div>
	<div class="field buttons text-right">
	   <?php echo CHtml::submitButton('Search', array('class' => 'button cbutton'));?>
			</div>
		</div>
	</div>

	<?php $this->endWidget(); ?>

	</div><!-- search-form -->