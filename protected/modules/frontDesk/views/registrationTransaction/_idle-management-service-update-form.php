<?php
/* @var $this VehicleInspectionController */
/* @var $model VehicleInspection */
/* @var $form CActiveForm */
?>

<style>
	.grid-view table.items tr.gone td
	{
	    text-decoration: line-through;    
	}
</style>

<div class="clearfix page-action">
<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/frontDesk/registrationTransaction/idleManagementServices?registrationId='.$registrationService->header->registration_transaction_id;?>"><span class="fa fa-th-list"></span>Manage Service Progress</a>
<h1><?php if($registrationService->header->isNewRecord){ echo "New Registration Service"; }else{ echo "Update Registration Service";}?></h1>
	
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

	<?php echo $form->errorSummary($registrationService->header); ?>

	<div class="row">
		<div class="small-12 medium-6 columns">

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($registrationService->header->registrationTransaction->vehicle,'plate_number'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $registrationService->header->registrationTransaction->vehicle->plate_number; ?>
						<?php //echo $form->error($registrationService,'id'); ?>
					</div>
				</div>			
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($registrationService->header->registrationTransaction,'work_order_number'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $registrationService->header->registrationTransaction->work_order_number; ?>
						<?php //echo $form->error($registrationService,'id'); ?>
					</div>
				</div>			
			</div>

			<!-- <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php //echo $form->labelEx($registrationService->header,'supervisor_id'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php //echo $registrationService->service->status; ?>
						<?php //echo $form->textField($registrationService,'status',array('size'=>30,'maxlength'=>30)); ?>
						<?php //echo $form->dropDownList($registrationService->header,'supervisor_id',CHtml::listData(Employee::model()->findAllByAttributes(array()),'id', 'name')); ?>
						<?php //echo $form->error($registrationService->header,'supervisor_id'); ?>
					</div>
				</div>			
			</div> -->

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($registrationService->header,'start'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php //echo $registrationService->start; ?>
						<?php 
							Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
							$this->widget('CJuiDateTimePicker',array(
						        'model'=>$registrationService->header, //Model object
						        'attribute'=>'start', //attribute name
						                'mode'=>'datetime', //use "time","date" or "datetime" (default)
						        'options' => array(
									'dateFormat' => 'yy-mm-dd',
									'timeFormat' => 'hh:mm:ss',
									'showSecond' => true,
								), // jquery plugin options
						    ));
						?>
						<?php echo $form->error($registrationService->header,'start'); ?>
					</div>
				</div>			
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($registrationService->header,'start_mechanic_id'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php //echo $registrationService->service->status; ?>
						<?php //echo $form->textField($registrationService,'status',array('size'=>30,'maxlength'=>30)); ?>
						<?php echo $form->dropDownList($registrationService->header,'start_mechanic_id',CHtml::listData(Employee::model()->findAllByAttributes(array()),'id', 'name')); ?>
						<?php echo $form->error($registrationService->header,'start_mechanic_id'); ?>
					</div>
				</div>			
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($registrationService->header,'pause'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php //echo $registrationService->start; ?>
						<?php 
							Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
							$this->widget('CJuiDateTimePicker',array(
						        'model'=>$registrationService->header, //Model object
						        'attribute'=>'pause', //attribute name
						                'mode'=>'datetime', //use "time","date" or "datetime" (default)
						        'options' => array(
									'dateFormat' => 'yy-mm-dd',
									'timeFormat' => 'hh:mm:ss',
									'showSecond' => true,
								), // jquery plugin options
						    ));
						?>
						<?php echo $form->error($registrationService->header,'pause'); ?>
					</div>
				</div>			
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($registrationService->header,'pause_mechanic_id'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php //echo $registrationService->service->status; ?>
						<?php //echo $form->textField($registrationService,'status',array('size'=>30,'maxlength'=>30)); ?>
						<?php echo $form->dropDownList($registrationService->header,'pause_mechanic_id',CHtml::listData(Employee::model()->findAllByAttributes(array()),'id', 'name')); ?>
						<?php echo $form->error($registrationService->header,'pause_mechanic_id'); ?>
					</div>
				</div>			
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($registrationService->header,'resume'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php //echo $registrationService->start; ?>
						<?php 
							Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
							$this->widget('CJuiDateTimePicker',array(
						        'model'=>$registrationService->header, //Model object
						        'attribute'=>'resume', //attribute name
						        'mode'=>'datetime', //use "time","date" or "datetime" (default)
						        'options' => array(
									'dateFormat' => 'yy-mm-dd',
									'timeFormat' => 'hh:mm:ss',
									'showSecond' => true,
								), // jquery plugin options
						    ));
						?>
						<?php echo $form->error($registrationService->header,'resume'); ?>
					</div>
				</div>			
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($registrationService->header,'resume_mechanic_id'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php //echo $registrationService->service->status; ?>
						<?php //echo $form->textField($registrationService,'status',array('size'=>30,'maxlength'=>30)); ?>
						<?php echo $form->dropDownList($registrationService->header,'resume_mechanic_id',CHtml::listData(Employee::model()->findAllByAttributes(array()),'id', 'name')); ?>
						<?php echo $form->error($registrationService->header,'start_mechanic_id'); ?>
					</div>
				</div>			
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($registrationService->header,'end'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php //echo $registrationService->end; ?>
						<?php 
							Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
							$this->widget('CJuiDateTimePicker',array(
						        'model'=>$registrationService->header, //Model object
						        'attribute'=>'end', //attribute name
						                'mode'=>'datetime', //use "time","date" or "datetime" (default)
						        'options' => array(
									'dateFormat' => 'yy-mm-dd',
									'timeFormat' => 'hh:mm:ss',
									'showSecond' => true,
								), // jquery plugin options
						    ));
						?>
						<?php echo $form->error($registrationService->header,'end'); ?>
					</div>
				</div>			
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($registrationService->header,'finish_mechanic_id'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php //echo $registrationService->service->status; ?>
						<?php //echo $form->textField($registrationService,'status',array('size'=>30,'maxlength'=>30)); ?>
						<?php echo $form->dropDownList($registrationService->header,'finish_mechanic_id',CHtml::listData(Employee::model()->findAllByAttributes(array()),'id', 'name')); ?>
						<?php echo $form->error($registrationService->header,'finish_mechanic_id'); ?>
					</div>
				</div>			
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($registrationService->header->service,'Service Name'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $registrationService->header->service->name; ?>
						<?php //echo $form->error($registrationService,'id'); ?>
					</div>
				</div>			
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($registrationService->header->service->serviceCategory,'Category Name'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $registrationService->header->service->serviceCategory->name; ?>
						<?php //echo $form->error($registrationService,'id'); ?>
					</div>
				</div>			
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($registrationService->header,'note'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textArea($registrationService->header,'note'); ?>
						<?php //echo $form->error($registrationService,'id'); ?>
					</div>
				</div>			
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($registrationService->header,'Service Status'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php //echo $registrationService->service->status; ?>
						<?php //echo $form->textField($registrationService,'status',array('size'=>30,'maxlength'=>30)); ?>
						<?php echo $form->dropDownList($registrationService->header,'status',array('Pending'=>'Pending','Available'=>'Available','On Progress'=>'On Progress','Finished'=>'Finished')); ?>
						<?php echo $form->error($registrationService->header,'status'); ?>
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
								<?php foreach ($registrationService->header->service->serviceMaterials as $i => $serviceMaterial): ?>
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
			<div>
				<?php echo CHtml::button('Add Employee', array(
					'id' => 'employee-button',
					'name' => 'Detail',
					'class'=>'button extra right',
					'onclick' => '
						jQuery("#employee-dialog").dialog("open"); return false;',

					)
				); ?>
				<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
					'id' => 'employee-dialog',
					// additional javascript options for the dialog plugin
					'options' => array(
						'title' => 'Employee',
						'autoOpen' => false,
						'width' => 'auto',
						'modal' => true,
					),));
				?>

				<?php $this->widget('zii.widgets.grid.CGridView', array(
					'id'=>'employee-grid',
					'dataProvider'=>$employeeDataProvider,
					'filter'=>$employee,
					//'summaryText'=>'',
					'rowHtmlOptionsExpression'=>'array("rel"=>"$data->availability")',
					'selectionChanged'=>'js:function(id){
						$("#employee-grid").find("tr.selected").each(function(){
			                if($(this).attr("rel") == "Yes"){
			                	$.ajax({
									type: "POST",
									//dataType: "JSON",
									url: "' . CController::createUrl('ajaxHtmlAddEmployeeDetail', array('id'=>$registrationService->header->id,'employeeId'=>'')). '"+$.fn.yiiGridView.getSelection(id),
									data: $("form").serialize(),
									success: function(html) {
										jQuery("#employee").html(html);
									},
								});

								$("#employee-grid").find("tr.selected").each(function(){
				                  	$(this).removeClass( "selected" );
				                });
							} else {
								alert("Employee is not available");
							}
			            });
						
					}',
					'columns'=>array(
						'name',
						'availability',
						'skills',
						array('header'=>'Work Order Number', 'value'=>'$data->registration_service_id == NULL ? NULL : $data->registrationService->registrationTransaction->work_order_number'),
						array('header'=>'Plate Number', 'value'=>'$data->registration_service_id == NULL ? NULL : $data->registrationService->registrationTransaction->vehicle->plate_number'),
						array('name'=>'branch_id', 'value'=>'$data->branch_id != 0 ? $data->branch->name : NULL')
					),
				));?>
				<?php $this->endWidget(); ?>

				<h2>Employee</h2>
				<div class="grid-view" id="employee" >
					<?php $this->renderPartial('_idle-management-update-detail-employee', array('registrationService'=>$registrationService)); ?>
					<div class="clearfix"></div><div style="display:none" class="keys"></div>
				</div>
			</div>

			<div>
				<?php echo CHtml::button('Add Supervisor', array(
					'id' => 'supervisor-button',
					'name' => 'Detail',
					'class'=>'button extra right',
					'onclick' => '
						jQuery("#supervisor-dialog").dialog("open"); return false;',

					)
				); ?>
				<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
					'id' => 'supervisor-dialog',
					// additional javascript options for the dialog plugin
					'options' => array(
						'title' => 'Supervisor',
						'autoOpen' => false,
						'width' => 'auto',
						'modal' => true,
					),));
				?>

				<?php $this->widget('zii.widgets.grid.CGridView', array(
					'id'=>'supervisor-grid',
					'dataProvider'=>$employeeDataProvider,
					'filter'=>$employee,
					//'summaryText'=>'',
					'selectionChanged'=>'js:function(id){
						
						$.ajax({
							type: "POST",
							//dataType: "JSON",
							url: "' . CController::createUrl('ajaxHtmlAddSupervisorDetail', array('id'=>$registrationService->header->id,'supervisorId'=>'')). '"+$.fn.yiiGridView.getSelection(id),
							data: $("form").serialize(),
							success: function(html) {
								jQuery("#supervisor").html(html);
							},
						});

						$("#supervisor-grid").find("tr.selected").each(function(){
		                  	$(this).removeClass( "selected" );
		                });
					}',
					'columns'=>array(
						'name',
						//'availability',
						//'skills'
					),
				));?>
				<?php $this->endWidget(); ?>

				<h2>Supervisor</h2>
				<div class="grid-view" id="supervisor" >
					<?php $this->renderPartial('_idle-management-update-detail-supervisor', array('registrationService'=>$registrationService)); ?>
					<div class="clearfix"></div><div style="display:none" class="keys"></div>
				</div>
			</div>

		</div>
	</div>
	<div class="field buttons text-center">
		  <?php echo CHtml::submitButton($registrationService->header->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->