<?php
/* @var $this CashTransactionDetailController */
/* @var $model CashTransactionDetail */

$this->breadcrumbs=array(
	'Cash Transaction Details'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CashTransactionDetail', 'url'=>array('index')),
	array('label'=>'Create CashTransactionDetail', 'url'=>array('create')),
	array('label'=>'Update CashTransactionDetail', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CashTransactionDetail', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CashTransactionDetail', 'url'=>array('admin')),
);
?>

<!--<h1>View CashTransactionDetail #<?php echo $model->id; ?></h1>-->
<div id="maincontent">
	<div class="clearfix page-action">
		<?php $ccontroller = Yii::app()->controller->id; ?>
		<?php $ccaction = Yii::app()->controller->action->id; ?>
		<a class="button cbutton right" style="margin-right:10px;" href="#"><span class="fa fa-th-list"></span>Manage CashTransactionDetail</a>
		<a class="button cbutton right" style="margin-right:10px;" href="#"><span class="fa fa-edit"></span>Edit</a>
		<h1>View CashTransactionDetail #<?php echo $model->id; ?></h1>

		<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				'id',
		'cash_transaction_id',
		'coa_id',
		'amount',
		'notes',
			),
		)); ?>
	</div>
</div>