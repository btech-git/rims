<?php
/* @var $this InvoiceDetailController */
/* @var $model InvoiceDetail */

$this->breadcrumbs=array(
	'Invoice Details'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List InvoiceDetail', 'url'=>array('index')),
	array('label'=>'Create InvoiceDetail', 'url'=>array('create')),
	array('label'=>'Update InvoiceDetail', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete InvoiceDetail', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage InvoiceDetail', 'url'=>array('admin')),
);
?>

<!--<h1>View InvoiceDetail #<?php echo $model->id; ?></h1>-->
<div id="maincontent">
	<div class="clearfix page-action">
		<?php $ccontroller = Yii::app()->controller->id; ?>
		<?php $ccaction = Yii::app()->controller->action->id; ?>
		<a class="button cbutton right" style="margin-right:10px;" href="#"><span class="fa fa-th-list"></span>Manage InvoiceDetail</a>
		<a class="button cbutton right" style="margin-right:10px;" href="#"><span class="fa fa-edit"></span>Edit</a>
		<h1>View InvoiceDetail #<?php echo $model->id; ?></h1>

		<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				'id',
		'invoice_id',
		'service_id',
		'product_id',
		'quantity',
		'unit_price',
		'total_price',
			),
		)); ?>
	</div>
</div>