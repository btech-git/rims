<?php
/* @var $this SupplierPicController */
/* @var $model SupplierPic */

$this->breadcrumbs=array(
	'Supplier Pics'=>array('admin'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SupplierPic', 'url'=>array('index')),
	array('label'=>'Create SupplierPic', 'url'=>array('create')),
	array('label'=>'View SupplierPic', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage SupplierPic', 'url'=>array('admin')),
);
?>

<h1>Update SupplierPic <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>