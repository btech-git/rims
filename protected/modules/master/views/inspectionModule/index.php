<?php
/* @var $this InspectionModuleController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Inspection Modules',
);

$this->menu=array(
	array('label'=>'Create InspectionModule', 'url'=>array('create')),
	array('label'=>'Manage InspectionModule', 'url'=>array('admin')),
);
?>

<h1>Inspection Modules</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
