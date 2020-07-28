<?php
/* @var $this MovementInDetailController */
/* @var $model MovementInDetail */

$this->breadcrumbs=array(
	'Movement In Details'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

/*$this->menu=array(
	array('label'=>'List MovementInDetail', 'url'=>array('index')),
	array('label'=>'Create MovementInDetail', 'url'=>array('create')),
	array('label'=>'View MovementInDetail', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage MovementInDetail', 'url'=>array('admin')),
);*/
?>

<!--<h1>Update MovementInDetail <?php echo $model->id; ?></h1>-->

<div id="maincontent">
	<?php $this->renderPartial('_form', array('model'=>$model)); ?></div>