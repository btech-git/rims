<?php
/* @var $this TransaksiOrderPenjualanController */
/* @var $model TransaksiOrderPenjualan */

$this->breadcrumbs = array(
    'Jurnal Beginning' => array('admin'),
);
?>
<div id="maincontent">
    <?php echo $this->renderPartial('_Approval', array(
        'model' => $model,
        'journalBeginning' => $journalBeginning,
        'historis' => $historis,
        'userIdApproval' => $userIdApproval,
    )); ?>
</div>

