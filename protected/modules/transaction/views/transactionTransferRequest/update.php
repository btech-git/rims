<?php
/* @var $this TransactionTransferRequestController */
/* @var $model TransactionTransferRequest */

$this->breadcrumbs=array(
	'Transaction Transfer Requests'=>array('admin'),
	$transferRequest->header->id=>array('view','id'=>$transferRequest->header->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TransactionTransferRequest', 'url'=>array('index')),
	array('label'=>'Create TransactionTransferRequest', 'url'=>array('create')),
	array('label'=>'View TransactionTransferRequest', 'url'=>array('view', 'id'=>$transferRequest->header->id)),
	array('label'=>'Manage TransactionTransferRequest', 'url'=>array('admin')),
);
?>
<div id="maincontent">
<?php echo $this->renderPartial('_form', array('transferRequest'=>$transferRequest,'product'=>$product,
	'productDataProvider'=>$productDataProvider,)); ?>
</div>
