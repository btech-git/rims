<?php
/* @var $this SupplierPicController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Supplier Pics',
);

$this->menu=array(
	array('label'=>'Create SupplierPic', 'url'=>array('create')),
	array('label'=>'Manage SupplierPic', 'url'=>array('admin')),
);
?>

<h1>Supplier Pics</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
