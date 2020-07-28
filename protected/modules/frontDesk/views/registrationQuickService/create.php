<?php
/* @var $this RegistrationQuickServiceController */
/* @var $model RegistrationQuickService */

$this->breadcrumbs=array(
	'Registration Quick Services'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List RegistrationQuickService', 'url'=>array('index')),
	array('label'=>'Manage RegistrationQuickService', 'url'=>array('admin')),
);
?>

<h1>Create RegistrationQuickService</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>