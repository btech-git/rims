<?php
/* @var $this BrandController */
/* @var $model Brand */

$this->breadcrumbs = array(
    'Product',
    'Brands' => array('admin'),
    'Create',
);
?>

<div id="maincontent">
    <?php $this->renderPartial('_form', array('idempotent' => $idempotent, 'model' => $model)); ?>
</div>