<?php Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 15% }
    .width1-2 { width: 10% }
    .width1-3 { width: 10% }
    .width1-4 { width: 20% }
    .width1-5 { width: 10% }
    .width1-6 { width: 10% }
    .width1-7 { width: 10% }
    .width1-8 { width: 10% }

    .width2-1 { width: 15% }
    .width2-2 { width: 15% }
    .width2-3 { width: 15% }
    .width2-4 { width: 15% }
'); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Raperind Motor</div>
    <div style="font-size: larger">Laporan Faktur Pembelian</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">Faktur #</th>
            <th class="width1-2">Tanggal</th>
            <th class="width1-3">Type</th>
            <th class="width1-4">Supplier</th>
            <th class="width1-5">Grand Total</th>
            <th class="width1-6">Payment</th>
            <th class="width1-7">Remaining</th>
            <th class="width1-8">Status</th>
        </tr>
        <tr id="header2">
            <td colspan="8">
                <table>
                    <tr>
                        <th class="width2-1">Payment out #</th>
                        <th class="width2-2">Tanggal</th>
                        <th class="width2-3">Jumlah</th>
                        <th class="width2-4">Memo</th>
                    </tr>
                </table>
            </td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($purchaseInvoiceSummary->dataProvider->data as $header): ?>
            <tr class="items1">
                <td class="width1-3"><?php echo CHtml::link(CHtml::encode($header->purchase_order_no), array("/transaction/transactionPurchaseOrder/view", "id"=>$header->id), array("target" => "_blank")); ?></td>
                <td class="width1-1"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->purchase_order_date))); ?></td>
                <td class="width1-2"><?php echo CHtml::encode($header->getPurchaseStatus($header->purchase_type)); ?></td>
                <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'supplier.company')); ?></td>
                <td class="width1-5" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($header->total_price))); ?></td>
                <td class="width1-6" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($header->payment_amount))); ?></td>
                <td class="width1-7" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($header->payment_left))); ?></td>
                <td class="width1-8"><?php echo CHtml::encode(CHtml::value($header, 'status_document')); ?></td>
            </tr>
            <tr class="items2">
                <td colspan="8">
                        <table>
                            <?php foreach ($header->transactionReceiveItems as $receiveItem): ?>
                                <?php $totalPayment = 0; ?>
                                <?php if (!empty($receiveItem->payOutDetails )): ?>
                                    <?php foreach ($receiveItem->payOutDetails as $paymentOutDetail): ?>
                                        <?php $amount = CHtml::value($paymentOutDetail, 'amount'); ?>
                                        <tr>
                                            <td class="width2-1"><?php echo CHtml::link(CHtml::encode($paymentOutDetail->paymentOut->payment_number), array("/accounting/paymentOut/view", "id"=>$paymentOutDetail->paymentOut->id), array("target" => "_blank")); ?></td>
                                            <td class="width2-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($paymentOutDetail->paymentOut->payment_date))); ?></td>
                                            <td class="width2-3" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $amount)); ?></td>
                                            <td class="width2-5"><?php echo CHtml::encode(CHtml::value($paymentOutDetail, 'memo')); ?></td>
                                        </tr>
                                        <?php $totalPayment += $amount; ?>
                                    <?php endforeach; ?>
                                    <tr>
                                        <td style="text-align: right; font-weight: bold" colspan="2">Total Payment</td>
                                        <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPayment)); ?></td>
                                        <td></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </table>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr id="header1">
            <td colspan="4" style="text-align: right; font-weight: bold">TOTAL</td>
            <td class="width1-5" style="text-align: right; font-weight: bold"> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $this->reportGrandTotal($purchaseInvoiceSummary->dataProvider))); ?></td>
            <td class="width1-6" style="text-align: right; font-weight: bold"> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $this->reportTotalPayment($purchaseInvoiceSummary->dataProvider))); ?></td>
            <td class="width1-7" style="text-align: right; font-weight: bold"> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $this->reportTotalRemaining($purchaseInvoiceSummary->dataProvider))); ?></td>
            <td>&nbsp;</td>
        </tr>     
    </tfoot>
</table>