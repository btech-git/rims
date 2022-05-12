<table>
    <thead>
        <tr>
            <th style="text-align: center">No</th>
            <th style="text-align: center">Transaction #</th>
            <th style="text-align: center">Branch</th>
            <th style="text-align: center">Debit</th>
            <th style="text-align: center">Credit</th>
            <th style="text-align: center">Keterangan</th>
        </tr>
    </thead>
    
    <tbody>
        <?php $totalDebit = 0.00; $totalCredit = 0.00; ?>
        <?php foreach ($transactionJournalDataProvider->data as $i => $header): ?>
            <?php 
            $debitAmount = $header->debet_kredit === 'D' ? $header->total : 0; 
            $creditAmount = $header->debet_kredit === 'K' ? $header->total : 0; 
            ?>
            <tr>
                <td><?php echo CHtml::encode($i + 1); ?></td>
                <td>
                    <?php /*echo CHtml::link($header->sale_order_no, array('javascript:;'), array(
                        'onclick' => 'window.open("' . CController::createUrl('/accounting/cashDailySummary/redirectTransaction', array(
                            "codeNumber" => $header->sale_order_no
                        )) . '", "_blank", "top=100, left=225, width=900, height=650"); return false;'
                    ));*/ ?>
                    <?php echo CHtml::encode(CHtml::value($header, 'kode_transaksi')); ?>
                </td>
                <td style="text-align: right">
                    <?php echo CHtml::encode(CHtml::value($header, 'branch.name')); ?>
                </td>
                <td style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $debitAmount)); ?>
                </td>
                <td style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $creditAmount)); ?>
                </td>
                <td style="text-align: right">
                    <?php echo CHtml::encode(CHtml::value($header, 'transaction_subject')); ?>
                </td>
            </tr>
            <?php 
            $totalDebit += $debitAmount;
            $totalCredit += $creditAmount; 
            ?>
        <?php endforeach; ?>
    </tbody>
    
    <tfoot>
        <tr>
            <td style="text-align: right" colspan="3">TOTAL</td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalDebit)); ?></td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalCredit)); ?></td>
            <td>&nbsp;</td>
        </tr>
    </tfoot>
</table>