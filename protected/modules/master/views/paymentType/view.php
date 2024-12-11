<?php
/* @var $this PaymentTypeController */
/* @var $model PaymentType */

$this->breadcrumbs = array(
    'Payment Types' => array('index'),
    $model->name,
);

$this->menu = array(
    array('label' => 'List PaymentType', 'url' => array('index')),
    array('label' => 'Create PaymentType', 'url' => array('create')),
    array('label' => 'Update PaymentType', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete PaymentType', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage PaymentType', 'url' => array('admin')),
);
?>
<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl . '/master/paymentType/admin'; ?>"><span class="fa fa-th-list"></span>Manage Bank</a>
        <?php //if (Yii::app()->user->checkAccess("master.bank.update")) { ?>
            <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/' . $ccontroller . '/update', array('id' => $model->id)); ?>"><span class="fa fa-edit"></span>edit</a>
        <?php //} ?>

        <h1>View Payment Type #<?php echo $model->id; ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                'id',
                'name',
                array(
                    'label' => 'Biaya Potongan Bank',
                    'name' => 'bank_fee_amount',
                    'value' => $model->bank_fee_amount,
                ),
                array(
                    'label' => 'Jenis Potongan Bank',
                    'name' => 'bank_fee_type',
                    'value' => $model->bankFeeTypeConstant,
                ),
                'coa.name',
                'memo',
            ),
        )); ?>
    </div>
</div>
