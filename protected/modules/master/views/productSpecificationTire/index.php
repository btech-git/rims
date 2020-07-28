<?php
/* @var $this ProductSpecificationTireController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Product Specification Tires',
);

$this->menu=array(
	array('label'=>'Create ProductSpecificationTire', 'url'=>array('create')),
	array('label'=>'Manage ProductSpecificationTire', 'url'=>array('admin')),
);
?>

<h1>Product Specification Tires</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
