<?php
/* @var $this QuickServiceDetailController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Quick Service Details',
);

$this->menu=array(
	array('label'=>'Create QuickServiceDetail', 'url'=>array('create')),
	array('label'=>'Manage QuickServiceDetail', 'url'=>array('admin')),
);
?>

<h1>Quick Service Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
