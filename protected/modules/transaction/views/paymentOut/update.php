<?php
/* @var $this PaymentOutController */
/* @var $model PaymentOut */

$this->breadcrumbs=array(
	'Payment Outs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

/*$this->menu=array(
	array('label'=>'List PaymentOut', 'url'=>array('index')),
	array('label'=>'Create PaymentOut', 'url'=>array('create')),
	array('label'=>'View PaymentOut', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PaymentOut', 'url'=>array('admin')),
);*/
?>

<!--<h1>Update PaymentOut <?php echo $model->id; ?></h1>-->

<div id="maincontent">
	<?php $this->renderPartial('_form', array(
		'model'=>$model,
		'purchaseOrder'=>$purchaseOrder,
		'purchaseOrderDataProvider'=>$purchaseOrderDataProvider,
		'allowedImages'=>$allowedImages,
		'postImages'=>$postImages,
	)); ?></div>