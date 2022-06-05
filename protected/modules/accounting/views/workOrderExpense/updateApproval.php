<?php
/* @var $this TransaksiOrderPenjualanController */
/* @var $model TransaksiOrderPenjualan */

$this->breadcrumbs=array(
    'Payment Out'=>array('admOut'),
    $model->id,
);

$this->menu=array(
    array('label'=>'List Payment Out', 'url'=>array('admOut')),
    array('label'=>'Manage Payment Out', 'url'=>array('admOut')),
);
?>
<div id="maOutcontent">
    <?php echo $this->renderPartial('_Approval', array(
        'model'=>$model,
        'workOrderExpense' => $workOrderExpense,
        'historis'=>$historis
    )); ?>
</div>

