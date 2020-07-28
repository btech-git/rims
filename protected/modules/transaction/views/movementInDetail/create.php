<?php
/* @var $this MovementInDetailController */
/* @var $model MovementInDetail */

$this->breadcrumbs=array(
	'Movement In Details'=>array('admin'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List MovementInDetail', 'url'=>array('index')),
	array('label'=>'Manage MovementInDetail', 'url'=>array('admin')),
);*/
?>

<!--<h1>Create MovementInDetail</h1>-->

<div id="maincontent">
	<?php $this->renderPartial('_form', array('model'=>$model)); ?></div>