<?php
/* @var $this QuickServiceController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Quick Services',
);

$this->menu=array(
	array('label'=>'Create QuickService', 'url'=>array('create')),
	array('label'=>'Manage QuickService', 'url'=>array('admin')),
);
?>

<h1>Quick Services</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
