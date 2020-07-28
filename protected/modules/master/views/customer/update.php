<?php
/* @var $this CustomerController */
/* @var $model Customer */

$this->breadcrumbs=array(
	'Company',
 	'Customers'=>array('admin'),
	//$model->name=>array('view','id'=>$model->id),
	'Update Customer',
);

/*$this->menu=array(
	array('label'=>'List Customer', 'url'=>array('index')),
	array('label'=>'Create Customer', 'url'=>array('create')),
	array('label'=>'View Customer', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Customer', 'url'=>array('admin')),
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
			<?php if($this->action->id == 'updatePic') { ?>

				<?php $this->renderPartial('_updatePic', array('model'=>$model)); ?>
				
			<?php } elseif ($this->action->id == 'updateVehicle') { ?>
			
				<?php $this->renderPartial('_updateVehicle', array('model'=>$model)); ?>

			<?php } elseif ($this->action->id == 'updatePrice') { ?>

				<?php $this->renderPartial('_updatePrice', array('model'=>$model)); ?>

			<?php } else {?>
				
				<?php $this->renderPartial('_form', array('customer'=>$customer,'service'=>$service,
			'serviceDataProvider'=>$serviceDataProvider,'coa'=>$coa,
			'coaDataProvider'=>$coaDataProvider,)); ?>
			<?php	} ?>

			 <?php $this->endWidget(); ?>
		</div>