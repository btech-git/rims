<?php
/* @var $this ProductSubMasterCategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Product Sub Master Categories',
);

$this->menu=array(
	array('label'=>'Create ProductSubMasterCategory', 'url'=>array('create')),
	array('label'=>'Manage ProductSubMasterCategory', 'url'=>array('admin')),
);
?>

<h1>Product Sub Master Categories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
