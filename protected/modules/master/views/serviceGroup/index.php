<?php
/* @var $this ServiceGroupController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Service Groups',
);

$this->menu=array(
	array('label'=>'Create ServiceGroup', 'url'=>array('create')),
	array('label'=>'Manage ServiceGroup', 'url'=>array('admin')),
);
?>

<h1>Service Groups</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
