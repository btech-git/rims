<?php
/* @var $this EquipmentTypeController */
/* @var $model EquipmentType */

$this->breadcrumbs=array(
	'Product',
	'Equipment Types'=>array('admin'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List EquipmentType', 'url'=>array('index')),
	array('label'=>'Manage EquipmentType', 'url'=>array('admin')),
);*/
?>




		<div id="maincontent">
			<?php $this->renderPartial('_form', array('model'=>$model)); ?>
		</div>
