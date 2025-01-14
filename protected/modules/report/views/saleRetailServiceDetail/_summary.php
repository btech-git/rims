<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 15% }
    .width1-2 { width: 20% }
    .width1-3 { width: 20% }
    .width1-4 { width: 40% }

    .width2-1 { width: 15% }
    .width2-2 { width: 10% }
    .width2-3 { width: 20% }
    .width2-4 { width: 15% }
    .width2-5 { width: 15% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Penjualan Retail Jasa Detail</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">Code</th>
            <th class="width1-2">Type</th>
            <th class="width1-3">Category</th>
            <th class="width1-4">Name</th>
        </tr>
        <tr id="header2">
            <td colspan="4">
                <table>
                    <tr>
                        <th class="width2-1">Penjualan #</th>
                        <th class="width2-2">Tanggal</th>
                        <th class="width2-3">Customer</th>
                        <th class="width2-4">Vehicle</th>
                        <th class="width2-5">Harga</th>
                    </tr>
                </table>
            </td>
        </tr>
    </thead>
    <tbody>
        <?php $grandTotalSale = 0.00; ?>
        <?php foreach ($saleRetailServiceSummary->dataProvider->data as $header): ?>
            <tr class="items1">
                <td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'code')); ?></td>
                <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'type')); ?></td>
                <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'category')); ?></td>
                <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'name')); ?></td>
            </tr>
            <tr class="items2">
                <td colspan="4">
                    <table>
                        <?php $saleRetailData = $header->getSaleRetailServiceDetailReport($startDate, $endDate, $branchId); ?>
                        <?php $totalSale = 0.00; ?>
                        <?php foreach ($saleRetailData as $saleRetailRow): ?>
                            <?php $total = $saleRetailRow['total_price']; ?>
                            <tr>
                                <td class="width2-1"><?php echo CHtml::encode($saleRetailRow['invoice_number']); ?></td>
                                <td class="width2-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($saleRetailRow['invoice_date']))); ?></td>
                                <td class="width2-3"><?php echo CHtml::encode($saleRetailRow['customer']); ?></td>
                                <td class="width2-4"><?php echo CHtml::encode($saleRetailRow['vehicle']); ?></td>
                                <td class="width2-5" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $total)); ?></td>
                            </tr>
                            <?php $totalSale += $total; ?>
                        <?php endforeach; ?>
                        <tr>
                            <td style="text-align: right; font-weight: bold" colspan="4">Total</td>
                            <td style="text-align: right; font-weight: bold" class="width2-5"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalSale)); ?></td>
                        </tr>
                        <?php $grandTotalSale += $totalSale; ?>
                    </table>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td style="text-align: right; font-weight: bold" colspan="3">Total</td>
            <td style="text-align: right; font-weight: bold" class="width1-4">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotalSale)); ?>
            </td>
        </tr>
    </tfoot>
</table>