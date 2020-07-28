<?php
/* @var $this CoaSubCategoryController */
/* @var $model CoaSubCategory */

$this->breadcrumbs=array(
	'Coa Sub Categories'=>array('admin'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List CoaSubCategory', 'url'=>array('index')),
	array('label'=>'Manage CoaSubCategory', 'url'=>array('admin')),
);*/
?>

<!--<h1>Create CoaSubCategory</h1>-->

<div id="maincontent">
	<?php $this->renderPartial('_form', array('model'=>$model)); ?></div>