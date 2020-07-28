<?php
/* @var $this CoaCategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Coa Categories',
);

$this->menu=array(
	array('label'=>'Create CoaCategory', 'url'=>array('create')),
	array('label'=>'Manage CoaCategory', 'url'=>array('admin')),
);
?>

<h1>Coa Categories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
