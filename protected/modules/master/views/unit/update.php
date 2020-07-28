<?php
/* @var $this UnitController */
/* @var $model Unit */

$this->breadcrumbs=array(
	'Company',
	'Units'=>array('admin'),
	//$model->name=>array('view','id'=>$model->id),
	'Update Unit',
);

$this->menu=array(
	array('label'=>'List Unit', 'url'=>array('index')),
	array('label'=>'Create Unit', 'url'=>array('create')),
	array('label'=>'View Unit', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Unit', 'url'=>array('admin')),
);
?>



		<div id="maincontent">

			<?php $this->renderPartial('_form', array('model'=>$model)); ?>
		</div>