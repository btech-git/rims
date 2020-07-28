<?php
/* @var $this MovementInDetailController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Movement In Details',
);

$this->menu=array(
	array('label'=>'Create MovementInDetail', 'url'=>array('create')),
	array('label'=>'Manage MovementInDetail', 'url'=>array('admin')),
);
?>

<h1>Movement In Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
