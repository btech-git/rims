<?php
/* @var $this InspectionChecklistModuleController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Inspection Checklist Modules',
);

$this->menu=array(
	array('label'=>'Create InspectionChecklistModule', 'url'=>array('create')),
	array('label'=>'Manage InspectionChecklistModule', 'url'=>array('admin')),
);
?>

<h1>Inspection Checklist Modules</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
