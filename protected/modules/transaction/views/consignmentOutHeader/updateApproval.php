<?php
/* @var $this TransaksiOrderPenjualanController */
/* @var $model TransaksiOrderPenjualan */

$this->breadcrumbs=array(
	'Consignment Out Headers'=>array('admin'),
	$model->id,
	);

$this->menu=array(
	array('label'=>'List ConsignmentOutHeader', 'url'=>array('admin')),
	array('label'=>'Manage ConsignmentOutHeader', 'url'=>array('admin')),
);
?>
<div id="maincontent">
	<?php echo $this->renderPartial('_Approval', array(
		'model'=>$model,
		'consignment'=>$consignment,
		'historis'=>$historis
		
	)); ?>
</div>

