<?php
/* @var $this CustomerServiceRateController */
/* @var $model CustomerServiceRate */

$this->breadcrumbs=array(
	'Customer Service Rates'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CustomerServiceRate', 'url'=>array('index')),
	array('label'=>'Manage CustomerServiceRate', 'url'=>array('admin')),
);
?>
		<div id="maincontent">

			<?php $this->renderPartial('_form', array('model'=>$model)); ?>
		</div>