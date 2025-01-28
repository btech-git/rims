<?php $this->breadcrumbs = array(
    'Item Request'=>array('admin'),
    'Create',
); ?>

<h1>Permintaan Barang non-stock</h1>

<div id="maincontent">
    <?php echo $this->renderPartial('_form', array(
        'itemRequest' => $itemRequest,
    ));?>
</div>
