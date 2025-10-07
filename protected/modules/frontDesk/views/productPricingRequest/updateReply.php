<?php
/* @var $this BrandController */
/* @var $model Brand */

$this->breadcrumbs = array(
    'Permintaan Harga' => array('admin'),
    'Create',
);
?>

<div id="maincontent">
    <h1>Update Permintaan Harga</h1>
    <?php $this->renderPartial('_formReply', array('productPricingRequest' => $productPricingRequest,)); ?>
</div>