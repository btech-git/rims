<?php
/* @var $this EmployeeBranchDivisionPositionLevelController */
/* @var $model EmployeeBranchDivisionPositionLevel */

$this->breadcrumbs=array(
	'Employee Branch Division Position Levels'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List EmployeeBranchDivisionPositionLevel', 'url'=>array('index')),
	array('label'=>'Manage EmployeeBranchDivisionPositionLevel', 'url'=>array('admin')),
);
?>

<h1>Create EmployeeBranchDivisionPositionLevel</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>