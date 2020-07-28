<?php
/* @var $this ProductSpecificationInfoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Product Specification Infos',
);

$this->menu=array(
	array('label'=>'Create ProductSpecificationInfo', 'url'=>array('create')),
	array('label'=>'Manage ProductSpecificationInfo', 'url'=>array('admin')),
);
?>

<h1>Product Specification Infos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
