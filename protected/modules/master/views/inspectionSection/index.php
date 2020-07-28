<?php
/* @var $this InspectionSectionController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Inspection Sections',
);

$this->menu=array(
	array('label'=>'Create InspectionSection', 'url'=>array('create')),
	array('label'=>'Manage InspectionSection', 'url'=>array('admin')),
);
?>

<h1>Inspection Sections</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
