<?php
/* @var $this TransactionTransferRequestController */
/* @var $model TransactionTransferRequest */

$this->breadcrumbs=array(
    'Receive Item'=>array('admin'),
    'Create',
);

$this->menu=array(
    array('label'=>'List TransactionReceiveItem', 'url'=>array('index')),
    array('label'=>'Manage TransactionReceiveItem', 'url'=>array('admin')),
);
?>
<div id="maincontent">
    <?php echo $this->renderPartial('_form', array(
        'receiveItem'=>$receiveItem,
        'branches' => $branches,
    )); ?>
</div>
