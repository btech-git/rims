<?php
/* @var $this BranchController */
/* @var $model Branch */

$this->breadcrumbs=array(
	'Company',		
	'Branches'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Branch', 'url'=>array('index')),
	array('label'=>'Manage Branch', 'url'=>array('admin')),
);
?>


		<div id="maincontent">

			<?php $this->renderPartial('_form', array(
				'branch'=>$branch,
				'warehouse'=>$warehouse,
				'warehouseDataProvider'=>$warehouseDataProvider,
				'division'=>$division,
				'divisionDataProvider'=>$divisionDataProvider,
				'divisionArray'=>$divisionArray,
				'coaInterbranch'=>$coaInterbranch,
				'coaInterbranchDataProvider'=>$coaInterbranchDataProvider,
			)); ?>
		</div>