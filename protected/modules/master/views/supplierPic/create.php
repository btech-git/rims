<?php
/* @var $this SupplierPicController */
/* @var $model SupplierPic */

$this->breadcrumbs=array(
	'Supplier Pics'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SupplierPic', 'url'=>array('index')),
	array('label'=>'Manage SupplierPic', 'url'=>array('admin')),
);
?>

<h1>Create SupplierPic</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>