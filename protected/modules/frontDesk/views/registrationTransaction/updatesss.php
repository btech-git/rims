<?php
/* @var $this RegistrationTransactionController */
/* @var $registrationTransaction->header RegistrationTransaction */

$this->breadcrumbs=array(
	'Registration Transactions'=>array('admin'),
	$registrationTransaction->header->id=>array('view','id'=>$registrationTransaction->header->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List RegistrationTransaction', 'url'=>array('index')),
	array('label'=>'Create RegistrationTransaction', 'url'=>array('create')),
	array('label'=>'View RegistrationTransaction', 'url'=>array('view', 'id'=>$registrationTransaction->header->id)),
	array('label'=>'Manage RegistrationTransaction', 'url'=>array('admin')),
);
?>

<div id="maincontent">
	<?php echo $this->renderPartial('_form', array(
        'customer'=>$customer,
        'customerDataProvider'=>$customerDataProvider,
        'registrationTransaction'=>$registrationTransaction,
        'qs'=>$qs,
        'qsDataProvider'=>$qsDataProvider,
        'service'=>$service,
        'serviceDataProvider'=>$serviceDataProvider,
        'product'=>$product,
        'productDataProvider'=>$productDataProvider,
        'serviceArray'=>$serviceArray,
        'type'=>$type,
        'data'=>$data,
    )); ?>
</div>
	