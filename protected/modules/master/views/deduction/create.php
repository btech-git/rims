<?php
/* @var $this IncentiveController */
/* @var $model IncentiveIncentive */

$this->breadcrumbs=array(
	'Company',	
	'Deductions'=>array('admin'),
	'Create',
);
/*
$this->menu=array(
	array('label'=>'List Incentive', 'url'=>array('index')),
	array('label'=>'Manage Incentive', 'url'=>array('admin')),
);*/
?>
	


		<div id="maincontent">

			<?php $this->renderPartial('_form', array('model'=>$model)); ?>
		</div>