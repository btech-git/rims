<?php
/* @var $this EmployeeBranchDivisionPositionLevelController */
/* @var $model EmployeeBranchDivisionPositionLevel */

$this->breadcrumbs=array(
	'Employee Branch Division Position Levels'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List EmployeeBranchDivisionPositionLevel', 'url'=>array('index')),
	array('label'=>'Create EmployeeBranchDivisionPositionLevel', 'url'=>array('create')),
	array('label'=>'View EmployeeBranchDivisionPositionLevel', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage EmployeeBranchDivisionPositionLevel', 'url'=>array('admin')),
);
?>

<h1>Update EmployeeBranchDivisionPositionLevel <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>