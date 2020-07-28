<?php
/* @var $this SubBrandController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Sub Brands',
);

$this->menu=array(
	array('label'=>'Create SubBrand', 'url'=>array('create')),
	array('label'=>'Manage SubBrand', 'url'=>array('admin')),
);
?>

<h1>Sub Brands</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
