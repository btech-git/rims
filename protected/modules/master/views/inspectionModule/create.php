<?php
/* @var $this InspectionModuleController */
/* @var $model InspectionModule */

$this->breadcrumbs=array(
	'Service',
	'Inspection Modules'=>array('admin'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List InspectionModule', 'url'=>array('index')),
	array('label'=>'Manage InspectionModule', 'url'=>array('admin')),
);*/
?>
		<div id="maincontent">
			<?php $this->renderPartial('_form', array('model'=>$model)); ?>
		</div>