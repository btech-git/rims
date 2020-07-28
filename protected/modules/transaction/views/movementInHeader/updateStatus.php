<?php
/* @var $this TransaksiOrderPenjualanController */
/* @var $model TransaksiOrderPenjualan */

$this->breadcrumbs=array(
	'Movement In Headers'=>array('admin'),
	'Update Status',
);

$this->menu=array(
	array('label'=>'List MovementInHeaders', 'url'=>array('index')),
	array('label'=>'Manage MovementInHeaders', 'url'=>array('admin')),
);
?>
<div id="maincontent">
<?php echo $this->renderPartial('_status', array(
	'model'=>$model,
	
	)); ?>
</div>