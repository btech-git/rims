<?php
/* @var $this RegistrationServiceController */
/* @var $model RegistrationService */

$this->breadcrumbs=array(
	'Cash Daily'=>array('admin'),
	'Create',
);

$this->menu=array(
//	array('label'=>'List RegistrationService', 'url'=>array('index')),
//	array('label'=>'Manage RegistrationService', 'url'=>array('admin')),
);
?>

<h1>Cash Daily Summary</h1>

<?php echo $this->renderPartial('_form', array(
    'paymentTypes' => $paymentTypes,
    'paymentInWholesale' => $paymentInWholesale,
    'paymentInWholesaleDataProvider' => $paymentInWholesaleDataProvider,
    'paymentOut' => $paymentOut,
    'paymentOutDataProvider' => $paymentOutDataProvider,
    'cashTransaction' => $cashTransaction,
    'cashTransactionInDataProvider' => $cashTransactionInDataProvider,
    'cashTransactionOutDataProvider' => $cashTransactionOutDataProvider,
    'branchId' => $branchId,
    'transactionDate' => $transactionDate,
    'paymentInRetailResultSet' => $paymentInRetailResultSet,
    'paymentInRetailList' => $paymentInRetailList,
    'existingDate' => $existingDate,
)); ?>