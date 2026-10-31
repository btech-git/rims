<?php
/* @var $this TransaksiOrderPenjualanController */
/* @var $model TransaksiOrderPenjualan */

$this->breadcrumbs=array(
	'Payment In'=>array('admin'),
	$model->id,
	);

$this->menu=array(
	array('label'=>'List Payment In', 'url'=>array('admin')),
	array('label'=>'Manage Payment In', 'url'=>array('admin')),
);
?>
<div id="maincontent">
	<?php echo $this->renderPartial('_Approval', array(
		'model'=>$model,
		'paymentIn'=>$paymentIn,
		'historis'=>$historis
		//'jenisPersediaan'=>$jenisPersediaan,
		//'jenisPersediaanDataProvider'=>$jenisPersediaanDataProvider,
	)); ?>
</div>

