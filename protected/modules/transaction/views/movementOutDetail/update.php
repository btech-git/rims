<?php
/* @var $this MovementOutDetailController */
/* @var $model MovementOutDetail */

$this->breadcrumbs=array(
	'Movement Out Details'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

/*$this->menu=array(
	array('label'=>'List MovementOutDetail', 'url'=>array('index')),
	array('label'=>'Create MovementOutDetail', 'url'=>array('create')),
	array('label'=>'View MovementOutDetail', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage MovementOutDetail', 'url'=>array('admin')),
);*/
?>

<!--<h1>Update MovementOutDetail <?php echo $model->id; ?></h1>-->

<div id="maincontent">
	<?php $this->renderPartial('_form', array('model'=>$model)); ?></div>