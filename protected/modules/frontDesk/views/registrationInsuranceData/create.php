<?php
/* @var $this RegistrationInsuranceDataController */
/* @var $model RegistrationInsuranceData */

$this->breadcrumbs=array(
	'Registration Insurance Datas'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List RegistrationInsuranceData', 'url'=>array('index')),
	array('label'=>'Manage RegistrationInsuranceData', 'url'=>array('admin')),
);
?>

<h1>Create RegistrationInsuranceData</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>