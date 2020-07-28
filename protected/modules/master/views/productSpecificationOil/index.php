<?php
/* @var $this ProductSpecificationOilController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Product Specification Oils',
);

$this->menu=array(
	array('label'=>'Create ProductSpecificationOil', 'url'=>array('create')),
	array('label'=>'Manage ProductSpecificationOil', 'url'=>array('admin')),
);
?>

<h1>Product Specification Oils</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
