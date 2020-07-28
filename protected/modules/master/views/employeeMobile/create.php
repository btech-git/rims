<?php
/* @var $this EmployeeMobileController */
/* @var $model EmployeeMobile */

$this->breadcrumbs=array(
	'Company',
	'Employee Mobiles'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List EmployeeMobile', 'url'=>array('index')),
	array('label'=>'Manage EmployeeMobile', 'url'=>array('admin')),
);
?>
<div id="maincontent">
	<?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
