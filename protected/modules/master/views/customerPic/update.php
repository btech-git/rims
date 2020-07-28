<?php
/* @var $this CustomerPicController */
/* @var $model CustomerPic */

$this->breadcrumbs=array(
	'Customer Pics'=>array('admin'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CustomerPic', 'url'=>array('index')),
	array('label'=>'Create CustomerPic', 'url'=>array('create')),
	array('label'=>'View CustomerPic', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CustomerPic', 'url'=>array('admin')),
);
?>
		<div id="maincontent">

			<?php $this->renderPartial('_form', array('model'=>$model)); ?>
		</div>