<?php
/* @var $this InspectionModuleController */
/* @var $model InspectionModule */

$this->breadcrumbs=array(
	'Service',
	'Inspection Modules'=>array('admin'),
	'Update Inspection Modules',
);

/*$this->menu=array(
	array('label'=>'List InspectionModule', 'url'=>array('index')),
	array('label'=>'Create InspectionModule', 'url'=>array('create')),
	array('label'=>'View InspectionModule', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage InspectionModule', 'url'=>array('admin')),
);*/
?>
		<div id="maincontent">
			<?php $this->renderPartial('_form', array('model'=>$model)); ?>
		</div>