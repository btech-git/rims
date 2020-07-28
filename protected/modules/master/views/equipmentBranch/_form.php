<?php
/* @var $this EquipmentBranchController */
/* @var $model EquipmentBranch */
/* @var $form CActiveForm */
?>

<div class="clearfix page-action">
<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/equipmentBranch/admin';?>"><span class="fa fa-th-list"></span>Manage Equipment Branches</a>
<h1><?php if($model->isNewRecord){ echo "New Branch"; }else{ echo "Update Branch";}?></h1>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'equipment-branch-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
	
	<hr>
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<div class="small-12 medium-6 columns">         
			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($model,'branch_id'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->dropDownList($model, 'branch_id', CHtml::listData(Branch::model()->findAll(), 'id', 'name'),array(
										'prompt' => '[--Select Branch--]'));?>
						<?php echo $form->error($model,'branch_id'); ?>
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
					  <label class="prefix"><?php echo $form->labelEx($model,'purchase_date'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
											'model' => $model,
											 'attribute' => "purchase_date",
											 // additional javascript options for the date picker plugin
											 'options'=>array(
												'dateFormat' => 'yy-mm-dd',
												'changeMonth'=>true,
												 'changeYear'=>true,
												 'yearRange'=>'1900:2020',															 
												
											),	
											'htmlOptions'=>array(
													'onchange'=>  'jQuery.ajax({
																type: "POST",
																//dataType: "JSON",
																url: "' . CController::createUrl('ajaxGetAge') . '" ,
																data: jQuery("form").serialize(),
																success: function(data){
																	jQuery("#EquipmentBranch_age").val(data);
																},
															});',
													),
										 )); ?>
						<?php echo $form->error($model,'purchase_date'); ?>
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
					  <label class="prefix"><?php echo $form->labelEx($model,'age'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'age',array('placeHolder'=>'how many days old','readOnly'=>'readOnly')); ?>
						<?php echo $form->error($model,'age'); ?>
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
					  <label class="prefix"><?php echo $form->labelEx($model,'brand'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'brand',array('size'=>30,'maxlength'=>30)); ?>
						<?php echo $form->error($model,'brand'); ?>
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
					  <label class="prefix"><?php echo $form->labelEx($model,'quantity'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'quantity'); ?>
						<?php echo $form->error($model,'quantity'); ?>
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