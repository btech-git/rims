<?php
/* @var $this EmployeeDayoffController */
/* @var $model EmployeeDayoff */

$this->breadcrumbs=array(
	'Employee Dayoffs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

/*$this->menu=array(
	array('label'=>'List EmployeeDayoff', 'url'=>array('index')),
	array('label'=>'Create EmployeeDayoff', 'url'=>array('create')),
	array('label'=>'View EmployeeDayoff', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage EmployeeDayoff', 'url'=>array('admin')),
);*/
?>

<h1>Update Pengajuan Cuti Karyawan <?php echo $model->id; ?></h1>

<div id="maincontent">
    <?php $this->renderPartial('_form', array(
        'model'=>$model,
        'employee'=>$employee,
        'employeeDataProvider'=>$employeeDataProvider,
    )); ?>
</div>