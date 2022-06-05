<?php $this->breadcrumbs = array(
    'Payment Out'=>array('admin'),
    'Create',
); ?>

<h1> Sub Pekerjaan Luar</h1>

<?php echo $this->renderPartial('_form', array(
    'workOrderExpense' => $workOrderExpense,
    'supplierDataProvider' => $supplierDataProvider,
    'supplier' => $supplier,
    'registrationTransaction' => $registrationTransaction,
    'registrationTransactionDataProvider' => $registrationTransactionDataProvider,
    'customerName' => $customerName,
    'vehicleNumber' => $vehicleNumber,
)); ?>

