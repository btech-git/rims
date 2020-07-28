<?php
/* @var $this RegistrationQuickServiceController */
/* @var $model RegistrationQuickService */

$this->breadcrumbs=array(
	'Registration Quick Services'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List RegistrationQuickService', 'url'=>array('index')),
	array('label'=>'Create RegistrationQuickService', 'url'=>array('create')),
	array('label'=>'View RegistrationQuickService', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage RegistrationQuickService', 'url'=>array('admin')),
);
?>

<h1>Update RegistrationQuickService <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>