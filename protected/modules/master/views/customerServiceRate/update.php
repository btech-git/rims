<?php
/* @var $this CustomerServiceRateController */
/* @var $model CustomerServiceRate */

$this->breadcrumbs=array(
	'Customer Service Rates'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CustomerServiceRate', 'url'=>array('index')),
	array('label'=>'Create CustomerServiceRate', 'url'=>array('create')),
	array('label'=>'View CustomerServiceRate', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CustomerServiceRate', 'url'=>array('admin')),
);
?>

		<div id="maincontent">

			<?php $this->renderPartial('_form', array('model'=>$model)); ?>
		</div>
