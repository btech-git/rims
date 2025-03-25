<?php $this->breadcrumbs = array(
    'Purchase Payment'=>array('update'),
    'Update',
); ?>

<h1>Revisi Payment Out</h1>

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
//    'receiveItem' => $receiveItem,
//    'receiveItemDataProvider' => $receiveItemDataProvider,
)); ?>

