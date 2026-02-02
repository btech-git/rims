<?php Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 7% }
    .width1-3 { width: 8% }
    .width1-4 { width: 20% }
    .width1-5 { width: 10% }
    .width1-6 { width: 7% }
    .width1-7 { width: 10% }
    .width1-8 { width: 10% }
    .width1-9 { width: 10% }
    .width1-10 { width: 8% }

    .width2-1 { width: 15% }
    .width2-2 { width: 15% }
    .width2-3 { width: 15% }
    .width2-4 { width: 15% }
    .width2-5 { width: 15% }
    .width2-5 { width: 15% }
'); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Raperind Motor</div>
    <div style="font-size: larger">Laporan Faktur Penjualan</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th></th>
            <th class="width1-1">Faktur #</th>
            <th class="width1-2">Tanggal</th>
            <th class="width1-3">Jatuh Tempo</th>
            <th class="width1-4">Customer</th>
            <th class="width1-5">Asuransi</th>
            <th class="width1-6">Plat #</th>
            <th class="width1-7">Grand Total</th>
            <th class="width1-8">Payment</th>
            <th class="width1-9">Remaining</th>
            <th class="width1-10">Status</th>
        </tr>
        <tr id="header2">
            <td colspan="11">
                <table>
                    <tr>
                        <th class="width2-1">Payment in #</th>
                        <th class="width2-2">Tanggal</th>
                        <th class="width2-3">Jumlah</th>
                        <th class="width2-4">PPh 21</th>
                        <th class="width2-5">Total</th>
                        <th class="width2-6">Memo</th>
                    </tr>
                </table>
            </td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($saleInvoiceSummary->dataProvider->data as $i => $header): ?>
            <tr class="items1">
                <td><?php echo $i + 1; ?></td>
                <td class="width1-1">
                    <?php echo CHtml::link(CHtml::encode($header->invoice_number), array("/transaction/invoiceHeader/view", "id"=>$header->id), array("target" => "_blank")); ?>
                </td>
                <td class="width1-2">
                    <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->invoice_date))); ?>
                </td>
                <td class="width1-3">
                    <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->due_date))); ?>
                </td>
                <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'insuranceCompany.name')); ?></td>
                <td class="width1-6" style="text-align: right"><?php echo CHtml::encode($header->vehicle->plate_number); ?></td>
                <td class="width1-7" style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($header->total_price))); ?>
                </td>
                <td class="width1-8" style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($header->payment_amount))); ?>
                </td>
                <td class="width1-9" style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($header->payment_left))); ?>
                </td>
                <td class="width1-10" style="text-align: right"><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
            </tr>
            <tr class="items2">
                <td colspan="11">
                    <table>
                        <?php if (!empty($header->paymentInDetails )): ?>
                        <?php $totalPayment = 0; ?>
                            <?php foreach ($header->paymentInDetails as $paymentInDetail): ?>
                                <?php $amount = CHtml::value($paymentInDetail, 'amount'); ?>
                                <?php $total = CHtml::value($paymentInDetail, 'totalAmount'); ?>
                                <tr>
                                    <td class="width2-1">
                                        <?php echo CHtml::link(CHtml::encode($paymentInDetail->paymentIn->payment_number), array("/transaction/paymentIn/view", "id"=>$paymentInDetail->paymentIn->id), array("target" => "_blank")); ?>
                                    </td>
                                    <td class="width2-2">
                                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($paymentInDetail->paymentIn->payment_date))); ?>
                                    </td>
                                    <td class="width2-3" style="text-align: right">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $amount)); ?>
                                    </td>
                                    <td class="width2-4" style="text-align: right">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $paymentInDetail->tax_service_amount)); ?>
                                    </td>
                                    <td class="width2-4" style="text-align: right">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $total)); ?>
                                    </td>
                                    <td class="width2-5"><?php echo CHtml::encode(CHtml::value($paymentInDetail, 'memo')); ?></td>
                                </tr>
                                <?php $totalPayment += $total; ?>
                            <?php endforeach; ?>
                            <tr>
                                <td style="text-align: right; font-weight: bold" colspan="4">Total</td>
                                <td style="text-align: right; font-weight: bold">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPayment)); ?>
                                </td>
                                <td></td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr id="header1">
            <td colspan="7" style="text-align: right; font-weight: bold">TOTAL</td>
            <td class="width1-8" style="text-align: right; font-weight: bold"> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $this->reportGrandTotal($saleInvoiceSummary->dataProvider))); ?></td>
            <td class="width1-9" style="text-align: right; font-weight: bold"> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $this->reportTotalPayment($saleInvoiceSummary->dataProvider))); ?></td>
            <td class="width1-10" style="text-align: right; font-weight: bold"> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $this->reportTotalRemaining($saleInvoiceSummary->dataProvider))); ?></td>
            <td>&nbsp;</td>
        </tr>
    </tfoot>
</table>