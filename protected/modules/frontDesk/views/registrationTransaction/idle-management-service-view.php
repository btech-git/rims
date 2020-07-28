<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

$this->breadcrumbs=array(
	'Services Progress'=>array('idleManagementServices', 'registrationId'=>$registrationService->registration_transaction_id),
	$registrationService->id,
);

$this->menu=array(
	array('label'=>'List RegistrationTransaction', 'url'=>array('index')),
	array('label'=>'Create RegistrationTransaction', 'url'=>array('create')),
	array('label'=>'Update RegistrationTransaction', 'url'=>array('update', 'id'=>$registrationService->id)),
	array('label'=>'Delete RegistrationTransaction', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$registrationService->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage RegistrationTransaction', 'url'=>array('admin')),
);
?>



	<div class="small-12 columns">
		
		<div id="maincontent">
			<div class="clearfix page-action">
				<?php $ccontroller = Yii::app()->controller->id; ?>
				<?php $ccaction = Yii::app()->controller->action->id; ?>
				<div class="row">
					<div class="small-8 columns">
						
						<a class="button cbutton left" style="margin-right:10px;" href="<?php echo Yii::app()->baseUrl.'/frontDesk/RegistrationTransaction/idleManagementServices?registrationId='.$registrationService->registration_transaction_id;?>"><span class="fa fa-th-list"></span>Manage Service Progress</a>
					
						<a class="button cbutton left" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/frontDesk/'.$ccontroller.'/idleManagementServiceUpdate',array('registrationServiceId'=>$registrationService->id,'serviceId'=>$registrationService->service_id,'registrationId'=>$registrationService->registration_transaction_id));?>"><span class="fa fa-edit"></span>Edit</a>	
					</div>
					
				</div>
					
				<h1>View Registration Transaction Service #<?php echo $registrationService->id; ?></h1>

				<?php $this->widget('zii.widgets.CDetailView', array(
					'data'=>$registrationService,
					'attributes'=>array(
						//'id',
						array('name'=>'plate_number', 'value'=>$registrationService->registrationTransaction->vehicle->plate_number),
						array('name'=>'work_order_number', 'value'=>$registrationService->registrationTransaction->work_order_number),
						//array('name'=>'employee_name', 'value'=>$registrationService->employee->name),
						array('name'=>'Start', 'value'=>$registrationService->start),
						array('name'=>'start_mechanic_id', 'value'=>$registrationService->start_mechanic_id),
						/*array('name'=>'start_mechanic_id', 'value'=>$registrationService->start_mechanic_id != NULL ? Employee::model()->findByPk($registrationService->start_mechanic_id)->name : NULL),*/
						array('name'=>'End', 'value'=>$registrationService->end),
						array('name'=>'finish_mechanic_id', 'value'=>$registrationService->finish_mechanic_id ),
						/*array('name'=>'finish_mechanic_id', 'value'=>$registrationService->finish_mechanic_id != NULL ? Employee::model()->findByPk($registrationService->finish_mechanic_id)->name : NULL),*/
						array('name'=>'Service Name', 'value'=>$registrationService->service->name),
						array('name'=>'Service Category Name', 'value'=>$registrationService->service->serviceCategory->name),
						array('name'=>'Status', 'value'=>$registrationService->status),
					),
				)); ?>
					
			</div>
		</div>
	</div>
		
		
	
