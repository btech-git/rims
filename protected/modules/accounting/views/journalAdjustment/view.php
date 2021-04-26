<?php
$this->breadcrumbs = array(
    'Journal Voucher' => array('admin'),
    'View',
);
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>

        <?php echo CHtml::link('<span class="fa fa-plus"></span>Create', Yii::app()->baseUrl . '/accounting/journalAdjustment/create', array('class' => 'button cbutton right', 'style' => 'margin-right:10px', 'visible' => Yii::app()->user->checkAccess("accounting.cashTransaction.admin"))) ?>
        <?php echo CHtml::link('<span class="fa fa-th-list"></span>Manage', Yii::app()->baseUrl . '/accounting/journalAdjustment/admin', array('class' => 'button cbutton right', 'style' => 'margin-right:10px', 'visible' => Yii::app()->user->checkAccess("accounting.cashTransaction.admin"))) ?>

        <?php if ($journalVoucher->status != "Approved" && $journalVoucher->status != 'Rejected'): ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Edit', Yii::app()->baseUrl . '/accounting/journalAdjustment/update?id=' . $journalVoucher->id, array('class' => 'button cbutton right', 'style' => 'margin-right:10px', 'visible' => Yii::app()->user->checkAccess("transaction.cashTransaction.update"))) ?>
            <?php echo CHtml::link('<span class="fa fa-check-square-o"></span>Approval', Yii::app()->baseUrl . '/accounting/journalAdjustment/updateApproval?headerId=' . $journalVoucher->id, array('class' => 'button cbutton right', 'style' => 'margin-right:10px', 'visible' => Yii::app()->user->checkAccess("transaction.cashTransaction.updateApproval"))) ?>
        <?php endif ?>
        
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $journalVoucher,
    'attributes' => array(
        array(
            'label' => 'Jurnal #',
            'value' => $journalVoucher->transaction_number,
        ),
        array(
            'label' => 'Tanggal',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $journalVoucher->date),
        ),
        array(
            'label' => 'Status',
            'value' => CHtml::encode(CHtml::value($journalVoucher, 'status')),
        ),
        array(
            'label' => 'Branch',
            'value' => CHtml::encode(CHtml::value($journalVoucher, 'branch.name')),
        ),
        array(
            'label' => 'User',
            'value' => CHtml::encode(CHtml::value($journalVoucher, 'user.username')),
        ),
        array(
            'label' => 'Catatan',
            'value' => CHtml::encode(CHtml::value($journalVoucher, 'note')),
        ),
    ),
)); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'journal-detail-grid',
    'dataProvider' => $detailsDataProvider,
    'columns' => array(
        'coa.code: Kode Akun',
        'coa.name: Nama Akun',
        array(
            'header' => 'Debit',
            'value' => 'number_format($data->debit, 2)',
            'htmlOptions' => array(
                'style' => 'text-align: right',
            ),
        ),
        array(
            'header' => 'Credit',
            'value' => 'number_format($data->credit, 2)',
            'htmlOptions' => array(
                'style' => 'text-align: right',
            ),
        ),
        'memo',
    ),
)); ?>

<div>
    <table>
        <tr>
            <td>Total Debit</td>
            <td><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($journalVoucher, 'totalDebit'))); ?></td>
        </tr>
        <tr>
            <td>Total Credit</td>
            <td><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($journalVoucher, 'totalCredit'))); ?></td>
        </tr>
    </table>
</div>
</div>
</div>