<?php
/* @var $this EquipmentsController */
/* @var $model Equipments */

$this->breadcrumbs=array(
	'Product',
	'Equipments'=>array('admin'),
	'Update Equipment',
);

/*$this->menu=array(
	array('label'=>'List Equipments', 'url'=>array('index')),
	array('label'=>'Create Equipments', 'url'=>array('create')),
	array('label'=>'View Equipments', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Equipments', 'url'=>array('admin')),
);*/
?>


		<div id="maincontent">
			<?php $this->renderPartial('_form', array('equipment'=>$equipment,)); ?>
		</div>