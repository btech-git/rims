<?php
/* @var $this RegistrationServiceController */
/* @var $salePackage RegistrationService */

$this->breadcrumbs=array(
	'Registration Services'=>array('admin'),
	$salePackage->header->id=>array('view','id'=>$salePackage->header->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List RegistrationService', 'url'=>array('index')),
	array('label'=>'Create RegistrationService', 'url'=>array('create')),
	array('label'=>'View RegistrationService', 'url'=>array('view', 'id'=>$salePackage->header->id)),
	array('label'=>'Manage RegistrationService', 'url'=>array('admin')),
);
?>

<h1>Update Paket Penjualan <?php echo $salePackage->header->id; ?></h1>

<?php echo $this->renderPartial('_form', array(
    'salePackage' => $salePackage,
    'product' => $product,
    'productDataProvider' => $productDataProvider,
    'service' => $service,
    'serviceDataProvider' => $serviceDataProvider,
)); ?>