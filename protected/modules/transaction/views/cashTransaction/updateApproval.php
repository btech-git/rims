<?php
/* @var $this TransaksiOrderPenjualanController */
/* @var $model TransaksiOrderPenjualan */

$this->breadcrumbs=array(
	'Cash Transaction'=>array('admin'),
	$model->id,
	);

$this->menu=array(
	array('label'=>'List Cash Transaction', 'url'=>array('admin')),
	array('label'=>'Manage Cash Transaction', 'url'=>array('admin')),
);
?>
<div id="maincontent">
	<?php echo $this->renderPartial('_Approval', array(
		'model'=>$model,
		'cashTransaction'=>$cashTransaction,
		'historis'=>$historis
		//'jenisPersediaan'=>$jenisPersediaan,
		//'jenisPersediaanDataProvider'=>$jenisPersediaanDataProvider,
	)); ?>
</div>

