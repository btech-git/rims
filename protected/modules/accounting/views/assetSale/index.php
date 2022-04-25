<?php
/* @var $this AssetSaleController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Asset Sales',
);

$this->menu=array(
	array('label'=>'Create AssetSale', 'url'=>array('create')),
	array('label'=>'Manage AssetSale', 'url'=>array('admin')),
);
?>

<h1>Asset Sales</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
