<?php
/* @var $this EquipmentSubTypeController */
/* @var $model EquipmentSubType */

$this->breadcrumbs=array(
	'Product',
	'Equipment Sub Types'=>array('admin'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List EquipmentSubType', 'url'=>array('index')),
	array('label'=>'Manage EquipmentSubType', 'url'=>array('admin')),
);*/
?>




		<div id="maincontent">

			<?php $this->renderPartial('_form', array('model'=>$model)); ?>
		</div>
