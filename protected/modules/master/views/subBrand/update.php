<?php
/* @var $this SubBrandController */
/* @var $model SubBrand */

$this->breadcrumbs=array(
	'Product',
	'Sub-Brands'=>array('admin'),
	//$model->name=>array('view','id'=>$model->id),
	'Update Sub-Brand',
);

/*$this->menu=array(
	array('label'=>'List SubBrand', 'url'=>array('index')),
	array('label'=>'Create SubBrand', 'url'=>array('create')),
	array('label'=>'View SubBrand', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage SubBrand', 'url'=>array('admin')),
);*/
?>
<div id="maincontent">
	<?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>