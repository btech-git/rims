<?php
/* @var $this IncentiveController */
/* @var $model Incentive */

$this->breadcrumbs=array(
	'Company',	
	'Deductions'=>array('admin'),
	//$model->name=>array('view','id'=>$model->id),
	'Update Deduction',
);
/*
$this->menu=array(
	array('label'=>'List Incentive', 'url'=>array('index')),
	array('label'=>'Create Incentive', 'url'=>array('create')),
	array('label'=>'View Incentive', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Incentive', 'url'=>array('admin')),
);*/
?>
	


		<div id="maincontent">

			<?php $this->renderPartial('_form', array('model'=>$model)); ?>
		</div>