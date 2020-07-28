<?php
/* @var $this TransaksiOrderPenjualanController */
/* @var $model TransaksiOrderPenjualan */

$this->breadcrumbs=array(
	'Transaction Purchase Orders'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TransactionPurchaseOrder', 'url'=>array('index')),
	array('label'=>'Manage TransactionPurchaseOrder', 'url'=>array('admin')),
);
?>
<div id="maincontent">
<?php echo $this->renderPartial('_status', array(
	'model'=>$model,
	//'jenisPersediaan'=>$jenisPersediaan,
	//'jenisPersediaanDataProvider'=>$jenisPersediaanDataProvider,
)); ?>
</div>
