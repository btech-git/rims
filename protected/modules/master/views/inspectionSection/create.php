<?php
/* @var $this InspectionSectionController */
/* @var $model InspectionSection */

$this->breadcrumbs=array(
	'Service',
	'Inspection Sections'=>array('admin'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List InspectionSection', 'url'=>array('index')),
	array('label'=>'Manage InspectionSection', 'url'=>array('admin')),
);*/
?>
		<div id="maincontent">
			<?php $this->renderPartial('_form', array(
				'section'=>$section,
				'module'=>$module,
				'moduleDataProvider'=>$moduleDataProvider,
				'moduleArray'=>$moduleArray
			));?>
		</div>