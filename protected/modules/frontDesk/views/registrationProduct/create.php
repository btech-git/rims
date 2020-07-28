<?php
/* @var $this RegistrationProductController */
/* @var $model RegistrationProduct */

$this->breadcrumbs=array(
	'Registration Products'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List RegistrationProduct', 'url'=>array('index')),
	array('label'=>'Manage RegistrationProduct', 'url'=>array('admin')),
);
?>

<h1>Create RegistrationProduct</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>