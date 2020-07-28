<?php
/* @var $this EquipmentTaskController */
/* @var $model EquipmentTask */

$this->breadcrumbs=array(
	'Product',
	'Equipment Tasks'=>array('admin'),
	'Create Equipment Task',
);

/*$this->menu=array(
	array('label'=>'List EquipmentTask', 'url'=>array('index')),
	array('label'=>'Manage EquipmentTask', 'url'=>array('admin')),
);*/
?>



		<div id="maincontent">
			<?php $this->renderPartial('_form', array('model'=>$model)); ?>			
		</div>