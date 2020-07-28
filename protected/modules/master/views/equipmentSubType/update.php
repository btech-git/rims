<?php
/* @var $this EquipmentSubTypeController */
/* @var $model EquipmentSubType */

$this->breadcrumbs=array(
	'Product',
	'Equipment Sub Types'=>array('admin'),
	//$model->name=>array('view','id'=>$model->id),
	'Update Equipment Sub Types',
);

/*$this->menu=array(
	array('label'=>'List EquipmentSubType', 'url'=>array('index')),
	array('label'=>'Create EquipmentSubType', 'url'=>array('create')),
	array('label'=>'View EquipmentSubType', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage EquipmentSubType', 'url'=>array('admin')),
);*/
?>




		<div id="maincontent">

			<?php $this->renderPartial('_form', array('model'=>$model)); ?>
		</div>
