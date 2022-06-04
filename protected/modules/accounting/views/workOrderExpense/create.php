<?php $this->breadcrumbs = array(
    'Payment Out'=>array('admin'),
    'Create',
); ?>

<h1>Invoice Upah</h1>

<?php echo $this->renderPartial('_form', array(
    'workOrderExpense' => $workOrderExpense,
    'coaDataProvider' => $coaDataProvider,
    'coa' => $coa,
    'supplierDataProvider' => $supplierDataProvider,
    'supplier' => $supplier,
)); ?>

