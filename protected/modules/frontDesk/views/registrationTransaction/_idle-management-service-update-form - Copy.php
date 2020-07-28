<?php
/* @var $this VehicleInspectionController */
/* @var $model VehicleInspection */
/* @var $form CActiveForm */
?>

<div class="clearfix page-action">
<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/frontDesk/registrationTransaction/idleManagementServices?registrationId='.$registrationService->registration_transaction_id;?>"><span class="fa fa-th-list"></span>Manage Registration Services</a>
<h1><?php if($registrationService->isNewRecord){ echo "New Registration Service"; }else{ echo "Update Registration Service";}?></h1>
	
<!-- begin FORM -->
<div class="form">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'registration-service-form',
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation'=>false,
	)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($registrationService); ?>

	<div class="row">
		<div class="small-12 medium-6 columns">

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($registrationService->registrationTransaction->vehicle,'plate_number'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $registrationService->registrationTransaction->vehicle->plate_number; ?>
						<?php //echo $form->error($registrationService,'id'); ?>
					</div>
				</div>			
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($registrationService->registrationTransaction,'work_order_number'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $registrationService->registrationTransaction->work_order_number; ?>
						<?php //echo $form->error($registrationService,'id'); ?>
					</div>
				</div>			
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($registrationService,'employee_id'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php //echo $registrationService->service->status; ?>
						<?php //echo $form->textField($registrationService,'status',array('size'=>30,'maxlength'=>30)); ?>
						<?php echo $form->dropDownList($registrationService,'employee_id',CHtml::listData(Employee::model()->findAllByAttributes(array('availability'=>'Yes')),'id', 'name')); ?>
						<?php echo $form->error($registrationService,'employee_id'); ?>
					</div>
				</div>			
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($registrationService,'supervisor_id'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php //echo $registrationService->service->status; ?>
						<?php //echo $form->textField($registrationService,'status',array('size'=>30,'maxlength'=>30)); ?>
						<?php echo $form->dropDownList($registrationService,'supervisor_id',CHtml::listData(Employee::model()->findAllByAttributes(array('availability'=>'Yes')),'id', 'name')); ?>
						<?php echo $form->error($registrationService,'supervisor_id'); ?>
					</div>
				</div>			
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($registrationService,'start'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php //echo $registrationService->start; ?>
						<?php 
							Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
							$this->widget('CJuiDateTimePicker',array(
						        'model'=>$registrationService, //Model object
						        'attribute'=>'start', //attribute name
						                'mode'=>'datetime', //use "time","date" or "datetime" (default)
						        'options' => array(
									'dateFormat' => 'yy-mm-dd',
									'timeFormat' => 'hh:mm:ss',
									'showSecond' => true,
								), // jquery plugin options
						    ));
						?>
						<?php echo $form->error($registrationService,'start'); ?>
					</div>
				</div>			
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($registrationService,'end'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php //echo $registrationService->end; ?>
						<?php 
							Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
							$this->widget('CJuiDateTimePicker',array(
						        'model'=>$registrationService, //Model object
						        'attribute'=>'end', //attribute name
						                'mode'=>'datetime', //use "time","date" or "datetime" (default)
						        'options' => array(
									'dateFormat' => 'yy-mm-dd',
									'timeFormat' => 'hh:mm:ss',
									'showSecond' => true,
								), // jquery plugin options
						    ));
						?>
						<?php echo $form->error($registrationService,'end'); ?>
					</div>
				</div>			
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($registrationService->service,'name'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $registrationService->service->name; ?>
						<?php //echo $form->error($registrationService,'id'); ?>
					</div>
				</div>			
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($registrationService->service->serviceCategory,'name'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $registrationService->service->serviceCategory->name; ?>
						<?php //echo $form->error($registrationService,'id'); ?>
					</div>
				</div>			
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($registrationService,'status'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php //echo $registrationService->service->status; ?>
						<?php //echo $form->textField($registrationService,'status',array('size'=>30,'maxlength'=>30)); ?>
						<?php echo $form->dropDownList($registrationService,'status',array('Pending'=>'Pending','Available'=>'Available','On Progress'=>'On Progress','Finished'=>'Finished')); ?>
						<?php echo $form->error($registrationService,'status'); ?>
					</div>
				</div>			
			</div>

			<div class="field">
				<div class="row collapse">
					<h3>Material Used</h3>
				</div>
			</div>
			<div id="material">
				<div class="field">
					<div class="small-12 columns">
						<div class="detail">
						<table>
							<thead>
								<tr>
									<th>Product</th>
									<th>Easy</th>
									<th>Medium</th>
									<th>Hard</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($registrationService->service->serviceMaterials as $i => $serviceMaterial): ?>
									<tr>
										<td><?php echo $serviceMaterial->product->name; ?></td>
										<td><?php echo $serviceMaterial->easy; ?></td>
										<td><?php echo $serviceMaterial->medium; ?></td>
										<td><?php echo $serviceMaterial->hard; ?></td>
									</tr>
								<?php endforeach ?>
							</tbody>
						</table>
						</div>
					</div>
				</div>

			</div>

		</div>
	</div>
	<div class="field buttons text-center">
		  <?php echo CHtml::submitButton($registrationService->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->