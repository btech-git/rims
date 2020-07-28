<?php
/* @var $this RegistrationProductController */
/* @var $model RegistrationProduct */

$this->breadcrumbs=array(
	'Registration Products'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List RegistrationProduct', 'url'=>array('index')),
	array('label'=>'Create RegistrationProduct', 'url'=>array('create')),
	array('label'=>'View RegistrationProduct', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage RegistrationProduct', 'url'=>array('admin')),
);
?>

<h1>Update RegistrationProduct <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>