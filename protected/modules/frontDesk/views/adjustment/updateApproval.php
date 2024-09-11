<?php
/* @var $this TransaksiOrderPenjualanController */
/* @var $model TransaksiOrderPenjualan */

$this->breadcrumbs=array(
    'Stock Adjustmnet'=>array('admin'),
    'Update Approval',
);

$this->menu=array(
    array('label'=>'List Stock Adjustment', 'url'=>array('index')),
    array('label'=>'Manage Stock Adjustment', 'url'=>array('admin')),
);
?>
<div id="maincontent">
    <?php echo $this->renderPartial('_approval', array(
        'model'=>$model,
        'historis'=>$historis,
        'stockAdjustmentHeader' => $stockAdjustmentHeader,
    )); ?>
</div>

