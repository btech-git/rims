
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
        <?php $transactions = JurnalUmum::model()->findAllByAttributes(array('kode_transaksi' => $model->purchase_order_no, 'is_coa_category' => 0)); ?>
        <?php foreach ($transactions as $i => $header): ?>
        
            <?php $amountDebit = $header->debet_kredit == 'D' ? CHtml::value($header, 'total') : 0; ?>
            <?php $amountCredit = $header->debet_kredit == 'K' ? CHtml::value($header, 'total') : 0; ?>
            
            <tr>
                <td style="text-align: center"><?php echo $i + 1; ?></td>
                <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'branchAccountCode')); ?></td>
                <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'branchAccountName')); ?></td>
                <td class="width1-6" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $amountDebit)); ?></td>
                <td class="width1-7" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $amountCredit)); ?></td>
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