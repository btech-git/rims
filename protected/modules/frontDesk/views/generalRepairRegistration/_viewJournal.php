
<table class="report">
    <thead>
        <tr id="header1">
            <th class="width1-1">No</th>
            <th class="width1-4">Kode COA</th>
            <th class="width1-5">Nama COA</th>
            <th class="width1-6">Debit</th>
            <th class="width1-7">Kredit</th>
        </tr>
    </thead>
    
    <tbody>
        <?php $totalDebit = 0; $totalCredit = 0; ?>
        <?php $transactions = JurnalUmum::model()->findAllByAttributes(array('kode_transaksi' => $model->transaction_number, 'is_coa_category' => 0)); ?>
        <?php foreach ($transactions as $i => $header): ?>
                <?php //$totalTransaction = count($transactions); ?>
        
<!--                <tr class="items1">
                    <td class="width1-1" style="text-align: center"><?php /*echo CHtml::encode($nomor); ?></td>
                    <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->tanggal_transaksi))); ?></td>
                    <td class="width1-3"><?php echo CHtml::link($header->kode_transaksi, Yii::app()->createUrl("accounting/jurnalUmum/redirectTransaction", array("codeNumber" => $header->kode_transaksi)), array('target' => '_blank')); ?></td>
                    <td colspan="2" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'transaction_subject')); ?></td>
                    <td colspan="2">&nbsp;</td>
                    <?php $nomor++;*/ ?>
                </tr>-->
                
            <?php $amountDebit = $header->debet_kredit == 'D' ? CHtml::value($header, 'total') : 0; ?>
            <?php $amountCredit = $header->debet_kredit == 'K' ? CHtml::value($header, 'total') : 0; ?>
            
            <tr>
                <td><?php echo $i + 1; ?></td>
                <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'branchAccountCode')); ?></td>
                <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'branchAccountName')); ?></td>
                <td class="width1-6" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $amountDebit)); ?></td>
                <td class="width1-7" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $amountCredit)); ?></td>
            </tr>
            
            <?php $totalDebit += $amountDebit; ?>
            <?php $totalCredit += $amountCredit; ?>
            
            <?php //if ($index == $totalTransaction): ?>
            <?php //endif; ?>
                
            <?php //$index++; ?>
            <?php //$lastId = $header->kode_transaksi; ?>
        <?php endforeach; ?>
        <tr>
            <td colspan="3" style="text-align: right; font-weight: bold">TOTAL</td>
            <td class="width1-6" style="text-align: right; font-weight: bold; border-top: 1px solid"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalDebit)); ?></td>
            <td class="width1-7" style="text-align: right; font-weight: bold; border-top: 1px solid"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalCredit)); ?></td>
        </tr>
    </tbody>
    
    <tfoot>
        <tr>
            <td></td>
        </tr>
        
        <tr>
            <td></td>
        </tr>
        
    </tfoot>
</table>