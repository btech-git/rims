<?php
/* @var $this AssetCategoryController */
/* @var $model AssetCategory */

$this->breadcrumbs=array(
	'Asset Categories'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AssetCategory', 'url'=>array('index')),
	array('label'=>'Create AssetCategory', 'url'=>array('create')),
	array('label'=>'View AssetCategory', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage AssetCategory', 'url'=>array('admin')),
);
?>

<h1>Update Asset Category <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>