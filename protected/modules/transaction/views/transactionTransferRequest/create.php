<?php
/* @var $this TransactionTransferRequestController */
/* @var $model TransactionTransferRequest */

$this->breadcrumbs=array(
	'Transaction Transfer Requests'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TransactionTransferRequest', 'url'=>array('index')),
	array('label'=>'Manage TransactionTransferRequest', 'url'=>array('admin')),
);
?>
<div id="maincontent">
	<?php echo $this->renderPartial('_form', array('transferRequest'=>$transferRequest,
		'product'=>$product,
		'productDataProvider'=>$productDataProvider,
	)); ?>
</div>

