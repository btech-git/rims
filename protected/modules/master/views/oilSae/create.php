<?php
/* @var $this OilSaeController */
/* @var $model OilSae */

$this->breadcrumbs=array(
	'Oil Saes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List OilSae', 'url'=>array('index')),
	array('label'=>'Manage OilSae', 'url'=>array('admin')),
);
?>

<h1>Create OilSae</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>