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
//    'cashDailySummary' => $cashDailySummary,
//    'paymentTypes' => $paymentTypes,
//    'pageNumber' => $pageNumber,
//    'branch' => $branch,
//    'branchDataProvider' => $branchDataProvider,
//    'paymentInRetail' => $paymentInRetail,
    'paymentInRetailDataProvider' => $paymentInRetailDataProvider,
    'paymentInWholesale' => $paymentInWholesale,
    'paymentInWholesaleDataProvider' => $paymentInWholesaleDataProvider,
    'paymentOut' => $paymentOut,
    'paymentOutDataProvider' => $paymentOutDataProvider,
    'cashTransaction' => $cashTransaction,
    'cashTransactionDataProvider' => $cashTransactionDataProvider,
    'branchId' => $branchId,
    'transactionDate' => $transactionDate,
)); ?>