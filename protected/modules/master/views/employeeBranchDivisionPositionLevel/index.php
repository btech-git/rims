<?php
/* @var $this EmployeeBranchDivisionPositionLevelController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Employee Branch Division Position Levels',
);

$this->menu=array(
	array('label'=>'Create EmployeeBranchDivisionPositionLevel', 'url'=>array('create')),
	array('label'=>'Manage EmployeeBranchDivisionPositionLevel', 'url'=>array('admin')),
);
?>

<h1>Employee Branch Division Position Levels</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
