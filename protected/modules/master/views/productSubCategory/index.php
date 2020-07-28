<?php
/* @var $this ProductSubCategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Product Sub Categories',
);

$this->menu=array(
	array('label'=>'Create ProductSubCategory', 'url'=>array('create')),
	array('label'=>'Manage ProductSubCategory', 'url'=>array('admin')),
);
?>

<h1>Product Sub Categories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
