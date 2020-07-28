<?php
/* @var $this VehicleInspectionController */
/* @var $model VehicleInspection */
/* @var $form CActiveForm */
?>

	

<div class="clearfix page-action">
<?php echo CHtml::link('<span class="fa fa-th-list"></span>Manage Vehicle Inspection', Yii::app()->baseUrl.'/frontDesk/vehicleInspection/admin', array('class'=>'button cbutton right', 'visible'=>Yii::app()->user->checkAccess("frontDesk.vehicleInspection.admin"))) ?>
<h1><?php if($vehicleInspection->header->isNewRecord){ echo "New Vehicle Inspection"; }else{ echo "Update Vehicle Inspection";}?></h1>
	
<!-- begin FORM -->
<div class="form">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'vehicle-inspection-form',
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation'=>false,
	)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($vehicleInspection->header); ?>
	<?php echo $form->errorSummary($vehicleInspection->vehicleInspectionDetails); ?>


	<div class="row">
		<div class="small-12 medium-6 columns">
			<?php echo $form->hiddenField($vehicleInspection->header,'vehicle_id',array('readonly'=>true,'value'=>$_GET['vehicleId'])); ?>
			<?php $vehicle = Vehicle::model()->findByPk($_GET['vehicleId']); ?>
			<p><?php echo $vehicle->customer->name . ' | ' . $vehicle->plate_number . ' | ' . $vehicle->frame_number ?></p>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($vehicleInspection->header,'inspection_id'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php //echo $form->textField($vehicleInspection->header,'inspection_id'); ?>
						<?php echo $form->dropDownList($vehicleInspection->header,'inspection_id', CHtml::listData(Inspection::model()->findAllByAttributes(
								array(),array('order'=>'name')),'id','name'),
								array(
									'prompt' => '[--Select Inspection--]',
									'onChange' => 'jQuery.ajax({
										type: "POST",
										url: "' . CController::createUrl('ajaxHtmlAddVehicleInspectionDetail', array('id'=>$vehicleInspection->header->id,)) . '&inspectionId="+jQuery(this).val(),
										data: jQuery("form").serialize(),
										success: function(data){
				                        	console.log(data);
				                        	jQuery("#vehicleReport").html(data);
				                    	},
									});'
								)
							); 
						?>
						<?php echo $form->error($vehicleInspection->header,'inspection_id'); ?>
					</div>
				</div>			
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($vehicleInspection->header,'inspection_date'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php //echo $form->textField($vehicleInspection->header,'inspection_date'); ?>
						<?php
							$this->widget('zii.widgets.jui.CJuiDatePicker',array(
								'model'=>$vehicleInspection->header,
								'attribute'=>'inspection_date',
							    'name'=>'inspection_date',

							    // additional javascript options for the date picker plugin
							    'options'=>array(
							        'showAnim'=>'slide',//'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
							        'dateFormat'=>'yy-mm-dd',
							    )
							));
						?>
						<?php echo $form->error($vehicleInspection->header,'inspection_date'); ?>
					</div>
				</div>			
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($vehicleInspection->header,'work_order_number'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php //echo $form->textField($vehicleInspection->header,'work_order_number',array('size'=>20,'maxlength'=>20)); ?>
						<?php //echo $form->dropDownList($vehicleInspection->header,'work_order_number',CHtml::listData(RegistrationTransaction::model()->findAll(),'work_order_number','work_order_number')); ?>
						<?php echo $form->textField($vehicleInspection->header,'work_order_number',array('readonly'=>true,'value'=>$_GET['wonumber'])); ?>
						<?php echo $form->error($vehicleInspection->header,'work_order_number'); ?>
					</div>
				</div>			
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($vehicleInspection->header,'status'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php //echo $form->textField($vehicleInspection->header,'status',array('size'=>10,'maxlength'=>10)); ?>
						<?php echo $form->dropDownList($vehicleInspection->header,'status',array('Active'=>'Active','Not Active'=>'Not Active')); ?>
						<?php echo $form->error($vehicleInspection->header,'status'); ?>
					</div>
				</div>			
			</div>

		</div>
   	</div>
   	<hr>

   	<h2>Vehicle Report</h2>
	<div class="grid-view" id="vehicleReport" >
		<?php $this->renderPartial('_detailVehicleInspectionDetail', array('vehicleInspection'=>$vehicleInspection)); ?>
		<div class="clearfix"></div><div style="display:none" class="keys"></div>
	</div>

	<div class="row">
		<div class="small-12 medium-6 columns">
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($vehicleInspection->header,'service_advisor_id'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php //echo $form->textField($vehicleInspection->header,'status',array('size'=>10,'maxlength'=>10)); ?>
						<?php echo $form->dropDownList($vehicleInspection->header,'service_advisor_id',CHtml::listData(Employee::model()->findAll(),'id','name')); ?>
						<?php echo $form->error($vehicleInspection->header,'service_advisor_id'); ?>
					</div>
				</div>			
			</div>
		</div>
	</div>

	<div class="field buttons text-center">
		  <?php echo CHtml::submitButton($vehicleInspection->header->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
	</div>


<?php $this->endWidget(); ?>

</div><!-- form -->