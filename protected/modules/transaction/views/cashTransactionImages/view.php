<?php
/* @var $this CashTransactionImagesController */
/* @var $model CashTransactionImages */

$this->breadcrumbs=array(
	'Cash Transaction Images'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CashTransactionImages', 'url'=>array('index')),
	array('label'=>'Create CashTransactionImages', 'url'=>array('create')),
	array('label'=>'Update CashTransactionImages', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CashTransactionImages', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CashTransactionImages', 'url'=>array('admin')),
);
?>

<!--<h1>View CashTransactionImages #<?php echo $model->id; ?></h1>-->
<div id="maincontent">
	<div class="clearfix page-action">
		<?php $ccontroller = Yii::app()->controller->id; ?>
		<?php $ccaction = Yii::app()->controller->action->id; ?>
		<a class="button cbutton right" style="margin-right:10px;" href="#"><span class="fa fa-th-list"></span>Manage CashTransactionImages</a>
		<a class="button cbutton right" style="margin-right:10px;" href="#"><span class="fa fa-edit"></span>Edit</a>
		<h1>View CashTransactionImages #<?php echo $model->id; ?></h1>

		<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				'id',
		'cash_transaction_id',
		'extension',
		'is_inactive',
			),
		)); ?>
	</div>
</div>