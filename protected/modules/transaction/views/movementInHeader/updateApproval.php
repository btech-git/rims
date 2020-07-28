<?php
/* @var $this TransaksiOrderPenjualanController */
/* @var $model TransaksiOrderPenjualan */

$this->breadcrumbs=array(
	'Movement In Headers'=>array('admin'),
	$model->id,
	);

$this->menu=array(
	array('label'=>'List MovementInHeader', 'url'=>array('admin')),
	array('label'=>'Manage MovementInHeader', 'url'=>array('admin')),
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

