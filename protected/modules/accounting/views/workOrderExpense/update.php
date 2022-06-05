<?php $this->breadcrumbs = array(
    'Purchase Payment'=>array('update'),
    'Update',
); ?>

<h1>Revisi Sub Pekerjaan Luar</h1>

<?php echo $this->renderPartial('_form', array(
    'workOrderExpense' => $workOrderExpense,
    'supplier' => $supplier,
    'registrationTransaction' => $registrationTransaction,
    'registrationTransactionDataProvider' => $registrationTransactionDataProvider,
    'customerName' => $customerName,
    'vehicleNumber' => $vehicleNumber,
)); ?>

