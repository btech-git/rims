<?php
/* @var $this WarehouseController */
/* @var $model Warehouse */

$this->breadcrumbs=array(
	'Warehouse'=>array('admin'),
	'Warehouses'=>array('admin'),
	'Create',
);
/*
$this->menu=array(
	array('label'=>'List Warehouse', 'url'=>array('index')),
	array('label'=>'Manage Warehouse', 'url'=>array('admin')),
);*/
?>
<div id="maincontent">
	<?php $this->renderPartial('_form', array(
		'warehouse'=>$warehouse,
		'branch'=>$branch,
		'branchDataProvider'=>$branchDataProvider,
		'division'=>$division,
		'divisionDataProvider'=>$divisionDataProvider,
		'product'=>$product,
		'productDataProvider'=>$productDataProvider
	)); ?>
</div>