<?php
/* @var $this EquipmentTypeController */
/* @var $model EquipmentType */

$this->breadcrumbs=array(
	'Product',
	'Equipment Types'=>array('admin'),
	//$model->name=>array('view','id'=>$model->id),
	'Update Equipment Type',
);

/*$this->menu=array(
	array('label'=>'List EquipmentType', 'url'=>array('index')),
	array('label'=>'Create EquipmentType', 'url'=>array('create')),
	array('label'=>'View EquipmentType', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage EquipmentType', 'url'=>array('admin')),
);*/
?>




		<div id="maincontent">

			<?php $this->renderPartial('_form', array('model'=>$model)); ?>
		</div>