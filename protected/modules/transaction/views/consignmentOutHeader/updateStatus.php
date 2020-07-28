<?php
/* @var $this TransaksiOrderPenjualanController */
/* @var $model TransaksiOrderPenjualan */

$this->breadcrumbs=array(
	'Consignment Out Headers'=>array('admin'),
	'Update Status',
);

$this->menu=array(
	array('label'=>'List ConsignmentOutHeader', 'url'=>array('index')),
	array('label'=>'Manage ConsignmentOutHeader', 'url'=>array('admin')),
);
?>
<div id="maincontent">
<?php echo $this->renderPartial('_status', array(
	'model'=>$model,
	//'jenisPersediaan'=>$jenisPersediaan,
	//'jenisPersediaanDataProvider'=>$jenisPersediaanDataProvider,
	)); ?>
</div>