<?php
/* @var $this EmployeePhoneController */
/* @var $model EmployeePhone */

$this->breadcrumbs=array(
	'Company',
	'Employee Phones'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List EmployeePhone', 'url'=>array('index')),
	array('label'=>'Manage EmployeePhone', 'url'=>array('admin')),
);
?>


		<div id="maincontent">
			<?php $this->renderPartial('_form', array('model'=>$model)); ?>
		</div>