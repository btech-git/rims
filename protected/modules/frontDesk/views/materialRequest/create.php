<?php $this->breadcrumbs = array(
    'Material Request'=>array('admin'),
    'Create',
); ?>

<h1>Permintaan Bahan</h1>

<div id="maincontent">
    <?php echo $this->renderPartial('_form', array(
        'materialRequest' => $materialRequest,
        'product' => $product,
        'productDataProvider' => $productDataProvider,     
    ));?>
</div>
