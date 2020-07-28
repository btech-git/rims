<?php
/* @var $this EmployeeController */
/* @var $model Employee */

$this->breadcrumbs=array(
	'Company',
	'Employees'=>array('admin'),
	//$model->name=>array('view','id'=>$model->id),
	'Update Employee',
);

$this->menu=array(
	// array('label'=>'List Employee', 'url'=>array('index')),
	// array('label'=>'Create Employee', 'url'=>array('create')),
	// array('label'=>'View Employee', 'url'=>array('view', 'id'=>$model->id)),
	// array('label'=>'Manage Employee', 'url'=>array('admin')),
);
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


			<?php if($this->action->id == 'updateBank') { ?>
				<?php $this->renderPartial('_updateBank', array('model'=>$model,'bank'=>$bank,'bankDataProvider'=>$bankDataProvider)); ?>
			<?php } elseif ($this->action->id =='updateIncentive') {
					$this->renderPartial('_updateIncentive',array('model'=>$model,'incentive'=>$incentive,'incentiveDataProvider'=>$incentiveDataProvider,));?>
			<?php } elseif ($this->action->id =='updateDeduction') {
					$this->renderPartial('_updateDeduction',array('model'=>$model,'deduction'=>$deduction,
						'deductionDataProvider'=>$deductionDataProvider,));?>
			<?php } else { ?>
				<?php $this->renderPartial('_form', array('employee'=>$employee,'bank'=>$bank,
				'bankDataProvider'=>$bankDataProvider,
				'incentive'=>$incentive,
				'incentiveDataProvider'=>$incentiveDataProvider,
				'deduction'=>$deduction,
				'deductionDataProvider'=>$deductionDataProvider,
				'branch'=>$branch,
				'branchDataProvider'=>$branchDataProvider,
				)); ?>
			<?php } ?>

			 <?php $this->endWidget(); ?>
		</div>