<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 10% }
    .width1-3 { width: 25% }
    .width1-4 { width: 10% }
    .width1-5 { width: 10% }
    .width1-6 { width: 10% }
    .width1-7 { width: 10% }

    .width2-1 { width: 15% }
    .width2-2 { width: 10% }
    .width2-3 { width: 15% }
    .width2-4 { width: 15% }
    .width2-5 { width: 10% }
    .width2-6 { width: 15% }
    .width2-7 { width: 20% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">
        <?php $branch = Branch::model()->findByPk($branchId); ?>
        <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?>
    </div>
    <div style="font-size: larger">Laporan Payment In</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">Payment #</th>
            <th class="width1-2">Tanggal</th>
            <th class="width1-3">Customer</th>
            <th class="width1-4">Note</th>
            <th class="width1-5">Status</th>
            <th class="width1-6">Payment Type</th>
            <th class="width1-7">Admin</th>
        </tr>
        <tr id="header2">
            <td colspan="7">
                <table>
                    <tr>
                        <th class="width2-1">Invoice #</th>
                        <th class="width2-2">Tanggal</th>
                        <th class="width2-3">Kendaraan</th>
                        <th class="width2-4">Jumlah</th>
                        <th class="width2-5">Pph 23</th>
                        <th class="width2-6">Total</th>
                        <th class="width2-7">Memo</th>
                    </tr>
                </table>
            </td>
        </tr>
    </thead>
    <tbody>
        <?php $totalPayment = 0.00; ?>
        <?php foreach ($paymentInSummary->dataProvider->data as $header): ?>
            <?php $paymentAmount = CHtml::value($header, 'totalPayment'); ?>
            <tr class="items1">
                <td class="width1-1">
                    <?php echo CHtml::link(CHtml::encode($header->payment_number), array("/transaction/paymentIn/view", "id"=>$header->id), array("target" => "_blank")); ?>
                </td>
                <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->payment_date))); ?></td>
                <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'notes')); ?></td>
                <td class="width1-5"><?php echo CHtml::encode($header->status); ?></td>
                <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'paymentType.name')); ?></td>
                <td class="width1-7"><?php echo CHtml::encode(CHtml::value($header, 'user.username')); ?></td>
            </tr>
            <tr class="items2">
                <td colspan="7">
                    <table>
                        <?php foreach ($header->paymentInDetails as $detail): ?>
                            <tr>
                                <td class="width2-1"><?php echo CHtml::encode(CHtml::value($detail, 'invoiceHeader.invoice_number')); ?></td>
                                <td class="width2-2">
                                    <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($detail->invoiceHeader->invoice_date))); ?>
                                </td>
                                <td class="width2-3"><?php echo CHtml::encode(CHtml::value($detail, 'invoiceHeader.vehicle.plate_number')); ?></td>
                                <td class="width2-4" style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'amount'))); ?>
                                </td>
                                <td class="width2-5" style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'tax_service_amount'))); ?>
                                </td>
                                <td class="width2-6" style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'totalAmount'))); ?>
                                </td>
                                <td class="width2-7" style="text-align: right"><?php echo CHtml::encode(CHtml::value($detail, 'memo')); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="5" style="text-align: right; font-weight: bold">TOTAL: </td>
                            <td style="text-align: right; font-weight: bold">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $paymentAmount)); ?>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <?php $totalPayment += $paymentAmount; ?>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td style="text-align: right" colspan="6">Total</td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPayment)); ?></td>
        </tr>
    </tfoot>
</table>