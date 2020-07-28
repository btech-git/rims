<?php
/* @var $this WarehouseSectionController */
/* @var $model WarehouseSection */

$this->breadcrumbs=array(
	'Warehouse Sections'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List WarehouseSection', 'url'=>array('index')),
	array('label'=>'Manage WarehouseSection', 'url'=>array('admin')),
);
?>

<h1>Create WarehouseSection</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>