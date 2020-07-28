<?php
/* @var $this EmployeeMobileController */
/* @var $model EmployeeMobile */

$this->breadcrumbs=array(
	'Company',
	'Employee Mobiles'=>array('admin'),
//	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List EmployeeMobile', 'url'=>array('index')),
	array('label'=>'Create EmployeeMobile', 'url'=>array('create')),
	array('label'=>'View EmployeeMobile', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage EmployeeMobile', 'url'=>array('admin')),
);
?>
		<div id="maincontent">
			<?php $this->renderPartial('_form', array('model'=>$model)); ?>
		</div>