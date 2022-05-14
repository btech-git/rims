<?php
/* @var $this AssetCategoryController */
/* @var $model AssetCategory */

$this->breadcrumbs=array(
	'Asset Categories'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AssetCategory', 'url'=>array('index')),
	array('label'=>'Manage AssetCategory', 'url'=>array('admin')),
);
?>

<h1>Create Asset Category</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>