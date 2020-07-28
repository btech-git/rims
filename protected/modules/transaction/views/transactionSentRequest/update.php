<?php
/* @var $this TransactionSentRequestController */
/* @var $model TransactionSentRequest */

$this->breadcrumbs = array(
    'Transaction Transfer Requests' => array('admin'),
    $sentRequest->header->id => array('view', 'id' => $sentRequest->header->id),
    'Update',
);

$this->menu = array(
    array('label' => 'List TransactionSentRequest', 'url' => array('index')),
    array('label' => 'Create TransactionSentRequest', 'url' => array('create')),
    array('label' => 'View TransactionSentRequest', 'url' => array('view', 'id' => $sentRequest->header->id)),
    array('label' => 'Manage TransactionSentRequest', 'url' => array('admin')),
);
?>
<div id="maincontent">
    <?php echo $this->renderPartial('_form', array(
        'sentRequest' => $sentRequest,
        'product' => $product,
        'productDataProvider' => $productDataProvider,
    )); ?>
</div>