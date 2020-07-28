<?php
/* @var $this ServiceMaterialUsageController */
/* @var $model ServiceMaterialUsage */

$this->breadcrumbs=array(
	'Service Material Usages'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ServiceMaterialUsage', 'url'=>array('index')),
	array('label'=>'Manage ServiceMaterialUsage', 'url'=>array('admin')),
);
?>

<h1>Create ServiceMaterialUsage</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>