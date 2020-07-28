<?php
/* @var $this CoaSubCategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Coa Sub Categories',
);

$this->menu=array(
	array('label'=>'Create CoaSubCategory', 'url'=>array('create')),
	array('label'=>'Manage CoaSubCategory', 'url'=>array('admin')),
);
?>

<h1>Coa Sub Categories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
