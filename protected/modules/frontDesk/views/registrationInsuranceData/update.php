<?php
/* @var $this RegistrationInsuranceDataController */
/* @var $model RegistrationInsuranceData */

$this->breadcrumbs=array(
	'Registration Insurance Datas'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List RegistrationInsuranceData', 'url'=>array('index')),
	array('label'=>'Create RegistrationInsuranceData', 'url'=>array('create')),
	array('label'=>'View RegistrationInsuranceData', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage RegistrationInsuranceData', 'url'=>array('admin')),
);
?>

<h1>Update RegistrationInsuranceData <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>