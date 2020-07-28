<?php
/* @var $this SubBrandSeriesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Sub Brand Series',
);

$this->menu=array(
	array('label'=>'Create SubBrandSeries', 'url'=>array('create')),
	array('label'=>'Manage SubBrandSeries', 'url'=>array('admin')),
);
?>

<h1>Sub Brand Series</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
