<?php
/* @var $this AssetPurchaseController */
/* @var $model AssetPurchase */

$this->breadcrumbs=array(
	'Asset Purchases'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AssetPurchase', 'url'=>array('admin')),
	array('label'=>'Manage AssetPurchase', 'url'=>array('admin')),
);
?>

<h1>Create Asset Purchase</h1>

<?php $this->renderPartial('_formPurchase', array('model'=>$model)); ?>