<?php
/* @var $this PublicDayOffController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Public Day Offs',
);

$this->menu=array(
	array('label'=>'Create PublicDayOff', 'url'=>array('create')),
	array('label'=>'Manage PublicDayOff', 'url'=>array('admin')),
);
?>

<h1>Public Day Offs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
