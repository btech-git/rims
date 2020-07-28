<?php
/* @var $this ServiceEquipmentController */
/* @var $model ServiceEquipment */

$this->breadcrumbs=array(
	'Service Equipments'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ServiceEquipment', 'url'=>array('index')),
	array('label'=>'Manage ServiceEquipment', 'url'=>array('admin')),
);
?>

<h1>Create ServiceEquipment</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>