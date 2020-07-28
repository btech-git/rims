<?php
/* @var $this SubBrandSeriesController */
/* @var $model SubBrandSeries */

$this->breadcrumbs=array(
	'Product',
	'Sub-Brand Series'=>array('admin'),
	//$model->name=>array('view','id'=>$model->id),
	'Update Sub-Brand Series',
);

/*$this->menu=array(
	array('label'=>'List SubBrandSeries', 'url'=>array('index')),
	array('label'=>'Create SubBrandSeries', 'url'=>array('create')),
	array('label'=>'View SubBrandSeries', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage SubBrandSeries', 'url'=>array('admin')),
);*/
?>




		<div id="maincontent">

			<?php $this->renderPartial('_form', array('model'=>$model)); ?>
		</div>