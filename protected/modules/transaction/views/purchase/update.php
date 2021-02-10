<?php
$this->breadcrumbs = array(
    'Purchase Order' => array('admin'),
    'Update',
);
?>

<h1>Pembelian Barang</h1>

<?php
echo $this->renderPartial('_form', array(
    'purchase' => $purchase,
    'product' => $product,
    'productDataProvider' => $productDataProvider,
    'supplier' => $supplier,
));
?>
