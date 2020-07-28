<?php
/* @var $this MovementInHeaderController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Movement In Headers',
);

$this->menu=array(
	array('label'=>'Create MovementInHeader', 'url'=>array('create')),
	array('label'=>'Manage MovementInHeader', 'url'=>array('admin')),
);
?>

<h1>Movement In Headers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
