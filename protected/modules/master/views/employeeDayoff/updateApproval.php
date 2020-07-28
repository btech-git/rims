<?php
/* @var $this TransaksiOrderPenjualanController */
/* @var $model TransaksiOrderPenjualan */

$this->breadcrumbs=array(
	'Employee Dayoffs'=>array('admin'),
	$model->id,
	);

$this->menu=array(
	array('label'=>'List Employee Dayoffs', 'url'=>array('admin')),
	array('label'=>'Manage Employee Dayoffs', 'url'=>array('admin')),
);
?>
<div id="maincontent">
	<?php echo $this->renderPartial('_Approval', array(
		'model'=>$model,
		'dayOff'=>$dayOff,
		'historis'=>$historis
		//'jenisPersediaan'=>$jenisPersediaan,
		//'jenisPersediaanDataProvider'=>$jenisPersediaanDataProvider,
	)); ?>
</div>

