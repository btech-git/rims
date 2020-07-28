<?php
/* @var $this EmployeeBankController */
/* @var $model EmployeeBank */

$this->breadcrumbs=array(
	'Company',
	'Employee Banks'=>array('admin'),
	//$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List EmployeeBank', 'url'=>array('index')),
	array('label'=>'Create EmployeeBank', 'url'=>array('create')),
	array('label'=>'View EmployeeBank', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage EmployeeBank', 'url'=>array('admin')),
);
?>


		<div id="maincontent">

			<?php $this->renderPartial('_form', array('model'=>$model)); ?>
		</div>