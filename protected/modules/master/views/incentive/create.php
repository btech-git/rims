<?php
/* @var $this IncentiveController */
/* @var $model Incentive */

$this->breadcrumbs=array(
	'Company',
	'Incentives'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Incentive', 'url'=>array('index')),
	array('label'=>'Manage Incentive', 'url'=>array('admin')),
);
?>



		<div id="maincontent">

			<?php $this->renderPartial('_form', array('model'=>$model)); ?>
		</div>