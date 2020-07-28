<?php
/* @var $this EmployeePhoneController */
/* @var $model EmployeePhone */

$this->breadcrumbs=array(
	'Company',
	'Employee Phones'=>array('admin'),
	//$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List EmployeePhone', 'url'=>array('index')),
	array('label'=>'Create EmployeePhone', 'url'=>array('create')),
	array('label'=>'View EmployeePhone', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage EmployeePhone', 'url'=>array('admin')),
);
?>


		<div id="maincontent">
			<?php $this->renderPartial('_form', array('model'=>$model)); ?>
		</div>