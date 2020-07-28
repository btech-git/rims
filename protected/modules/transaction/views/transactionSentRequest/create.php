<?php
/* @var $this TransactionTransferRequestController */
/* @var $model TransactionTransferRequest */

$this->breadcrumbs=array(
	'Transaction Sent Requests'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TransactionSentRequest', 'url'=>array('index')),
	array('label'=>'Manage TransactionSentRequest', 'url'=>array('admin')),
);
?>
<div id="maincontent">
	<?php echo $this->renderPartial('_form', array('sentRequest'=>$sentRequest,
		'product'=>$product,
		'productDataProvider'=>$productDataProvider,
	)); ?>
</div>