<?php
/* @var $this ProductSpecificationTypeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Product Specification Types',
);

$this->menu=array(
	array('label'=>'Create ProductSpecificationType', 'url'=>array('create')),
	array('label'=>'Manage ProductSpecificationType', 'url'=>array('admin')),
);
?>

<h1>Product Specification Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
