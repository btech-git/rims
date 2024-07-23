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
    'saleOrder' => $saleOrder,
    'saleOrderDataProvider' => $saleOrderDataProvider,
    'retailTransactionHead' => $retailTransactionHead,
    'retailTransactionHeadDataProvider' => $retailTransactionHeadDataProvider,
    'retailTransaction1' => $retailTransaction1,
    'retailTransaction1DataProvider' => $retailTransaction1DataProvider,
    'retailTransaction2' => $retailTransaction2,
    'retailTransaction2DataProvider' => $retailTransaction2DataProvider,
    'retailTransaction4' => $retailTransaction4,
    'retailTransaction4DataProvider' => $retailTransaction4DataProvider,
    'retailTransaction5' => $retailTransaction5,
    'retailTransaction5DataProvider' => $retailTransaction5DataProvider,
    'retailTransaction6' => $retailTransaction6,
    'retailTransaction6DataProvider' => $retailTransaction6DataProvider,
    'retailTransaction8' => $retailTransaction8,
    'retailTransaction8DataProvider' => $retailTransaction8DataProvider,
    'wholesaleTransaction' => $wholesaleTransaction,
    'wholesaleTransactionDataProvider' => $wholesaleTransactionDataProvider,
    'purchaseOrder' => $purchaseOrder,
    'purchaseOrderDataProvider' => $purchaseOrderDataProvider,
    'transactionJournal' => $transactionJournal,
    'transactionJournalDataProvider' => $transactionJournalDataProvider,
    'cashDailySummary' => $cashDailySummary,
    'branches' => $branches,
)); ?>