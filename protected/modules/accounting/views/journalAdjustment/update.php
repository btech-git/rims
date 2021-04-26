<?php
/* @var $this JurnalPenyesuaianController */
/* @var $model JurnalPenyesuaian */

$this->breadcrumbs = array(
    'Jurnal Penyesuaian' => array('admin'),
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