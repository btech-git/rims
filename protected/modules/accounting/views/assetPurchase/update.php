<?php
/* @var $this AssetPurchaseController */
/* @var $model AssetPurchase */

$this->breadcrumbs=array(
	'Asset Purchases'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AssetPurchase', 'url'=>array('index')),
	array('label'=>'Create AssetPurchase', 'url'=>array('create')),
	array('label'=>'View AssetPurchase', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage AssetPurchase', 'url'=>array('admin')),
);
?>

<h1>Update Asset Purchase <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>