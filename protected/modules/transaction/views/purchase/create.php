<?php
	$this->breadcrumbs = array(
		'Purchase Order'=>array('admin'),
		'Create',
	);
?>

<h1>Pembelian Barang</h1>

<div id="maincontent">
<?php echo $this->renderPartial('_form', array(
            'purchase' => $purchase,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
            'supplier' => $supplier,         
            'supplierDataProvider' => $supplierDataProvider,      
));?>
</div>
