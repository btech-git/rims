<?php
/* @var $this ChasisCodeController */
/* @var $model ChasisCode */
/* @var $form CActiveForm */
?>
<div class="clearfix page-action">
<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/chasisCode/admin';?>"><span class="fa fa-th-list"></span>Manage Chasis Code</a>
<h1><?php if($model->isNewRecord){ echo "New Chassis Code"; }else{ echo "Update Chassis Code";}?></h1>
<!-- begin FORM -->

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'chasis-code-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
	<hr>
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php //echo $form->errorSummary($model); ?>

	<div class="row">
		<div class="small-12 medium-6 columns">			 
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($model,'car_make_id'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->dropDownList($model,'car_make_id', CHtml::listData(VehicleCarMake::model()->findAll(),'id','name'),array(
									'prompt' => '[--Select Car Make--]',
				    			'onchange'=> 'jQuery.ajax({
									type: "POST",
									//dataType: "JSON",
									url: "' . CController::createUrl('ajaxGetModel',array('carmake'=>'')) .'" + jQuery(this).val(),
									data: jQuery("form").serialize(),
									success: function(data){
			                        	console.log(data);
			                        	jQuery("#ChasisCode_car_model_id").html(data);

			                        	
		                        	},
		                        	
								});'
					)); ?>
						<?php echo $form->error($model,'car_make_id'); ?>
					</div>
				</div>
			</div>	

			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($model,'car_model_id'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->dropDownList($model,'car_model_id', CHtml::listData(VehicleCarModel::model()->findAll(),'id','name'),  array('prompt' => '[--Select Car Model--]',)); ?>
						<?php echo $form->error($model,'car_model_id'); ?>
					</div>
				</div>
			 </div>		 

		 	<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($model,'name'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'name',array('size'=>30,'maxlength'=>30)); ?>
						<?php echo $form->error($model,'name'); ?>
					</div>
				</div>
			</div>			 
		
    	<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($model,'year_start'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php $range = range(date('Y'),1950); ?>
						<?php echo CHtml::activeDropDownList($model,'year_start',array_combine($range, $range),array('prompt'=>'[--Select Year Start--]')); ?>
						<?php //echo $form->textField($model,'year_start'); ?>
						<?php echo $form->error($model,'year_start'); ?>
					</div>
				</div>
			</div>			 
		
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($model,'year_end'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo CHtml::activeDropDownList($model,'year_end',array_combine($range, $range),array('prompt'=>'[--Select Year End--]')); ?>
						<?php //echo $form->textField($model,'year_end'); ?>
						<?php echo $form->error($model,'year_end'); ?>
					</div>
				</div>
 			</div>	

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($model,'status'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo  $form->dropDownList($model, 'status', array('Active' => 'Active',
									'Inactive' => 'Inactive', )); ?>
						<?php echo $form->error($model,'status'); ?>
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

</div>
</div>
