<?php
/* @var $this BrandController */
/* @var $model Brand */

$this->breadcrumbs = array(
    'Permintaan Harga' => array('admin'),
    'Reply',
);
?>

<h3>Reply Permintaan Harga Cabang</h3>

<div id="maincontent">
    <?php $this->renderPartial('_formReply', array('productPricingRequest' => $productPricingRequest,)); ?>
</div>