<?php
/* @var $this AssetCategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Asset Categories',
);

$this->menu=array(
	array('label'=>'Create AssetCategory', 'url'=>array('create')),
	array('label'=>'Manage AssetCategory', 'url'=>array('admin')),
);
?>

<h1>Asset Categories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
