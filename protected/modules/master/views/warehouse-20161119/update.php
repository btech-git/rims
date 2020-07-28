<?php
/* @var $this WarehouseController */
/* @var $model Warehouse */

$this->breadcrumbs=array(
	'Warehouse'=>array('admin'),
	'Warehouses'=>array('admin'),
	//$model->name=>array('view','id'=>$model->id),
	'Update Warehouse',
);
/*
$this->menu=array(
	array('label'=>'List Warehouse', 'url'=>array('index')),
	array('label'=>'Create Warehouse', 'url'=>array('create')),
	array('label'=>'View Warehouse', 'url'=>array('view', 'id'=>$model->id)),
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
			'productDataProvider'=>$productDataProvider,
		)); 
	?>
</div>