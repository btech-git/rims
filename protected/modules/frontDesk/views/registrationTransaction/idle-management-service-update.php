<?php
/* @var $this RegistrationTransactionController */
/* @var $registrationTransaction->header RegistrationTransaction */

$this->breadcrumbs=array(
	'Registration Services'=>array('idleManagementServices', 'registrationId'=>$registrationService->header->registration_transaction_id),
	$registrationService->header->id=>array('idleManagementServiceView','registrationServiceId'=>$registrationService->header->id,'serviceId'=>$registrationService->header->service_id,'registrationId'=>$registrationService->header->registration_transaction_id),
	'Update',
);

/*$this->menu=array(
	array('label'=>'List RegistrationTransaction', 'url'=>array('index')),
	array('label'=>'Create RegistrationTransaction', 'url'=>array('create')),
	array('label'=>'View RegistrationTransaction', 'url'=>array('view', 'id'=>$registrationService->id)),
	array('label'=>'Manage RegistrationTransaction', 'url'=>array('admin')),
);*/
?>
<div class="row">
	<div class="small-2 columns">
		<?php include Yii::app()->basePath . '/../css/navsettings.php'; ?>
	</div>
	<div class="small-10 columns">
		<div id="maincontent">
			<?php echo $this->renderPartial('_idle-management-service-update-form', array(
				'registrationService'=>$registrationService,
				'employee'=>$employee,
				'employeeDataProvider'=>$employeeDataProvider,
			)); ?>
		</div>
	</div>
</div>