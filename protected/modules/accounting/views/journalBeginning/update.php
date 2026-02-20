<?php
$this->breadcrumbs = array(
    'Jurnal Umum' => array('admin'),
    'Update',
);
?>

<div id="maincontent">
    <?php $this->renderPartial('_form', array(
        'journalVoucher' => $journalVoucher,
        'account' => $account,
        'dataProvider' => $dataProvider,
    )); ?>
</div>