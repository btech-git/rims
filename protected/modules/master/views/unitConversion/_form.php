<?php
/* @var $this UnitConversionController */
/* @var $model UnitConversion */
/* @var $form CActiveForm */
?>

<div class="clearfix page-action">
<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/unitConversion/admin';?>"><span class="fa fa-th-list"></span>Manage Unit Conversions</a>
<h1><?php if($model->isNewRecord){ echo "New Unit Conversion"; }else{ echo "Update Unit Conversion";}?></h1>
<hr />
<!-- begin FORM -->
<div class="form">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'unit-conversion-form',
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation'=>false,
	)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<div class="small-12 medium-6 columns">         
			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($model,'unit_from_id'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php //echo $form->textField($model,'unit_from_id'); ?>
						<?php $this->widget('ext.combobox.EJuiComboBox', array(
						    'model' => $model,
						    'attribute' => 'unit_from_id',
						    // data to populate the select. Must be an array.
						   	'data' => CHtml::listData(Unit::model()->findAll(),'id','name'),
						   	'assoc'=>true,
						    // options passed to plugin
						    'options' => array(
						        // JS code to execute on 'select' event, the selected item is
						        // available through the 'item' variable.
						        //'onSelect' => 'alert("selected value : " + item.value);',
						        // JS code to be executed on 'change' event, the input is available
						        // through the '$(this)' variable.
						        //'onChange' => 'alert("changed value : " + $(this).val());',
						        // If false, field value must be present in the select.
						        // Defaults to true.
						        'allowText' => true,
						    ),
						    // Options passed to the text input
						    'htmlOptions' => array('size' => 10),
						)); ?>
						<?php echo $form->error($model,'unit_from_id'); ?>
					</div>
				</div>
			 </div>		 
		</div>		
   	</div>

   	<div class="row">
		<div class="small-12 medium-6 columns">         
			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($model,'unit_to_id'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php //echo $form->textField($model,'unit_to_id'); ?>
						<?php $this->widget('ext.combobox.EJuiComboBox', array(
						    'model' => $model,
						    'attribute' => 'unit_to_id',
						    // data to populate the select. Must be an array.
						   	'data' => CHtml::listData(Unit::model()->findAll(),'id','name'),
						   	'assoc'=>true,
						    // options passed to plugin
						    'options' => array(
						        // JS code to execute on 'select' event, the selected item is
						        // available through the 'item' variable.
						        //'onSelect' => 'alert("selected value : " + item.value);',
						        // JS code to be executed on 'change' event, the input is available
						        // through the '$(this)' variable.
						        //'onChange' => 'alert("changed value : " + $(this).val());',
						        // If false, field value must be present in the select.
						        // Defaults to true.
						        'allowText' => true,
						    ),
						    // Options passed to the text input
						    'htmlOptions' => array('size' => 10),
						)); ?>
						<?php echo $form->error($model,'unit_to_id'); ?>
					</div>
				</div>
			 </div>		 
		</div>		
   	</div>

   	<div class="row">
		<div class="small-12 medium-6 columns">         
			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($model,'multiplier'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'multiplier'); ?>
						<?php echo $form->error($model,'multiplier'); ?>
					</div>
				</div>
			 </div>		 
		</div>		
   	</div>
   	<hr>
   	<div class="field buttons text-center">
		  <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
</div>