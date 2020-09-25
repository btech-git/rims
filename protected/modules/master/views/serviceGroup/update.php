<?php
/* @var $this ServiceGroupController */
/* @var $model ServiceGroup */

$this->breadcrumbs=array(
	'Service Groups',
	$serviceGroup->header->name => array('view','id'=>$serviceGroup->header->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ServiceGroup', 'url'=>array('index')),
	array('label'=>'Create ServiceGroup', 'url'=>array('create')),
	array('label'=>'View ServiceGroup', 'url'=>array('view', 'id' => $serviceGroup->header->id)),
	array('label'=>'Manage ServiceGroup', 'url'=>array('admin')),
);
?>

<h1>Update Service Group <?php echo $serviceGroup->header->id; ?></h1>

<?php echo $this->renderPartial('_form', array(
    'serviceGroup' => $serviceGroup,
)); ?>