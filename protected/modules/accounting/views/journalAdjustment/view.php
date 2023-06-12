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

        <?php if (Yii::app()->user->checkAccess("adjustmentJournalEdit")): //$journalVoucher->status != "Approved" && $journalVoucher->status != 'Rejected'): ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Edit', Yii::app()->baseUrl . '/accounting/journalAdjustment/update?id=' . $journalVoucher->id, array('class' => 'button cbutton right', 'style' => 'margin-right:10px', 'visible' => Yii::app()->user->checkAccess("transaction.cashTransaction.update"))) ?>
        <?php endif ?>
            <?php echo CHtml::link('<span class="fa fa-check-square-o"></span>Approval', Yii::app()->baseUrl . '/accounting/journalAdjustment/updateApproval?headerId=' . $journalVoucher->id, array('class' => 'button cbutton right', 'style' => 'margin-right:10px', 'visible' => Yii::app()->user->checkAccess("transaction.cashTransaction.updateApproval"))) ?>
        

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

        <br />

        <?php $transactions = JurnalUmum::model()->findAllByAttributes(array('kode_transaksi' => $journalVoucher->transaction_number, 'is_coa_category' => 0)); ?>
        <?php if (Yii::app()->user->checkAccess("accountingHead")): ?>
            <fieldset>
                <legend>Journal Transactions</legend>
                <table class="report">
                    <thead>
                        <tr id="header1">
                            <th style="width: 5%">No</th>
                            <th style="width: 15%">Kode COA</th>
                            <th>Nama COA</th>
                            <th style="width: 15%">Debit</th>
                            <th style="width: 15%">Kredit</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $totalDebit = 0; $totalCredit = 0; ?>
                        <?php foreach ($transactions as $i => $header): ?>

                            <?php $amountDebit = $header->debet_kredit == 'D' ? CHtml::value($header, 'total') : 0; ?>
                            <?php $amountCredit = $header->debet_kredit == 'K' ? CHtml::value($header, 'total') : 0; ?>

                            <tr>
                                <td style="text-align: center"><?php echo $i + 1; ?></td>
                                <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'branchAccountCode')); ?></td>
                                <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'branchAccountName')); ?></td>
                                <td class="width1-6" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $amountDebit)); ?></td>
                                <td class="width1-7" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $amountCredit)); ?></td>
                            </tr>

                            <?php $totalDebit += $amountDebit; ?>
                            <?php $totalCredit += $amountCredit; ?>

                        <?php endforeach; ?>
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="3" style="text-align: right; font-weight: bold">TOTAL</td>
                            <td class="width1-6" style="text-align: right; font-weight: bold; border-top: 1px solid"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalDebit)); ?></td>
                            <td class="width1-7" style="text-align: right; font-weight: bold; border-top: 1px solid"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalCredit)); ?></td>
                        </tr>        
                    </tfoot>
                </table>
            </fieldset>
        <?php endif; ?>

        <br />

        <?php //if ($journalVoucher->status === 'Approved'): ?>
            <div class="field buttons text-center">
                <?php echo CHtml::beginForm(); ?>
                <?php echo CHtml::submitButton('Processing Journal', array('name' => 'Process', 'confirm' => 'Are you sure you want to process into journal transactions?')); ?>
                <?php echo CHtml::endForm(); ?>
            </div>
        <?php //endif; ?>

    </div>
</div>