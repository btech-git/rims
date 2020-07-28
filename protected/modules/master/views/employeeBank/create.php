<?php
/* @var $this EmployeeBankController */
/* @var $model EmployeeBank */

$this->breadcrumbs=array(
	'Company',
	'Employee Banks'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List EmployeeBank', 'url'=>array('index')),
	array('label'=>'Manage EmployeeBank', 'url'=>array('admin')),
);
?>
<div id="maincontent">
	<?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>