<?php
/* @var $this SubBrandSeriesController */
/* @var $model SubBrandSeries */

$this->breadcrumbs=array(
	'Product',
	'Sub-Brand Series'=>array('admin'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List SubBrandSeries', 'url'=>array('index')),
	array('label'=>'Manage SubBrandSeries', 'url'=>array('admin')),
);*/
?>


		<div id="maincontent">

			<?php $this->renderPartial('_form', array('model'=>$model)); ?>
		</div>