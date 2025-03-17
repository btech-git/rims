<?php $this->breadcrumbs = array(
    'Payment Out'=>array('admin'),
    'Create',
); ?>

<h1>Payment Out</h1>

<?php echo $this->renderPartial('_form', array(
    'paymentOut' => $paymentOut,
    'supplier' => $supplier,
    'receiveItem' => $receiveItem,
    'receiveItemDataProvider' => $receiveItemDataProvider,
    'workOrderExpense' => $workOrderExpense,
    'workOrderExpenseDataProvider' => $workOrderExpenseDataProvider,
    'itemRequestHeader' => $itemRequestHeader,
    'itemRequestDataProvider' => $itemRequestDataProvider,
    'movementType' => $movementType,
)); ?>

