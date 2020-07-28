<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

$this->breadcrumbs=array(
	'Registration Transactions'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List RegistrationTransaction', 'url'=>array('index')),
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
        'data'=>$data,
        'type'=>$type,
	)); ?>
</div>