<?php
/* @var $this TransaksiOrderPenjualanController */
/* @var $model TransaksiOrderPenjualan */

$this->breadcrumbs=array(
	'Movement Out Headers'=>array('admin'),
	$model->id,
	);

$this->menu=array(
	array('label'=>'List MovementOutHeader', 'url'=>array('admin')),
	array('label'=>'Manage MovementOutHeader', 'url'=>array('admin')),
);
?>
<div id="maincontent">
	<?php echo $this->renderPartial('_Approval', array(
		'model'=>$model,
		'movement'=>$movement,
		'historis'=>$historis
		//'jenisPersediaan'=>$jenisPersediaan,
		//'jenisPersediaanDataProvider'=>$jenisPersediaanDataProvider,
	)); ?>
</div>

