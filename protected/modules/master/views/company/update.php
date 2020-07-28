<?php
/* @var $this CompanyController */
/* @var $model Company */

$this->breadcrumbs=array(
	'Company',		
	'Companies'=>array('admin'),
	$company->header->name=>array('view','id'=>$company->header->id),
	'Update',
);

// $this->menu=array(
// 	array('label'=>'List Company', 'url'=>array('index')),
// 	array('label'=>'Create Company', 'url'=>array('create')),
// 	array('label'=>'View Company', 'url'=>array('view', 'id'=>$model->id)),
// 	array('label'=>'Manage Company', 'url'=>array('admin')),
// );
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
					<?php $this->renderPartial('_updateBank', array(
							'model'=>$model,
							'bank'=>$bank,
							'bankDataProvider'=>$bankDataProvider,
							'coa'=>$coa,
							'coaDataProvider'=>$coaDataProvider,
							)); ?>
			<?php } else { ?>
				<?php echo $this->renderPartial('_form', array(
							'company'=>$company,
							'bank'=>$bank,
							'bankDataProvider'=>$bankDataProvider,
							'branch'=>$branch,
							'branchDataProvider'=>$branchDataProvider,
							'branchArray'=>$branchArray,
							'coa'=>$coa,
							'coaDataProvider'=>$coaDataProvider,
							)); ?>
			<?php } ?>
		<?php $this->endWidget(); ?>
	</div>