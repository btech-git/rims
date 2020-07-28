<?php
/* @var $this SupplierController */
/* @var $model Supplier */

$this->breadcrumbs=array(
	'Company',
 	'Suppliers'=>array('admin'),
	//$model->name=>array('view','id'=>$model->id),
 	'Update Supplier',
);

// $this->menu=array(
// 	array('label'=>'List Supplier', 'url'=>array('index')),
// 	array('label'=>'Create Supplier', 'url'=>array('create')),
// 	array('label'=>'View Supplier', 'url'=>array('view', 'id'=>$model->id)),
// 	array('label'=>'Manage Supplier', 'url'=>array('admin')),
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
				<?php $this->renderPartial('_updateBank', array('model'=>$model,'bank'=>$bank,'bankDataProvider'=>$bankDataProvider)); ?>
			<?php } elseif ($this->action->id == 'updatePic') { ?>
				<?php $this->renderPartial('_updatePic', array('model'=>$model)); ?>
			<?php }else { ?>
			<?php echo $this->renderPartial('_form', array('supplier'=>$supplier,
				'bank'=>$bank,
				'bankDataProvider'=>$bankDataProvider,
				'product'=>$product,
				'productDataProvider'=>$productDataProvider,
				'productArray'=>$productArray,
				'coa'=>$coa,
				'coaDataProvider'=>$coaDataProvider,
				'coaOutstanding'=>$coaOutstanding,
				'coaOutstandingDataProvider'=>$coaOutstandingDataProvider,
			)); ?>
			<?php } ?>
			<?php $this->endWidget(); ?>
		</div>