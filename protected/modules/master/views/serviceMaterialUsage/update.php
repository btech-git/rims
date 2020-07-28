<?php
/* @var $this ServiceMaterialUsageController */
/* @var $model ServiceMaterialUsage */

$this->breadcrumbs=array(
	'Service Material Usages'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ServiceMaterialUsage', 'url'=>array('index')),
	array('label'=>'Create ServiceMaterialUsage', 'url'=>array('create')),
	array('label'=>'View ServiceMaterialUsage', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ServiceMaterialUsage', 'url'=>array('admin')),
);
?>

<h1>Update ServiceMaterialUsage <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>