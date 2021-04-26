<?php
/* @var $this TransaksiOrderPenjualanController */
/* @var $model TransaksiOrderPenjualan */

$this->breadcrumbs = array(
    'Jurnal Adjustment' => array('admin'),
);
?>
<div id="maincontent">
    <?php echo $this->renderPartial('_Approval', array(
        'model' => $model,
        'journalVoucher' => $journalVoucher,
        'historis' => $historis
    )); ?>
</div>

