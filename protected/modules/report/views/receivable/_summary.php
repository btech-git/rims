<?php Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 10% }
    .width1-3 { width: 10% }
    .width1-4 { width: 10% }
    .width1-5 { width: 10% }
    .width1-6 { width: 10% }
    .width1-7 { width: 10% }
    .width1-8 { width: 10% }
    .width1-9 { width: 10% }
    .width1-10 { width: 10% }
    
    .width2-1 { width: 10% }
    .width2-2 { width: 10% }
    .width2-3 { width: 10% }
    .width2-4 { width: 10% }
    .width2-5 { width: 10% }
'); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger"><?php echo Yii::app()->name; ?></div>
    <div style="font-size: larger">Laporan Piutang Customer</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1">Tanggal</th>
        <th class="width1-2">Jatuh Tempo</th>
        <th class="width1-3">Faktur #</th>
        <th class="width1-4">Customer</th>
        <th class="width1-5">Vehicle</th>
        <th class="width1-6">Branch</th>
        <th class="width1-7">Status</th>
        <th class="width1-8">Grand Total</th>
        <th class="width1-9">Payment</th>
        <th class="width1-10">Remaining</th>

    </tr>
    <tr id="header2">
        <td colspan="10">
            <table>
                <tr>
                    <th class="width2-1">Tanggal Bayar</th>
                    <th class="width2-2">Payment In #</th>
                    <th class="width2-3">Payment Type</th>
                    <th class="width2-4">Jumlah (Rp)</th>
                    <th class="width2-5">Notes</th>
                </tr>
            </table>
        </td>
    </tr>
    <?php foreach ($saleInvoiceSummary->dataProvider->data as $header): ?>
        <tr class="items1">
            <td class="width1-1"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->invoice_date))); ?></td>
            <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->due_date))); ?></td>
            <td class="width1-3"><?php echo CHtml::encode($header->invoice_number); ?></td>
            <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
            <td class="width1-5" style="text-align: right"><?php echo CHtml::encode(CHtml::value($header, 'vehicle.plate_number')); ?></td>
            <td class="width1-6" style="text-align: right"><?php echo CHtml::encode(CHtml::value($header, 'branch.name')); ?></td>
            <td class="width1-7" style="text-align: right"><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
            <td class="width1-8" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', ($header->total_price))); ?></td>
            <td class="width1-9" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', ($header->payment_amount))); ?></td>
            <td class="width1-10" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', ($header->payment_left))); ?></td>
        </tr>
        <tr class="items2">
            <td colspan="10">
                <table>
                    <?php foreach ($header->paymentIns as $detail): ?>
                        <tr>
                            <th class="width2-1"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($detail->payment_date))); ?></th>
                            <th class="width2-2"><?php echo CHtml::encode(CHtml::value($detail, 'payment_number')); ?></th>
                            <th class="width2-3"><?php echo CHtml::encode(CHtml::value($detail, 'paymentType.name')); ?></th>
                            <th class="width2-4"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', ($detail->payment_amount))); ?></th>
                            <th class="width2-5"><?php echo CHtml::encode(CHtml::value($detail, 'notes')); ?></th>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </td>
        </tr>
    <?php endforeach; ?>
    <tr id="header1">
        <td colspan="7" style="text-align: right">TOTAL</td>
        <td class="width1-8" style="text-align: right"> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $this->reportGrandTotal($saleInvoiceSummary->dataProvider))); ?></td>
        <td class="width1-9" style="text-align: right"> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $this->reportTotalPayment($saleInvoiceSummary->dataProvider))); ?></td>
        <td class="width1-10" style="text-align: right"> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $this->reportTotalRemaining($saleInvoiceSummary->dataProvider))); ?></td>
    </tr>        
</table>