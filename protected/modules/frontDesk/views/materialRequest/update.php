<?php
$this->breadcrumbs = array(
    'Material Request' => array('admin'),
    'Update',
);
?>

<h1>Update Permintaan Bahan</h1>

<?php echo $this->renderPartial('_form', array(
    'materialRequest' => $materialRequest,
    'product' => $product,
    'productDataProvider' => $productDataProvider,    
)); ?>
