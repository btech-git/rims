<?php
/* @var $this ServiceMaterialUsageController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Service Material Usages',
);

$this->menu=array(
	array('label'=>'Create ServiceMaterialUsage', 'url'=>array('create')),
	array('label'=>'Manage ServiceMaterialUsage', 'url'=>array('admin')),
);
?>

<h1>Service Material Usages</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
