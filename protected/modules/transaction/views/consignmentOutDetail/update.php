<?php
/* @var $this ConsignmentOutDetailController */
/* @var $model ConsignmentOutDetail */

$this->breadcrumbs=array(
	'Consignment Out Details'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

/*$this->menu=array(
	array('label'=>'List ConsignmentOutDetail', 'url'=>array('index')),
	array('label'=>'Create ConsignmentOutDetail', 'url'=>array('create')),
	array('label'=>'View ConsignmentOutDetail', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ConsignmentOutDetail', 'url'=>array('admin')),
);*/
?>

<!--<h1>Update ConsignmentOutDetail <?php echo $model->id; ?></h1>-->

<div id="maincontent">
	<?php $this->renderPartial('_form', array('model'=>$model)); ?></div>