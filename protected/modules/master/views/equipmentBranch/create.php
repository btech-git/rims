<?php
/* @var $this EquipmentBranchController */
/* @var $model EquipmentBranch */

$this->breadcrumbs=array(
	'Product',
	'Equipment Branches'=>array('admin'),
	'Create Equipment Branch',
);

/*$this->menu=array(
	array('label'=>'List EquipmentBranch', 'url'=>array('index')),
	array('label'=>'Manage EquipmentBranch', 'url'=>array('admin')),
);
*/
?>



		<div id="maincontent">
			<?php $this->renderPartial('_form', array('model'=>$model)); ?>			
		</div>