<?php
/* @var $this MovementOutDetailController */
/* @var $model MovementOutDetail */

$this->breadcrumbs=array(
	'Movement Out Details'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List MovementOutDetail', 'url'=>array('index')),
	array('label'=>'Create MovementOutDetail', 'url'=>array('create')),
	array('label'=>'Update MovementOutDetail', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete MovementOutDetail', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage MovementOutDetail', 'url'=>array('admin')),
);
?>

<!--<h1>View MovementOutDetail #<?php echo $model->id; ?></h1>-->
<div id="maincontent">
	<div class="clearfix page-action">
		<?php $ccontroller = Yii::app()->controller->id; ?>
		<?php $ccaction = Yii::app()->controller->action->id; ?>
		<a class="button cbutton right" style="margin-right:10px;" href="#"><span class="fa fa-th-list"></span>Manage MovementOutDetail</a>
		<a class="button cbutton right" style="margin-right:10px;" href="#"><span class="fa fa-edit"></span>Edit</a>
		<h1>View MovementOutDetail #<?php echo $model->id; ?></h1>

		<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				'id',
		'movement_out_header_id',
		'delivery_order_detail_id',
		'product_id',
		'quantity_transaction',
		'warehouse_id',
		'quantity',
			),
		)); ?>
	</div>
</div>