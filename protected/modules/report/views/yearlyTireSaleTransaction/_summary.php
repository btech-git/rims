<?php $dateNumList = range(1, 31); ?>

<div style="font-weight: bold; text-align: center">
    <?php $branch = Branch::model()->findByPk($branchId); ?>
    <div style="font-size: larger">Raperind Motor <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?></div>
    <div style="font-size: larger">Penjualan Ban Tahunan</div>
    <div><?php echo 'Periode tahun: ' . CHtml::encode($year); ?></div>
</div>

<br />

<?php $maxMonthNum = (int) $year === (int) $yearNow ? $monthNow : 12; ?>

<div class="table_wrapper">
    <table class="responsive">
    <thead>
        <tr>
            <th>No.</th>
            <th>ID</th>
            <th>Code</th>
            <th>Name</th>
            <th>Size</th>
            <th>Brand</th>
            <th>Category</th>
            <?php for ($month = 1; $month <= 12; $month++): ?>
                <th><?php echo CHtml::encode($monthList[$month]); ?></th>
            <?php endfor; ?>
            <th>Total</th>
            <th style="text-align: center">Jual Rata2</th>
            <th style="text-align: center">Jual Min</th>
            <th style="text-align: center">Jual Max</th>
            <th style="text-align: center">Jual Median</th>
            <th style="text-align: center">Klasifikasi</th>
            <th style="text-align: center">Stock</th>
            <th style="text-align: center">Min</th>
            <th style="text-align: center">Target</th>
            <th style="text-align: center">Order Plan</th>
        </tr>
    </thead>
    <tbody>
            <?php $ordinal = 0; ?>
            <?php foreach ($yearlyTireSaleTransactionReportData as $productId => $yearlyTireSaleTransactionReportDataItem): ?>
            <tr>
                <td style="text-align: center"><?php echo ++$ordinal; ?></td>
                <td><?php echo $yearlyTireSaleTransactionReportDataItem['product_id']; ?></td>
                <td><?php echo $yearlyTireSaleTransactionReportDataItem['product_code']; ?></td>
                <td><?php echo $yearlyTireSaleTransactionReportDataItem['product_name']; ?></td>
                <td><?php echo $yearlyTireSaleTransactionReportDataItem['tire_name']; ?></td>
                <td>
                    <?php echo $yearlyTireSaleTransactionReportDataItem['brand_name']; ?> -
                    <?php echo $yearlyTireSaleTransactionReportDataItem['sub_brand_name']; ?> -
                    <?php echo $yearlyTireSaleTransactionReportDataItem['sub_brand_series_name']; ?>
                </td>
                <td>
                    <?php echo $yearlyTireSaleTransactionReportDataItem['master_category_name']; ?> -
                    <?php echo $yearlyTireSaleTransactionReportDataItem['sub_category_name']; ?> -
                    <?php echo $yearlyTireSaleTransactionReportDataItem['sub_master_category_name']; ?>
                </td>
                <?php $totalSum = 0; ?>
                <?php for ($month = 1; $month <= 12; $month++): ?>
                        <?php $invoiceTotal = isset($yearlyTireSaleTransactionReportDataItem['totals'][$month]) ? $yearlyTireSaleTransactionReportDataItem['totals'][$month] : '0.00'; ?>
                    <?php if ($month <= $maxMonthNum): ?>
                        <td style="text-align: right">
                            <?php echo CHtml::link(Yii::app()->numberFormatter->format('#,##0', $invoiceTotal), array(
                                '/report/yearlyTireSaleTransaction/transactionInfo', 
                                'productId' => $productId, 
                                'month' => $month, 
                                'year' => $year,
                                'branchId' => $branchId,
                            ), array('target' => '_blank')); ?>
                        </td>
                    <?php else: ?>
                        <td></td>
                    <?php endif; ?>
                    <?php $invoiceTotals[] = $invoiceTotal; ?>
                    <?php if (!isset($groupTotalSums[$month])): ?>
                        <?php $groupTotalSums[$month] = 0; ?>
                    <?php endif; ?>
                    <?php $groupTotalSums[$month] += $invoiceTotal; ?>
                <?php endfor; ?>
                <?php $invoiceTotalSum = array_sum($invoiceTotals); ?>
                <td style="text-align: right">
                    <?php echo CHtml::link(Yii::app()->numberFormatter->format('#,##0', $invoiceTotalSum), array(
                        '/report/yearlyTireSaleTransaction/transactionInfo', 
                        'productId' => $productId, 
                        'month' => $month, 
                        'year' => $year,
                        'branchId' => $branchId,
                    ), array('target' => '_blank')); ?>
                </td>
                <?php $invoiceMean = $invoiceTotalSum / $maxMonthNum; ?>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $invoiceMean)); ?></td>
                <?php $invoiceMinAmount = min($invoiceTotals); ?>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $invoiceMinAmount)); ?></td>
                <?php $invoiceMaxAmount = max($invoiceTotals); ?>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $invoiceMaxAmount)); ?></td>
                <?php sort($invoiceTotals); ?>
                <?php $invoiceMedian = ($invoiceTotals[5] + $invoiceTotals[6]) / 2; ?>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $invoiceMedian)); ?></td>
                <td></td>
                <?php $quantityStock = isset($inventoryCurrentStockData[$productId]) ? $inventoryCurrentStockData[$productId] : '0.00'; ?>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $quantityStock)); ?></td>
                <?php $product = Product::model()->findByPk($productId); ?>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $product->minimum_stock)); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $invoiceMedian)); ?></td>
                <td style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $product->minimum_stock - $quantityStock)); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td style="text-align: right" colspan="7">Total</td>
            <?php $grandTotal = 0; ?>
            <?php for ($month = 1; $month <= 12; $month++): ?>
                <?php if (!isset($groupTotalSums[$month])): ?>
                    <?php $groupTotalSums[$month] = 0; ?>
                <?php endif; ?>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $groupTotalSums[$month])); ?></td>
                <?php $grandTotal += $groupTotalSums[$month]; ?>
            <?php endfor; ?>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotal)); ?></td>
            <td colspan="9">&nbsp;</td>
        </tr>
    </tfoot>
</table>
</div>