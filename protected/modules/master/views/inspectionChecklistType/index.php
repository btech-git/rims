<?php
/* @var $this InspectionChecklistTypeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Inspection Checklist Types',
);

$this->menu=array(
	array('label'=>'Create InspectionChecklistType', 'url'=>array('create')),
	array('label'=>'Manage InspectionChecklistType', 'url'=>array('admin')),
);
?>

<h1>Inspection Checklist Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
