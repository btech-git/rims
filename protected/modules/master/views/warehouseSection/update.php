<?php
/* @var $this WarehouseSectionController */
/* @var $model WarehouseSection */

$this->breadcrumbs=array(
	'Warehouse Sections'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List WarehouseSection', 'url'=>array('index')),
	array('label'=>'Create WarehouseSection', 'url'=>array('create')),
	array('label'=>'View WarehouseSection', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage WarehouseSection', 'url'=>array('admin')),
);
?>

<h1>Update WarehouseSection <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>