<?php
/* @var $this BranchController */
/* @var $model Branch */

$this->breadcrumbs=array(
	'Company',		
	'Branches'=>array('admin'),
	//$model->name=>array('view','id'=>$model->id),
	'Update',
);

/*$this->menu=array(
	array('label'=>'List Branch', 'url'=>array('index')),
	array('label'=>'Create Branch', 'url'=>array('create')),
	array('label'=>'View Branch', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Branch', 'url'=>array('admin')),
);*/
?>


		<div id="maincontent">
			<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'customer-form',
			// Please note: When you enable ajax validation, make sure the corresponding
			// controller action is handling ajax validation correctly.
			// There is a call to performAjaxValidation() commented in generated controller code.
			// See class documentation of CActiveForm for details on this.
			//'enableAjaxValidation'=>false,
			)); ?>
			<?php if($this->action->id== 'updateDivision'){
					$this->renderPartial('_updateDivision',array('model'=>$model,'division'=>$division,'divisionDataProvider'=>$divisionDataProvider,));
				} else {
					$this->renderPartial('_form', array(
						'branch'=>$branch,
						'warehouse'=>$warehouse,
						'warehouseDataProvider'=>$warehouseDataProvider,
						'division'=>$division,
						'divisionDataProvider'=>$divisionDataProvider,
						'divisionArray'=>$divisionArray,
						'coaInterbranch'=>$coaInterbranch,
						'coaInterbranchDataProvider'=>$coaInterbranchDataProvider,
						)); 
					} ?>
			
			<?php $this->endWidget(); ?>
		</div>