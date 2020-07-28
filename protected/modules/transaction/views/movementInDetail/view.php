<?php
/* @var $this MovementInDetailController */
/* @var $model MovementInDetail */

$this->breadcrumbs=array(
	'Movement In Details'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List MovementInDetail', 'url'=>array('index')),
	array('label'=>'Create MovementInDetail', 'url'=>array('create')),
	array('label'=>'Update MovementInDetail', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete MovementInDetail', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage MovementInDetail', 'url'=>array('admin')),
);
?>

<!--<h1>View MovementInDetail #<?php echo $model->id; ?></h1>-->
<div id="maincontent">
	<div class="clearfix page-action">
		<?php $ccontroller = Yii::app()->controller->id; ?>
		<?php $ccaction = Yii::app()->controller->action->id; ?>
		<a class="button cbutton right" style="margin-right:10px;" href="#"><span class="fa fa-th-list"></span>Manage MovementInDetail</a>
		<a class="button cbutton right" style="margin-right:10px;" href="#"><span class="fa fa-edit"></span>Edit</a>
		<h1>View MovementInDetail #<?php echo $model->id; ?></h1>

		<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				'id',
		'receive_item_detail_id',
		'movement_in_header_id',
		'product_id',
		'quantity_transaction',
		'quantity',
		'warehouse_id',
			),
		)); ?>
	</div>
</div>