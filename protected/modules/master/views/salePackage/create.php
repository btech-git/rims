<?php
/* @var $this RegistrationServiceController */
/* @var $model RegistrationService */

$this->breadcrumbs=array(
	'Movement Out'=>array('admin'),
	'Create',
);

$this->menu=array(
//	array('label'=>'List RegistrationService', 'url'=>array('index')),
//	array('label'=>'Manage RegistrationService', 'url'=>array('admin')),
);
?>

<?php $this->renderPartial('_form', array(
    'salePackage' => $salePackage,
    'product' => $product,
    'productDataProvider' => $productDataProvider,
    'service' => $service,
    'serviceDataProvider' => $serviceDataProvider,
)); ?>