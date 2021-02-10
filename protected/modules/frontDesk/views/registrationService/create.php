<?php
/* @var $this RegistrationServiceController */
/* @var $model RegistrationService */

$this->breadcrumbs=array(
	'Registration Services'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List RegistrationService', 'url'=>array('index')),
	array('label'=>'Manage RegistrationService', 'url'=>array('admin')),
);
?>

<h1>Create RegistrationService</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>