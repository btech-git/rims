<?php
/* @var $this ServiceTypeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Service Types',
);

$this->menu=array(
	array('label'=>'Create ServiceType', 'url'=>array('create')),
	array('label'=>'Manage ServiceType', 'url'=>array('admin')),
);
?>

<h1>Service Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
