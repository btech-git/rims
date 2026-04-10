<?php
/* @var $this RegistrationServiceController */
/* @var $model RegistrationService */

$this->breadcrumbs=array(
	'Registration Services'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List RegistrationService', 'url'=>array('index')),
	array('label'=>'Create RegistrationService', 'url'=>array('create')),
	array('label'=>'View RegistrationService', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage RegistrationService', 'url'=>array('admin')),
);
?>

<h1>Update RegistrationService <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>