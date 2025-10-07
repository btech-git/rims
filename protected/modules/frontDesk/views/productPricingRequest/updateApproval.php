<?php
/* @var $this TransaksiOrderPenjualanController */
/* @var $model TransaksiOrderPenjualan */

$this->breadcrumbs = array(
    'Product Pricing Request' => array('admin'),
    'Update Approval',
);

$this->menu = array(
    array('label' => 'List Product Pricing Request', 'url' => array('index')),
    array('label' => 'Manage Product Pricing Request', 'url' => array('admin')),
);
?>

<div id="maincontent">
    <?php echo $this->renderPartial('_approval', array(
        'model' => $model,
        'productPricingRequest' => $productPricingRequest,
        'historis' => $historis,
    )); ?>
</div>

