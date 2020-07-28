<?php
/* @var $this SubBrandController */
/* @var $model SubBrand */

$this->breadcrumbs=array(
	'Product',
	'Sub-Brands'=>array('admin'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List SubBrand', 'url'=>array('index')),
	array('label'=>'Manage SubBrand', 'url'=>array('admin')),
);*/
?>
<div id="maincontent">
	<?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>