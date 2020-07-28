<?php
/* @var $this MovementOutHeaderController */
/* @var $model MovementOutHeader */

$this->breadcrumbs=array(
	'Movement Out Headers'=>array('admin'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List MovementOutHeader', 'url'=>array('index')),
	array('label'=>'Manage MovementOutHeader', 'url'=>array('admin')),
);*/
?>

<!--<h1>Create MovementOutHeader</h1>-->

<div id="maincontent">
	<?php $this->renderPartial('_form', array('movementOut'=>$movementOut,
			'deliveryOrder'=>$deliveryOrder,
			'deliveryOrderDataProvider'=>$deliveryOrderDataProvider,
			'deliveryOrderDetail'=>$deliveryOrderDetail,
			'deliveryOrderDetailDataProvider'=>$deliveryOrderDetailDataProvider,
			'returnOrder'=>$returnOrder,
			'returnOrderDataProvider'=>$returnOrderDataProvider,
			'returnOrderDetail'=>$returnOrderDetail,
			'returnOrderDetailDataProvider'=>$returnOrderDetailDataProvider,
			'registrationTransaction'=>$registrationTransaction,
			'registrationTransactionDataProvider'=>$registrationTransactionDataProvider,
			'registrationProduct'=>$registrationProduct,
			'registrationProductDataProvider'=>$registrationProductDataProvider,
			)); ?></div>