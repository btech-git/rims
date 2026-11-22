<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 3% }
    .width1-2 { width: 15% }
    .width1-3 { width: 7% }
    .width1-4 { width: 10% }
    .width1-5 { width: 45% }
    .width1-6 { width: 10% }
    .width1-7 { width: 10% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Raperind Motor</div>
    <div style="font-size: larger">Laporan Transaksi Sub Pekerjaan Luar <?php echo CHtml::encode(CHtml::value($supplier, 'name')); ?></div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<div class="clear"></div>

<?php echo CHtml::beginForm('', 'get'); ?>
    <div class="row buttons">
        <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcelDetail')); ?>
    </div>
<?php echo CHtml::endForm(); ?>

<br />

<div class="tab reportTab">
    <div class="tabHead"><span style="float: right"><?php //echo ReportHelper::summaryText($dataProvider); ?></span></div>
    
    <br /><br />
    
    <div class="tabBody">
        <table class="report">
            <thead style="position: sticky; top: 0">
                <tr id="header1">
                    <th class="width1-1">No</th>
                    <th class="width1-2">Sub Pekerjaan #</th>
                    <th class="width1-3">Tanggal</th>
                    <th class="width1-4">RG #</th>
                    <th class="width1-5">Note</th>
                    <th class="width1-6">Status</th>
                    <th class="width1-7">Total</th>
                    <th class="width1-10">Pembayaran</th>
                    <th class="width1-11">Sisa</th>
                </tr>
            </thead>
            <tbody>
                <?php $grandTotal = '0.00'; ?>
                <?php $totalPayment = '0.00'; ?>
                <?php $totalRemaining = '0.00'; ?>
                
                <?php foreach ($workOrderExpenses as $i => $workOrderExpense): ?>
                    <?php $totalPrice = CHtml::value($workOrderExpense, 'grand_total'); ?>
                    <?php $paymentAmount = CHtml::value($workOrderExpense, 'total_payment'); ?>
                    <?php $paymentRemaining = CHtml::value($workOrderExpense, 'payment_remaining'); ?>
                
                    <tr class="items1">
                        <td class="width1-1"><?php echo ++$i; ?></td>
                        <td class="width1-2">
                            <?php echo CHtml::link(CHtml::value($workOrderExpense, 'transaction_number'), array(
                                "/accounting/workOrderExpense/show", 
                                "id"=>$workOrderExpense->id,
                            ), array("target" => "_blank")); ?>
                        </td>
                        <td class="width1-3"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($workOrderExpense->transaction_date))); ?></td>
                        <td class="width1-4"><?php echo CHtml::encode(CHtml::value($workOrderExpense, 'registrationTransaction.transaction_number')); ?></td>
                        <td class="width1-5"><?php echo CHtml::encode(CHtml::value($workOrderExpense, 'note')); ?></td>
                        <td class="width1-6"><?php echo CHtml::encode(CHtml::value($workOrderExpense, 'status')); ?></td>
                        <td class="width1-7 " style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalPrice)); ?>
                        </td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $paymentAmount)); ?>
                        </td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $paymentRemaining)); ?>
                        </td>
                    </tr>
                    
                    <?php $grandTotal += $totalPrice; ?>
                    <?php $totalPayment += $paymentAmount; ?>
                    <?php $totalRemaining += $paymentRemaining; ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" style="text-align: right; font-weight: bold">TOTAL</td>
                    <td style="text-align: right; font-weight: bold">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $grandTotal)); ?>
                    </td>
                    <td style="text-align: right; font-weight: bold">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalPayment)); ?>
                    </td>
                    <td style="text-align: right; font-weight: bold">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalRemaining)); ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>