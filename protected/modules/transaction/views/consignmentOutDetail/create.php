<?php
/* @var $this ConsignmentOutDetailController */
/* @var $model ConsignmentOutDetail */

$this->breadcrumbs=array(
	'Consignment Out Details'=>array('admin'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List ConsignmentOutDetail', 'url'=>array('index')),
	array('label'=>'Manage ConsignmentOutDetail', 'url'=>array('admin')),
);*/
?>

<!--<h1>Create ConsignmentOutDetail</h1>-->

<div id="maincontent">
	<?php $this->renderPartial('_form', array('model'=>$model)); ?></div>