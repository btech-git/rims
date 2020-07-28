<?php
/* @var $this InvoiceDetailController */
/* @var $model InvoiceDetail */

$this->breadcrumbs=array(
	'Invoice Details'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

/*$this->menu=array(
	array('label'=>'List InvoiceDetail', 'url'=>array('index')),
	array('label'=>'Create InvoiceDetail', 'url'=>array('create')),
	array('label'=>'View InvoiceDetail', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage InvoiceDetail', 'url'=>array('admin')),
);*/
?>

<!--<h1>Update InvoiceDetail <?php echo $model->id; ?></h1>-->

<div id="maincontent">
	<?php $this->renderPartial('_form', array('model'=>$model)); ?></div>