<?php
/* @var $this BrandController */
/* @var $model Brand */

$this->breadcrumbs=array(
	'Product',
	'Brands'=>array('admin'),
	//$model->name=>array('view','id'=>$model->id),
	'Update Brand',
);

/*$this->menu=array(
	array('label'=>'List Brand', 'url'=>array('index')),
	array('label'=>'Create Brand', 'url'=>array('create')),
	array('label'=>'View Brand', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Brand', 'url'=>array('admin')),
);*/
?>




		<div id="maincontent">

			<?php $this->renderPartial('_form', array('model'=>$model)); ?>
		</div>