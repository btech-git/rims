<?php $this->breadcrumbs = array(
    'Sent Request' => array('admin'),
    'Update',
); ?>

<h1>Update Transfer Request</h1>

<?php echo $this->renderPartial('_form', array(
    'sentRequest' => $sentRequest,
    'product' => $product,
    'productDataProvider' => $productDataProvider,    
)); ?>
