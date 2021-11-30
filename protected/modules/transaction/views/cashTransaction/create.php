<?php
/* @var $this CashTransactionController */
/* @var $model CashTransaction */

$this->breadcrumbs = array(
    'Cash Transactions' => array('index'),
    'Create',
);
?>

<div id="maincontent">
    <?php $this->renderPartial('_form', array(
        'idempotent' => $idempotent,
        'cashTransaction' => $cashTransaction,
        'coaKas' => $coaKas,
        'coaKasDataProvider' => $coaKasDataProvider,
        'coaDetail' => $coaDetail,
        'coaDetailDataProvider' => $coaDetailDataProvider,
    )); ?>
</div>