<?php
$this->breadcrumbs = array(
    'Transfer Request' => array('admin'),
    'Update',
);
?>

<h1>Update Transfer Request</h1>

<?php echo $this->renderPartial('_form', array(
    'transferRequest' => $transferRequest,
    'product' => $product,
    'productDataProvider' => $productDataProvider,    
)); ?>
