<?php
/* @var $this CoaController */
/* @var $model Coa */

$this->breadcrumbs=array(
	'Coas'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

/*$this->menu=array(
	array('label'=>'List Coa', 'url'=>array('index')),
	array('label'=>'Create Coa', 'url'=>array('create')),
	array('label'=>'View Coa', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Coa', 'url'=>array('admin')),
);*/
?>

<!--<h1>Update Coa <?php echo $model->id; ?></h1>-->

<div id="maincontent">
	<?php $this->renderPartial('_form', array('model'=>$model)); ?></div>