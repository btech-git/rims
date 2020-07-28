<?php
/* @var $this TransaksiOrderPenjualanController */
/* @var $model TransaksiOrderPenjualan */

$this->breadcrumbs=array(
	'Consignment In Headers'=>array('admin'),
	$model->id,
	);

$this->menu=array(
	array('label'=>'List ConsignmentInHeader', 'url'=>array('admin')),
	array('label'=>'Manage ConsignmentInHeader', 'url'=>array('admin')),
);
?>
<div id="maincontent">
	<?php echo $this->renderPartial('_Approval', array(
		'model'=>$model,
		'consignment'=>$consignment,
		'historis'=>$historis
		//'jenisPersediaan'=>$jenisPersediaan,
		//'jenisPersediaanDataProvider'=>$jenisPersediaanDataProvider,
	)); ?>
</div>

