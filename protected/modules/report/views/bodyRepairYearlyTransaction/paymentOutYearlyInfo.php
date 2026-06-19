<style> 
 .table_wrapper{
    display: block;
    overflow-x: auto;
    white-space: nowrap;
}
</style>

<?php echo CHtml::beginForm(array(''), 'get'); ?>
                    
<div class="row buttons">
    <?php /*echo CHtml::hiddenField('coaId', $coaId); ?>
    <?php echo CHtml::hiddenField('debitCredit', $debitCredit); ?>
    <?php echo CHtml::hiddenField('date', $date); ?>
    <?php echo CHtml::hiddenField('branchId', $branchId); ?>
    <?php echo CHtml::hiddenField('inOut', $inOut); ?>
    <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveToExcel'));*/ ?>
</div>

<?php echo CHtml::endForm(); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Raperind Motor</div>
    <div style="font-size: larger">Transaksi Body Repair</div>
    <div><?php echo CHtml::encode($year); ?></div>
</div>

<hr />

<div class="tab reportTab">
    <div class="table_wrapper">
        <table class="responsive">
            <thead style="position: sticky; top: 0">
                <tr id="header1">
                    <th></th>
                    <th>Payment #</th>
                    <th>Tanggal</th>
                    <th>Supplier</th>
                    <th>Note</th>
                    <th>Status</th>
                    <th>Memo</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php $runningNumber = 1; ?>
                <?php foreach ($paymentOutDetails as $detail): ?>
                    <tr class="items1">
                        <td><?php echo $runningNumber; ?></td>
                        <td>
                            <?php echo CHtml::link(CHtml::value($detail, 'paymentOut.payment_number'), Yii::app()->createUrl("accounting/payOut/show", array(
                                "id" => $detail->payment_out_id
                            )), array('target' => '_blank'));?>
                        </td>
                        <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime(CHtml::value($detail, 'paymentOut.payment_date')))); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($detail, 'paymentOut.supplier.name')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($detail, 'paymentOut.note')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($detail, 'paymentOut.status')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($detail, 'memo')); ?></td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'amount'))); ?>
                        </td>
                    </tr>
                    <?php $runningNumber++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>