<?php
/* @var $this WarehouseSectionController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Warehouse Sections',
);

$this->menu=array(
	array('label'=>'Create WarehouseSection', 'url'=>array('create')),
	array('label'=>'Manage WarehouseSection', 'url'=>array('admin')),
);
?>

<h1>Warehouse Sections</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
