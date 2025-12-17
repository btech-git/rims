<?php
/* @var $this OilSaeController */
/* @var $model OilSae */

$this->breadcrumbs=array(
	'Oil Saes'=>array('index'),
	$model->sae=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List OilSae', 'url'=>array('index')),
	array('label'=>'Create OilSae', 'url'=>array('create')),
	array('label'=>'View OilSae', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage OilSae', 'url'=>array('admin')),
);
?>

<h1>Update Oil Specifications <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>