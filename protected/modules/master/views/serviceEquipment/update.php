<?php
/* @var $this ServiceEquipmentController */
/* @var $model ServiceEquipment */

$this->breadcrumbs=array(
	'Service Equipments'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ServiceEquipment', 'url'=>array('index')),
	array('label'=>'Create ServiceEquipment', 'url'=>array('create')),
	array('label'=>'View ServiceEquipment', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ServiceEquipment', 'url'=>array('admin')),
);
?>

<h1>Update ServiceEquipment <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>