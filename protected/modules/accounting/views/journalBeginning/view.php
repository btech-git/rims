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

        <?php echo CHtml::link('<span class="fa fa-th-list"></span>Manage', Yii::app()->baseUrl . '/accounting/journalBeginning/admin', array(
            'class' => 'button cbutton right', 
            'style' => 'margin-right:10px', 
        )); ?>

        <?php if ($journalBeginning->status == "Draft" && Yii::app()->user->checkAccess("adjustmentJournalApproval")): ?>
            <?php echo CHtml::link('<span class="fa fa-check"></span>Approval', Yii::app()->baseUrl . '/accounting/journalBeginning/updateApproval?headerId=' . $journalBeginning->id, array(
                'class' => 'button success right', 
                'style' => 'margin-right:10px',
            )); ?>
        <?php elseif ($journalBeginning->status != "Draft" && Yii::app()->user->checkAccess("adjustmentJournalSupervisor")): ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Update Approval', Yii::app()->baseUrl . '/accounting/journalBeginning/updateApproval?headerId=' . $journalBeginning->id, array(
                'class' => 'button success right', 
                'style' => 'margin-right:10px',
            )); ?>
        <?php endif; ?>

        <h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $journalBeginning,
            'attributes' => array(
                array(
                    'label' => 'Jurnal #',
                    'value' => $journalBeginning->transaction_number,
                ),
                array(
                    'label' => 'Tanggal',
                    'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $journalBeginning->transaction_date),
                ),
                array(
                    'label' => 'Branch',
                    'value' => CHtml::encode(CHtml::value($journalBeginning, 'branch.name')),
                ),
                array(
                    'label' => 'Catatan',
                    'value' => CHtml::encode(CHtml::value($journalBeginning, 'note')),
                ),
                array(
                    'label' => 'Status',
                    'value' => CHtml::encode(CHtml::value($journalBeginning, 'status')),
                ),
                array(
                    'label' => 'User Create',
                    'value' => CHtml::encode(CHtml::value($journalBeginning, 'userIdCreated.username')),
                ),
                array(
                    'label' => 'Tanggal Create',
                    'value' => Yii::app()->dateFormatter->format("d MMMM yyyy HH:mm:ss", $journalBeginning->created_datetime),
                ),
                array(
                    'label' => 'User Update',
                    'value' => CHtml::encode(CHtml::value($journalBeginning, 'userIdUpdated.username')),
                ),
                array(
                    'label' => 'Tanggal Update',
                    'value' => Yii::app()->dateFormatter->format("d MMMM yyyy HH:mm:ss", $journalBeginning->updated_datetime),
                ),
                array(
                    'label' => 'User Cancel',
                    'value' => CHtml::encode(CHtml::value($journalBeginning, 'userIdCancelled.username')),
                ),
                array(
                    'label' => 'Tanggal Cancel',
                    'value' => Yii::app()->dateFormatter->format("d MMMM yyyy HH:mm:ss", $journalBeginning->cancelled_datetime),
                ),
            ),
        )); ?>

        <hr />
        
        <div>
            <table>
                <thead>
                    <tr>
                        <th>COA Code</th>
                        <th>COA Name</th>
                        <th>Saldo Sekarang</th>
                        <th>Saldo Penyesuaian</th>
                        <th>Saldo Selisih</th>
                        <th>Memo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($journalBeginning->journalBeginningDetails as $detail): ?>
                        <tr>
                            <td><?php echo CHtml::encode(CHtml::value($detail, 'coa.code')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($detail, 'coa.name')); ?></td>
                            <td style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'current_balance'))); ?>
                            </td>
                            <td style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'adjustment_balance'))); ?>
                            </td>
                            <td style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'difference_balance'))); ?>
                            </td>
                            <td><?php echo CHtml::encode(CHtml::value($detail, 'memo')); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php $transactions = JurnalUmum::model()->findAllByAttributes(array(
            'kode_transaksi' => $journalBeginning->transaction_number, 
            'is_coa_category' => 0
        )); ?>
        <?php if (Yii::app()->user->checkAccess("director")): ?>
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
                                <td class="width1-6" style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $amountDebit)); ?>
                                </td>
                                <td class="width1-7" style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $amountCredit)); ?>
                                </td>
                            </tr>

                            <?php $totalDebit += $amountDebit; ?>
                            <?php $totalCredit += $amountCredit; ?>

                        <?php endforeach; ?>
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="3" style="text-align: right; font-weight: bold">TOTAL</td>
                            <td class="width1-6" style="text-align: right; font-weight: bold; border-top: 1px solid">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalDebit)); ?>
                            </td>
                            <td class="width1-7" style="text-align: right; font-weight: bold; border-top: 1px solid">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalCredit)); ?>
                            </td>
                        </tr>        
                    </tfoot>
                </table>
            </fieldset>
        <?php endif; ?>

        <br />

        <div class="field buttons text-center">
            <?php echo CHtml::beginForm(); ?>
            <?php echo CHtml::submitButton('Processing Journal', array(
                'name' => 'Process', 
                'confirm' => 'Are you sure you want to process into journal transactions?',
            )); ?>
            <?php echo CHtml::endForm(); ?>
        </div>
    </div>
</div>