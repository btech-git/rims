<?php
/* @var $this AssetDepreciationController */
/* @var $model AssetDepreciation */

$this->breadcrumbs=array(
	'Asset Depreciations'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AssetDepreciation', 'url'=>array('index')),
	array('label'=>'Manage AssetDepreciation', 'url'=>array('admin')),
);
?>

<h1>Create Asset Depreciation</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>