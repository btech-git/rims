<?php
/* @var $this TransaksiOrderPenjualanController */
/* @var $model TransaksiOrderPenjualan */

$this->breadcrumbs = array(
    'Material Request' => array('admin'),
    'Update Approval',
);

$this->menu = array(
    array('label' => 'List Material Request', 'url' => array('index')),
    array('label' => 'Manage Material Request', 'url' => array('admin')),
);
?>

<div id="maincontent">
    <?php echo $this->renderPartial('_Approval', array(
        'model' => $model,
        'maintenanceRequest' => $maintenanceRequest,
        'historis' => $historis,
    )); ?>
</div>

