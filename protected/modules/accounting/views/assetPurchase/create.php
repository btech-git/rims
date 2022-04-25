<?php
/* @var $this AssetPurchaseController */
/* @var $model AssetPurchase */

$this->breadcrumbs=array(
	'Asset Purchases'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AssetPurchase', 'url'=>array('index')),
	array('label'=>'Manage AssetPurchase', 'url'=>array('admin')),
);
?>

<h1>Create AssetPurchase</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>