<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 7% }
    .width1-3 { width: 20% }
    .width1-4 { width: 15% }
    .width1-5 { width: 10% }
    .width1-6 { width: 8% }
    .width1-7 { width: 10% }
    .width1-8 { width: 10% }
    .width1-9 { width: 10% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">
        <?php $branch = Branch::model()->findByPk($branchId); ?>
        <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?>
    </div>
    <div style="font-size: larger">Laporan Penerimaan Penjualan</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">Payment #</th>
            <th class="width1-2">Tanggal</th>
            <th class="width1-3">Customer</th>
            <th class="width1-4">Asuransi</th>
            <th class="width1-5">Transaksi #</th>
            <th class="width1-6">Plat #</th>
            <th class="width1-7">DP</th>
            <th class="width1-8">Payment</th>
            <th class="width1-9">Invoice</th>
        </tr>
    </thead>
    <tbody>
        <?php $paymentAmount = '0.00'; ?>
        <?php $invoiceAmount = '0.00'; ?>
        <?php foreach ($paymentInSummary->dataProvider->data as $header): ?>
            <?php foreach ($header->paymentInDetails as $detail): ?>
                <?php $totalAmount = CHtml::value($detail, 'totalAmount'); ?>
                <?php $totalInvoice = CHtml::value($detail, 'total_invoice'); ?>
                <tr class="items1">
                    <td class="width1-1">
                        <?php echo CHtml::link(CHtml::encode($header->payment_number), array(
                            "/transaction/paymentIn/view", 
                            "id" => $header->id,
                        ), array("target" => "_blank")); ?>
                    </td>
                    <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->payment_date))); ?></td>
                    <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                    <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'insuranceCompany.name')); ?></td>
                    <?php if ($detail->invoice_header_id !== null): ?>
                        <td class="width1-5">
                            <?php echo CHtml::link(CHtml::encode(CHtml::value($detail, 'invoiceHeader.invoice_number')), array(
                                "/transaction/invoiceHeader/view", 
                                "id" => $detail->invoice_header_id
                            ), array("target" => "_blank")); ?>
                        </td>
                        <td class="width1-6"><?php echo CHtml::encode(CHtml::value($detail, 'invoiceHeader.vehicle.plate_number')); ?></td>
                    <?php else: ?>
                        <td class="width1-5">
                            <?php echo CHtml::link(CHtml::encode(CHtml::value($detail, 'registrationTransaction.transaction_number')), array(
                                "/frontDesk/registrationTransaction/view", 
                                "id" => $detail->registration_transaction_id
                            ), array("target" => "_blank")); ?>
                        </td>
                        <td class="width1-6"><?php echo CHtml::encode(CHtml::value($detail, 'registrationTransaction.vehicle.plate_number')); ?></td>
                    <?php endif; ?>
                    <td class="width1-7" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'downpayment_amount'))); ?>
                    </td>
                    <td class="width1-8" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalAmount)); ?>
                    </td>
                    <td class="width1-9" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalInvoice)); ?>
                    </td>
                </tr>
                <?php $paymentAmount += $totalAmount; ?>
                <?php $invoiceAmount += $totalInvoice; ?>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="7" style="text-align: right; font-weight: bold">TOTAL: </td>
            <td style="text-align: right; font-weight: bold">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $paymentAmount)); ?>
            </td>
            <td style="text-align: right; font-weight: bold">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $invoiceAmount)); ?>
            </td>
        </tr>
    </tfoot>
</table>