<?php
$this->breadcrumbs=array(
    'Jurnal Saldo Awal'=>array('admin'),
    'Create',
);
?>

<div id="maincontent">
    <?php $this->renderPartial('_form', array(
        'journalBeginning' => $journalBeginning,
        'account' => $account,
        'dataProvider' => $dataProvider,
    )); ?>
</div>
