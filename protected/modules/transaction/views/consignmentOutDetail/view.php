<?php
/* @var $this ConsignmentOutDetailController */
/* @var $model ConsignmentOutDetail */

$this->breadcrumbs=array(
	'Consignment Out Details'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ConsignmentOutDetail', 'url'=>array('index')),
	array('label'=>'Create ConsignmentOutDetail', 'url'=>array('create')),
	array('label'=>'Update ConsignmentOutDetail', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ConsignmentOutDetail', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ConsignmentOutDetail', 'url'=>array('admin')),
);
?>

<!--<h1>View ConsignmentOutDetail #<?php echo $model->id; ?></h1>-->
<div id="maincontent">
	<div class="clearfix page-action">
		<?php $ccontroller = Yii::app()->controller->id; ?>
		<?php $ccaction = Yii::app()->controller->action->id; ?>
		<a class="button cbutton right" style="margin-right:10px;" href="#"><span class="fa fa-th-list"></span>Manage ConsignmentOutDetail</a>
		<a class="button cbutton right" style="margin-right:10px;" href="#"><span class="fa fa-edit"></span>Edit</a>
		<h1>View ConsignmentOutDetail #<?php echo $model->id; ?></h1>

		<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				'id',
		'consignment_out_id',
		'product_id',
		'qty_sent',
		'sale_price',
		'total_price',
			),
		)); ?>
	</div>
</div>