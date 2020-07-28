<?php
/* @var $this EquipmentDetailsController */
/* @var $model EquipmentDetails */

$this->breadcrumbs=array(
	'Product',
	'Equipment Details'=>array('admin'),
	'Create Equipment Branch',
);

/*$this->menu=array(
	array('label'=>'List EquipmentDetails', 'url'=>array('index')),
	array('label'=>'Manage EquipmentDetails', 'url'=>array('admin')),
);*/
?>



		<div id="maincontent">
			<?php $this->renderPartial('_form', array('model'=>$model)); ?>			
		</div>