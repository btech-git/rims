<?php
/* @var $this EquipmentsController */
/* @var $model Equipments */

$this->breadcrumbs=array(
	'Product',
	'Equipments'=>array('admin'),
	'Create Equipment',
);

$this->menu=array(
	array('label'=>'List Equipments', 'url'=>array('index')),
	array('label'=>'Manage Equipments', 'url'=>array('admin')),
);
?>




		<div id="maincontent">
			<?php $this->renderPartial('_form', array('equipment'=>$equipment,
			//'branch'=>$branch,
			//'branchDataProvider'=>$branchDataProvider,
			)); ?>			
		</div>