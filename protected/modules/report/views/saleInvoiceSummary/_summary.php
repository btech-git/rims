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
    .width2-6 { width: 15% }
'); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Raperind Motor</div>
    <div style="font-size: larger">Faktur Penjualan Summary</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<div class="table_wrapper">
    <table class="responsive">
        <thead style="position: sticky; top: 0">
            <tr id="header1">
                <th></th>
                <th class="width1-1">Faktur #</th>
                <th class="width1-2">Tanggal</th>
                <th class="width1-3">Jatuh Tempo</th>
                <th class="width1-4">Customer</th>
                <th class="width1-6">Plat #</th>
                <th class="width1-7">Total Parts</th>
                <th class="width1-7">Total Jasa</th>
                <th class="width1-7">PPn</th>
                <th class="width1-7">Grand Total</th>
                <th class="width1-8">Payment</th>
                <th class="width1-9">Remaining</th>
                <th class="width1-10">Status</th>
                <th class="width1-1">Payment in #</th>
                <th class="width1-2">Tanggal</th>
                <th class="width2-3">Jumlah</th>
                <th class="width2-4">PPh 21</th>
                <th class="width2-5">Diskon</th>
                <th class="width2-5">Biaya Bank</th>
                <th class="width2-5">Biaya Merimen</th>
                <th class="width2-5">DP</th>
                <th class="width2-5">OR</th>
                <th class="width2-5">Total</th>
                <th class="width2-6">Memo</th>
            </tr>
        </thead>
        <tbody>
            <?php $totalParts = '0.00'; ?>
            <?php $totalService = '0.00'; ?>
            <?php $totalTax = '0.00'; ?>
            <?php $totalInvoice = '0.00'; ?>
            <?php $totalPaymentAmount = '0.00'; ?>
            <?php $totalPaymentLeft = '0.00'; ?>
            <?php $totalPaymentSum = '0.00'; ?>

            <?php foreach ($saleInvoiceSummary->dataProvider->data as $i => $header): ?>
                <?php $partsAmount = CHtml::value($header, 'product_price'); ?>
                <?php $serviceAmount = CHtml::value($header, 'service_price'); ?>
                <?php $taxAmount = CHtml::value($header, 'ppn_total'); ?>
                <?php $invoiceAmount = CHtml::value($header, 'total_price'); ?>
                <?php $paymentAmount = CHtml::value($header, 'payment_amount'); ?>
                <?php $paymentLeft = CHtml::value($header, 'payment_left'); ?>
            
                <?php if (!empty($header->paymentInDetails)): ?>
                    <?php foreach ($header->paymentInDetails as $paymentInDetail): ?>
                        <?php $amount = CHtml::value($paymentInDetail, 'amount'); ?>
                        <?php $totalPayment = CHtml::value($paymentInDetail, 'totalAmount'); ?>

                        <tr class="items1">
                            <td><?php echo $i + 1; ?></td>
                            <td class="width1-1">
                                <?php echo CHtml::link(CHtml::encode($header->invoice_number), array(
                                    "/transaction/invoiceHeader/view", 
                                    "id"=>$header->id
                                ), array("target" => "_blank")); ?>
                            </td>
                            <td class="width1-2">
                                <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->invoice_date))); ?>
                            </td>
                            <td class="width1-3">
                                <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->due_date))); ?>
                            </td>
                            <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                            <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'vehicle.plate_number')); ?></td>
                            <td class="width1-7" style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $partsAmount)); ?>
                            </td>
                            <td class="width1-7" style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $serviceAmount)); ?>
                            </td>
                            <td class="width1-7" style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $taxAmount)); ?>
                            </td>
                            <td class="width1-7" style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $invoiceAmount)); ?>
                            </td>
                            <td class="width1-8" style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $paymentAmount)); ?>
                            </td>
                            <td class="width1-9" style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $paymentLeft)); ?>
                            </td>
                            <td class="width1-10" style="text-align: right"><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
                            <td class="width2-1">
                                <?php echo CHtml::link(CHtml::encode($paymentInDetail->paymentIn->payment_number), array(
                                    "/transaction/paymentIn/view", 
                                    "id"=>$paymentInDetail->paymentIn->id
                                ), array("target" => "_blank")); ?>
                            </td>
                            <td class="width2-2">
                                <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($paymentInDetail->paymentIn->payment_date))); ?>
                            </td>
                            <td class="width2-3" style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $amount)); ?>
                            </td>
                            <td class="width2-4" style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $paymentInDetail->tax_service_amount)); ?>
                            </td>
                            <td class="width2-4" style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $paymentInDetail->discount_amount)); ?>
                            </td>
                            <td class="width2-4" style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $paymentInDetail->bank_administration_fee)); ?>
                            </td>
                            <td class="width2-4" style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $paymentInDetail->merimen_fee)); ?>
                            </td>
                            <td class="width2-4" style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $paymentInDetail->downpayment_amount)); ?>
                            </td>
                            <td class="width2-4" style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $paymentInDetail->own_risk_amount)); ?>
                            </td>
                            <td class="width2-4" style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalPayment)); ?>
                            </td>
                            <td class="width2-5"><?php echo CHtml::encode(CHtml::value($paymentInDetail, 'memo')); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr class="items1">
                        <td><?php echo $i + 1; ?></td>
                        <td class="width1-1">
                            <?php echo CHtml::link(CHtml::encode($header->invoice_number), array(
                                "/transaction/invoiceHeader/view", 
                                "id"=>$header->id
                            ), array("target" => "_blank")); ?>
                        </td>
                        <td class="width1-2">
                            <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->invoice_date))); ?>
                        </td>
                        <td class="width1-3">
                            <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->due_date))); ?>
                        </td>
                        <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                        <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'vehicle.plate_number')); ?></td>
                        <td class="width1-7" style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $partsAmount)); ?>
                        </td>
                        <td class="width1-7" style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $serviceAmount)); ?>
                        </td>
                        <td class="width1-7" style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $taxAmount)); ?>
                        </td>
                        <td class="width1-7" style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $invoiceAmount)); ?>
                        </td>
                        <td class="width1-8" style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $paymentAmount)); ?>
                        </td>
                        <td class="width1-9" style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $paymentLeft)); ?>
                        </td>
                        <td class="width1-10" style="text-align: right"><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
                        <td colspan="11">&nbsp;</td>
                    </tr>
                <?php endif; ?>
                <?php $totalParts += $partsAmount; ?>
                <?php $totalService += $serviceAmount; ?>
                <?php $totalTax += $taxAmount; ?>
                <?php $totalInvoice += $invoiceAmount; ?>
                <?php $totalPaymentAmount += $paymentAmount; ?>
                <?php $totalPaymentLeft += $paymentLeft; ?>
                <?php $totalPaymentSum += $totalPayment; ?>

            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr id="header1">
                <td colspan="6" style="text-align: right; font-weight: bold">TOTAL</td>
                <td class="width1-8" style="text-align: right; font-weight: bold"> 
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalParts)); ?>
                </td>
                <td class="width1-8" style="text-align: right; font-weight: bold"> 
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalService)); ?>
                </td>
                <td class="width1-8" style="text-align: right; font-weight: bold"> 
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalTax)); ?>
                </td>
                <td class="width1-8" style="text-align: right; font-weight: bold"> 
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalInvoice)); ?>
                </td>
                <td class="width1-9" style="text-align: right; font-weight: bold"> 
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalPaymentAmount)); ?>
                </td>
                <td class="width1-10" style="text-align: right; font-weight: bold"> 
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalPaymentLeft)); ?>
                </td>
                <td colspan="11" style="text-align: right; font-weight: bold"> 
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalPaymentSum)); ?>
                </td>
                <td>&nbsp;</td>
            </tr>
        </tfoot>
    </table>
</div>