<?php
/* @var $this InspectionController */
/* @var $model Inspection */

$this->breadcrumbs=array(
	'Service',
	'Inspections'=>array('admin'),
	'Update Inspections',
);

/*$this->menu=array(
	array('label'=>'List Inspection', 'url'=>array('index')),
	array('label'=>'Create Inspection', 'url'=>array('create')),
	array('label'=>'View Inspection', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Inspection', 'url'=>array('admin')),
);*/
?>
		<div id="maincontent">

			<?php $this->renderPartial('_form', array(
				'inspection'=>$inspection,
				'section'=>$section,
				'sectionDataProvider'=>$sectionDataProvider,
				'sectionArray'=>$sectionArray,
			));?>
		</div>