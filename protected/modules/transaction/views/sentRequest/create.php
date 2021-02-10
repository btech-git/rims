<?php $this->breadcrumbs = array(
    'Sent Request'=>array('admin'),
    'Create',
); ?>

<h1>Transfer Request</h1>

<div id="maincontent">
<?php echo $this->renderPartial('_form', array(
    'sentRequest' => $sentRequest,
    'product' => $product,
    'productDataProvider' => $productDataProvider,     
));?>
</div>
