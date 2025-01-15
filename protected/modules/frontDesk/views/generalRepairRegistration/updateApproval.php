<?php
/* @var $this TransaksiOrderPenjualanController */
/* @var $model TransaksiOrderPenjualan */

$this->breadcrumbs=array(
    'Registration Transactions'=>array('admin'),
    $registrationTransaction->id=>array('view','id'=>$registrationTransaction->id),
    'Update',
);

$this->menu=array(
    array('label'=>'List RegistrationTransaction', 'url'=>array('index')),
    array('label'=>'Create RegistrationTransaction', 'url'=>array('create')),
    array('label'=>'View RegistrationTransaction', 'url'=>array('view', 'id'=>$registrationTransaction->id)),
    array('label'=>'Manage RegistrationTransaction', 'url'=>array('admin')),
);
?>
<div id="maOutcontent">
    <?php echo $this->renderPartial('_Approval', array(
        'model' => $model,
        'registrationTransaction' => $registrationTransaction,
        'historis' => $historis
    )); ?>
</div>

