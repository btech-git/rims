<?php
/* @var $this CashTransactionController */
/* @var $model CashTransaction */

$this->breadcrumbs = array(
    'Cash Transactions' => array('index'),
    'Create',
);

/*$this->menu=array(
	array('label'=>'List CashTransaction', 'url'=>array('index')),
	array('label'=>'Manage CashTransaction', 'url'=>array('admin')),
);*/
?>

<!--<h1>Create CashTransaction</h1>-->

<div id="maincontent">
    <?php $this->renderPartial('_form', array(
        'cashTransaction' => $cashTransaction,
        //'model'=>$model,
        'coaKas' => $coaKas,
        'coaKasDataProvider' => $coaKasDataProvider,
        'coaDetail' => $coaDetail,
        'coaDetailDataProvider' => $coaDetailDataProvider,
    )); ?></div>