<?php
/* @var $this TransaksiOrderPenjualanController */
/* @var $model TransaksiOrderPenjualan */

$this->breadcrumbs=array(
	'Jurnal Penyesuaian'=>array('admin'),
	$model->id,
	);

$this->menu=array(
	array('label'=>'List Jurnal Penyesuaian', 'url'=>array('admin')),
	array('label'=>'Manage Jurnal Penyesuaian', 'url'=>array('admin')),
);
?>
<div id="maincontent">
	<?php echo $this->renderPartial('_Approval', array(
		'model'=>$model,
		'jurnalPenyesuaian'=>$jurnalPenyesuaian,
		'historis'=>$historis
		//'jenisPersediaan'=>$jenisPersediaan,
		//'jenisPersediaanDataProvider'=>$jenisPersediaanDataProvider,
	)); ?>
</div>

