<?php
/* @var $this DivisionController */
/* @var $model Division */

$this->breadcrumbs=array(
	'Company',
	'Divisions'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Division', 'url'=>array('index')),
	array('label'=>'Manage Division', 'url'=>array('admin')),
);
?>



		<div id="maincontent">

			<?php $this->renderPartial('_form', array('division'=>$division,'position'=>$position,'positionDataProvider'=>$positionDataProvider, 'branch'=>$branch, 'branchDataProvider'=>$branchDataProvider,'warehouse'=>$warehouse,'warehouseDataProvider'=>$warehouseDataProvider,
				'positionArray'=>$positionArray,'branchArray'=>$branchArray,'warehouseArray'=>$warehouseArray,
			)); ?>
		</div>
