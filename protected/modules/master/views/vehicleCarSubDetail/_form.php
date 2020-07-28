<?php
/* @var $this VehicleCarSubDetailController */
/* @var $model VehicleCarSubDetail */
/* @var $form CActiveForm */
?>
<div class="clearfix page-action">
<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/vehicleCarSubDetail/admin';?>"><span class="fa fa-th-list"></span>Manage Vehicle Car Sub Detail</a>
<h1><?php if($model->isNewRecord){ echo "New Vehicle Car Sub Detail"; }else{ echo "Update Vehicle Car Sub Detail";}?></h1>
<!-- begin FORM -->
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'vehicle-car-sub-detail-form',
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
					  <label class="prefix"><?php echo $form->labelEx($model,'car_make_id'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php //echo $form->dropDownList($model,'car_make_id', CHtml::listData(VehicleCarMake::model()->findAll(),'id','name'),  array('prompt' => 'Select',)); ?>
						<?php echo $form->dropDownList($model,'car_make_id', CHtml::listData(VehicleCarMake::model()->findAll(),'id','name'),array(
									'prompt' => '[--Select Car Make--]',
				    			'onchange'=> 'jQuery.ajax({
									type: "POST",
									//dataType: "JSON",
									url: "' . CController::createUrl('ajaxGetModel',array()) . '/carmake/" + jQuery(this).val(),
									data: jQuery("form").serialize(),
									success: function(data){
			                        	console.log(data);
			                        	jQuery("#VehicleCarSubDetail_car_model_id").html(data);
		                        	},
								});'
					)); ?>
						<?php echo $form->error($model,'car_make_id'); ?>
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
					  <label class="prefix"><?php echo $form->labelEx($model,'car_model_id'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->dropDownList($model,'car_model_id', CHtml::listData(VehicleCarModel::model()->findAll(),'id','name'),  array('prompt' => '[--Select Car Model--]',)); ?>
						<?php echo $form->error($model,'car_model_id'); ?>
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
					  <label class="prefix"><?php echo $form->labelEx($model,'name'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'name',array('size'=>10,'maxlength'=>10)); ?>
						<?php echo $form->error($model,'name'); ?>
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
					  <label class="prefix"><?php echo $form->labelEx($model,'assembly_year_start'); ?></label>
					</div>
					<div class="small-8 columns">
					<?php $range = range(date('Y'),1950); ?>
					<?php echo CHtml::activeDropDownList($model,'assembly_year_start',array_combine($range, $range),array('prompt'=>'[--Select Year--]')); ?>
						
						<?php echo $form->error($model,'assembly_year_start'); ?>
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
					  <label class="prefix"><?php echo $form->labelEx($model,'transmission'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo  $form->dropDownList($model, 'transmission', array('Manual' => 'Manual',
									'Automatic' => 'Automatic','Sports' => 'Sports','Other' => 'Other',), array('prompt' => '[--Select Transmission--]',)); ?>
						<?php echo $form->error($model,'transmission'); ?>
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
					  <label class="prefix"><?php echo $form->labelEx($model,'fuel_type'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo  $form->dropDownList($model, 'fuel_type', array('Diesel' => 'Diesel',
									'Electric' => 'Electric','Gas' => 'Gas','Gasoline' => 'Gasoline', 'Hybrid' => 'Hybrid',), array('prompt' => '[--Select Fuel--]',)); ?>
						<?php echo $form->error($model,'fuel_type'); ?>
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
					  <label class="prefix"><?php echo $form->labelEx($model,'power'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php 
						$array = range(1000,8000,100);

						
						 ?>
						<?php //echo CHtml::activeDropDownList($vehicleDetail,"[$i]power_cc",array($array)); ?>
						<?php echo $form->dropDownList($model,'power', array_combine($array, $array),array('prompt'=>'[--Select Power CC--]')); ?>
						<?php echo $form->error($model,'power'); ?>
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
					  <label class="prefix"><?php echo $form->labelEx($model,'drivetrain'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->dropDownList($model,'drivetrain', array('4WD' => '4WD', '2WD' => '2WD','AWD'=>'AWD'),array('prompt'=>'[--Select DriveTrain--]')); ?>
						<?php echo $form->error($model,'drivetrain'); ?>
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
					  <label class="prefix"><?php echo $form->labelEx($model,'chasis_code'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($model,'chasis_code'); ?>
						<?php echo $form->error($model,'chasis_code'); ?>
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
					  <label class="prefix"><?php echo $form->labelEx($model,'description'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textArea($model,'description',array('rows'=>6,'columns'=>50)); ?>
						<?php echo $form->error($model,'description'); ?>
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
						<label class="prefix"><?php echo $form->label($model,'luxury_value'); ?></label>
					</div>
					<div class="small-8 columns">
		
						<?php echo CHtml::activeTextField($model,'luxury_value',array('size'=>8,'maxlength'=>8)); ?>
						
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

</div><!-- form -->
</div>	