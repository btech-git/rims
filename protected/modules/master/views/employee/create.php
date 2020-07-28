<?php
/* @var $this EmployeeController */
/* @var $model Employee */

$this->breadcrumbs=array(
	'Company',
	'Employees'=>array('admin'),
	'Create Employee',
);

$this->menu=array(
	array('label'=>'List Employee', 'url'=>array('index')),
	array('label'=>'Manage Employee', 'url'=>array('admin')),
);
?>



		<div id="maincontent">

			<?php $this->renderPartial('_form', array('employee'=>$employee,'bank'=>$bank,
			'bankDataProvider'=>$bankDataProvider,
			'incentive'=>$incentive,
			'incentiveDataProvider'=>$incentiveDataProvider,
			'deduction'=>$deduction,
			'deductionDataProvider'=>$deductionDataProvider,
			'branch'=>$branch,
			'branchDataProvider'=>$branchDataProvider,
			)); ?>
		</div>