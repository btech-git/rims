<?php
/* @var $this PowerccController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Powerccs',
);

$this->menu=array(
	array('label'=>'Create Powercc', 'url'=>array('create')),
	array('label'=>'Manage Powercc', 'url'=>array('admin')),
);
?>

<h1>Powerccs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
