<?php
/* @var $this CoaSubCategoryController */
/* @var $model CoaSubCategory */

$this->breadcrumbs=array(
	'Coa Sub Categories'=>array('admin'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

/*$this->menu=array(
	array('label'=>'List CoaSubCategory', 'url'=>array('index')),
	array('label'=>'Create CoaSubCategory', 'url'=>array('create')),
	array('label'=>'View CoaSubCategory', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CoaSubCategory', 'url'=>array('admin')),
);*/
?>

<!--<h1>Update CoaSubCategory <?php echo $model->id; ?></h1>-->

<div id="maincontent">
	<?php $this->renderPartial('_form', array('model'=>$model)); ?></div>