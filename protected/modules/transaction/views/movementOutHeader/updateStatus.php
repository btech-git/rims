<?php
/* @var $this TransaksiOrderPenjualanController */
/* @var $model TransaksiOrderPenjualan */

$this->breadcrumbs=array(
	'Movement Out Headers'=>array('admin'),
	'Update Status',
);

$this->menu=array(
	array('label'=>'List MovementOutHeaders', 'url'=>array('index')),
	array('label'=>'Manage MovementOutHeaders', 'url'=>array('admin')),
);
?>
<div id="maincontent">
<?php echo $this->renderPartial('_status', array(
	'model'=>$model,
	
	)); ?>
</div>