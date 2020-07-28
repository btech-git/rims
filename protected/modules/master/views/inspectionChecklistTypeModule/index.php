<?php
/* @var $this InspectionChecklistTypeModuleController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Inspection Checklist Type Modules',
);

$this->menu=array(
	array('label'=>'Create InspectionChecklistTypeModule', 'url'=>array('create')),
	array('label'=>'Manage InspectionChecklistTypeModule', 'url'=>array('admin')),
);
?>

<h1>Inspection Checklist Type Modules</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
