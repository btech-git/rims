<?php
/* @var $this TransactionReturnOrderController */
/* @var $model TransactionReturnOrder */

$this->breadcrumbs=array(
	'Transaction Return Orders'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TransactionReturnOrder', 'url'=>array('index')),
	array('label'=>'Manage TransactionReturnOrder', 'url'=>array('admin')),
);
?>
<div id="maincontent">
	<?php echo $this->renderPartial('_form', array(//'model'=>$model
		'returnOrder'=>$returnOrder,
		'receive'=>$receive,
		'receiveDataProvider'=>$receiveDataProvider,
	)); ?>
</div>