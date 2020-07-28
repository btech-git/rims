<?php
/* @var $this CoaCategoryController */
/* @var $model CoaCategory */

$this->breadcrumbs=array(
	'Coa Categories'=>array('admin'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

/*$this->menu=array(
	array('label'=>'List CoaCategory', 'url'=>array('index')),
	array('label'=>'Create CoaCategory', 'url'=>array('create')),
	array('label'=>'View CoaCategory', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CoaCategory', 'url'=>array('admin')),
);*/
?>

<!--<h1>Update CoaCategory <?php echo $model->id; ?></h1>-->

<div id="maincontent">
	<?php $this->renderPartial('_form', array('model'=>$model)); ?></div>