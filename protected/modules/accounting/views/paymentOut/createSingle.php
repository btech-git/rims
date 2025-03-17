<?php $this->breadcrumbs = array(
    'Payment Out'=>array('admin'),
    'Create',
); ?>

<h1>Payment Out</h1>

<?php echo $this->renderPartial('_formSingle', array(
    'paymentOut' => $paymentOut,
    'supplier' => $supplier,
    'receiveItem' => $receiveItem,
    'workOrderExpense' => $workOrderExpense,
    'itemRequestHeader' => $itemRequestHeader,
    'movementType' => $movementType,
)); 

