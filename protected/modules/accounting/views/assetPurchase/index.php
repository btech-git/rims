<?php
/* @var $this AssetPurchaseController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Asset Purchases',
);

$this->menu=array(
	array('label'=>'Create AssetPurchase', 'url'=>array('create')),
	array('label'=>'Manage AssetPurchase', 'url'=>array('admin')),
);
?>

<h1>Asset Purchases</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
