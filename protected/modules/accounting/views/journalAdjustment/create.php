<?php
$this->breadcrumbs=array(
    'Jurnal Penyesuaian'=>array('admin'),
    'Create',
);
?>

<div id="maincontent">
    <?php $this->renderPartial('_form', array(
        'journalVoucher' => $journalVoucher,
        'account' => $account,
        'dataProvider' => $dataProvider,
    )); ?>
</div>
