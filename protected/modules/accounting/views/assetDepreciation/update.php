<?php
/* @var $this AssetDepreciationController */
/* @var $model AssetDepreciation */

$this->breadcrumbs=array(
	'Asset Depreciations'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AssetDepreciation', 'url'=>array('index')),
	array('label'=>'Create AssetDepreciation', 'url'=>array('create')),
	array('label'=>'View AssetDepreciation', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage AssetDepreciation', 'url'=>array('admin')),
);
?>

<h1>Update Asset Depreciation <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>