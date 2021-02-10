<?php
	$this->breadcrumbs = array(
		'Transfer Request'=>array('admin'),
		'Create',
	);
?>

<h1>Transfer Request</h1>

<div id="maincontent">
<?php echo $this->renderPartial('_form', array(
    'transferRequest' => $transferRequest,
    'product' => $product,
    'productDataProvider' => $productDataProvider,     
));?>
</div>
