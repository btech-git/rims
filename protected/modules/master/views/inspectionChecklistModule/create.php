<?php
/* @var $this InspectionChecklistModuleController */
/* @var $model InspectionChecklistModule */

$this->breadcrumbs=array(
	'Service',
	'Inspection Checklist Modules'=>array('admin'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List InspectionChecklistModule', 'url'=>array('index')),
	array('label'=>'Manage InspectionChecklistModule', 'url'=>array('admin')),
);*/
?>




		<div id="maincontent">

			<?php $this->renderPartial('_form', array('model'=>$model)); ?>
		</div>