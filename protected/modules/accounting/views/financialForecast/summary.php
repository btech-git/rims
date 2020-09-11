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

<h1>Financial Forecast</h1>

<?php echo $this->renderPartial('_form', array(
    'transactionDate' => $transactionDate,
    'coaBank' => $coaBank,
    'coaBankDataProvider' => $coaBankDataProvider,
    'payableTransaction' => $payableTransaction,
    'payableTransactionDataProvider' => $payableTransactionDataProvider,
    'receivableTransaction' => $receivableTransaction,
    'receivableTransactionDataProvider' => $receivableTransactionDataProvider,
)); ?>