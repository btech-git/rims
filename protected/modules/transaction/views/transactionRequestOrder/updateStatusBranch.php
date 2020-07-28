<?php
/* @var $this TransaksiOrderPenjualanController */
/* @var $model TransaksiOrderPenjualan */

$this->breadcrumbs=array(
	'Transaction Request Orders'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TransactionRequestOrder', 'url'=>array('index')),
	array('label'=>'Manage TransactionRequestOrder', 'url'=>array('admin')),
);
?>
<div id="maincontent">
	<?php echo $this->renderPartial('_statusBranch', array(
		'model'=>$model,
		//'jenisPersediaan'=>$jenisPersediaan,
		//'jenisPersediaanDataProvider'=>$jenisPersediaanDataProvider,
		)); ?>
</div>