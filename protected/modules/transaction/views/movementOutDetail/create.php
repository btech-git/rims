<?php
/* @var $this MovementOutDetailController */
/* @var $model MovementOutDetail */

$this->breadcrumbs=array(
	'Movement Out Details'=>array('admin'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List MovementOutDetail', 'url'=>array('index')),
	array('label'=>'Manage MovementOutDetail', 'url'=>array('admin')),
);*/
?>

<!--<h1>Create MovementOutDetail</h1>-->

<div id="maincontent">
	<?php $this->renderPartial('_form', array('model'=>$model)); ?></div>