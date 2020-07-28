<?php
/* @var $this PaymentInController */
/* @var $model PaymentIn */

$this->breadcrumbs=array(
	'Payment Ins'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

/*$this->menu=array(
	array('label'=>'List PaymentIn', 'url'=>array('index')),
	array('label'=>'Create PaymentIn', 'url'=>array('create')),
	array('label'=>'View PaymentIn', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PaymentIn', 'url'=>array('admin')),
);*/
?>

<!--<h1>Update PaymentIn <?php echo $model->id; ?></h1>-->

<div id="maincontent">
	<?php $this->renderPartial('_form', array('model'=>$model,
		'invoice'=>$invoice,
		'invoiceDataProvider'=>$invoiceDataProvider,
		'postImages' => $postImages,
		'allowedImages' => $allowedImages,
	)); ?></div>