<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 45% }
    .width1-2 { width: 15% }
    .width1-3 { width: 15% }
    .width1-4 { width: 25% }

    .width2-1 { width: 10% }
    .width2-2 { width: 10% }
    .width2-3 { width: 10% }
    .width2-4 { width: 25% }
    .width2-5 { width: 5% }
    .width2-6 { width: 10% }
    .width2-7 { width: 10% }
    .width2-8 { width: 10% }
    .width2-9 { width: 10% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Penjualan Project <?php echo CHtml::encode(CHtml::value($customerData, 'name')); ?></div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">Customer</th>
            <th class="width1-2">Email</th>
            <th class="width1-3">Phone</th>
            <th class="width1-4">COA</th>
        </tr>
        <tr id="header2">
            <td colspan="4">
                <table>
                    <tr>
                        <th class="width2-1">Penjualan #</th>
                        <th class="width2-2">Tanggal</th>
                        <th class="width2-3">Vehicle</th>
                        <th class="width2-4">Nama Parts/Jasa</th>
                        <th class="width2-5">Quantity</th>
                        <th class="width2-6">Harga</th>
                        <th class="width2-7">HPP</th>
                        <th class="width2-8">Profit</th>
                        <th class="width2-9">Total</th>
                    </tr>
                </table>
            </td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($saleRetailSummary->dataProvider->data as $header): ?>
            <tr class="items1">
                <td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'name')); ?></td>
                <td class="width1-2"><?php echo CHtml::encode($header->email); ?></td>
                <td class="width1-3"><?php echo CHtml::encode($header->mobile_phone); ?></td>
                <td class="width1-4"><?php echo CHtml::encode($header->coa->name); ?></td>
            </tr>
            <tr class="items2">
                <td colspan="4">
                    <table>
                        <?php $totalSale = 0.00; ?>
                        <?php $saleReportData = $header->getSaleByProjectReport($startDate, $endDate, $branchId); ?>
                        <?php if (!empty($saleReportData)): ?>
                            <?php foreach ($saleReportData as $saleReportRow): ?>
                                <?php $unitPrice = $saleReportRow['unit_price']; ?>
                                <?php $cogs = $saleReportRow['hpp']; ?>
                                <?php $profit = $unitPrice - $cogs; ?>
                                <?php $grandTotal = $saleReportRow['total_price']; ?>
                                <tr>
                                    <td class="width2-1">
                                        <?php echo CHtml::link($saleReportRow['invoice_number'], Yii::app()->createUrl("transaction/invoiceHeader/view", array("id" => $saleReportRow['id'])), array('target' => '_blank')); ?>
                                    </td>
                                    <td class="width2-2">
                                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($saleReportRow['invoice_date']))); ?>
                                    </td>
                                    <td class="width2-3">
                                        <?php echo CHtml::encode($saleReportRow['plate_number']); ?>
                                    </td>
                                    <td class="width2-4">
                                        <?php if (empty($saleReportRow['product'])): ?>
                                            <?php echo CHtml::encode($saleReportRow['service']); ?>
                                        <?php else: ?>
                                            <?php echo CHtml::encode($saleReportRow['product']); ?>
                                        <?php endif; ?>
                                    </td>
                                    <td class="width2-5" style="text-align: center">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saleReportRow['quantity'])); ?>
                                    </td>
                                    <td class="width2-6" style="text-align: right">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $unitPrice)); ?>
                                    </td>
                                    <td class="width2-7" style="text-align: right">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $cogs)); ?>
                                    </td>
                                    <td class="width2-8" style="text-align: right">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $profit)); ?>
                                    </td>
                                    <td class="width2-9" style="text-align: right">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotal)); ?>
                                    </td>
                                </tr>
                                <?php $totalSale += $grandTotal; ?>
                            <?php endforeach; ?>
                            <tr>
                                <td style="text-align: right" colspan="8">Total</td>
                                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalSale)); ?></td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>