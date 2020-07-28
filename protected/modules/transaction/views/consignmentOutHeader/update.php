<?php
/* @var $this ConsignmentOutHeaderController */
/* @var $model ConsignmentOutHeader */

$this->breadcrumbs=array(
	'Consignment Out Headers'=>array('admin'),
	$consignmentOut->header->id=>array('view','id'=>$consignmentOut->header->id),
	'Update',
);

/*$this->menu=array(
	array('label'=>'List ConsignmentOutHeader', 'url'=>array('index')),
	array('label'=>'Create ConsignmentOutHeader', 'url'=>array('create')),
	array('label'=>'View ConsignmentOutHeader', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ConsignmentOutHeader', 'url'=>array('admin')),
);*/
?>

<!--<h1>Update ConsignmentOutHeader <?php echo $consignmentOut->header->id; ?></h1>-->

<div id="maincontent">
	<?php $this->renderPartial('_form', array(
		'consignmentOut'=>$consignmentOut,
		'customer'=>$customer,
		'customerDataProvider'=>$customerDataProvider,
		'product'=>$product,
		'productDataProvider'=>$productDataProvider,
	)); ?></div>