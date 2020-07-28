<?php
/* @var $this ConsignmentOutHeaderController */
/* @var $model ConsignmentOutHeader */

$this->breadcrumbs=array(
	'Consignment Out Headers'=>array('admin'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List ConsignmentOutHeader', 'url'=>array('index')),
	array('label'=>'Manage ConsignmentOutHeader', 'url'=>array('admin')),
);*/
?>

<!--<h1>Create ConsignmentOutHeader</h1>-->

<div id="maincontent">
	<?php $this->renderPartial('_form', array(
		'consignmentOut'=>$consignmentOut,
		'customer'=>$customer,
		'customerDataProvider'=>$customerDataProvider,
		'product'=>$product,
		'productDataProvider'=>$productDataProvider,
	)); ?></div>