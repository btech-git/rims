<?php
/* @var $this ProductMasterCategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Product Master Categories',
);

$this->menu=array(
	array('label'=>'Create ProductMasterCategory', 'url'=>array('create')),
	array('label'=>'Manage ProductMasterCategory', 'url'=>array('admin')),
);
?>

<h1>Product Master Categories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
