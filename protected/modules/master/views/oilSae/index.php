<?php
/* @var $this OilSaeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Oil Saes',
);

$this->menu=array(
	array('label'=>'Create OilSae', 'url'=>array('create')),
	array('label'=>'Manage OilSae', 'url'=>array('admin')),
);
?>

<h1>Oil Saes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
