<?php
/* @var $this AssetSaleController */
/* @var $model AssetSale */

$this->breadcrumbs=array(
	'Asset Sales'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AssetSale', 'url'=>array('index')),
	array('label'=>'Manage AssetSale', 'url'=>array('admin')),
);
?>

<h1>Create Asset Sale</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>