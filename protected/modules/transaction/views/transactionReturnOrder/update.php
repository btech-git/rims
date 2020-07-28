<?php
/* @var $this TransactionReturnOrderController */
/* @var $returnOrder->header TransactionReturnOrder */

$this->breadcrumbs=array(
	'Transaction Return Orders'=>array('admin'),
	$returnOrder->header->id=>array('view','id'=>$returnOrder->header->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TransactionReturnOrder', 'url'=>array('index')),
	array('label'=>'Create TransactionReturnOrder', 'url'=>array('create')),
	array('label'=>'View TransactionReturnOrder', 'url'=>array('view', 'id'=>$returnOrder->header->id)),
	array('label'=>'Manage TransactionReturnOrder', 'url'=>array('admin')),
);
?>
<div id="maincontent">
	<?php echo $this->renderPartial('_form', array(
		'returnOrder'=>$returnOrder,
		'receive'=>$receive,
		'receiveDataProvider'=>$receiveDataProvider,

	)); ?>
</div>