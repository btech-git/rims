<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Raperind Motor</div>
    <div style="font-size: larger">Laporan Penjualan Parts & Components Tahunan</div>
    <div><?php echo 'Periode tahun: ' . CHtml::encode($year); ?></div>
</div>

<br />

<?php $maxMonthNum = (int) $year === (int) $yearNow ? $monthNow : 12; ?>

<table style="width: 100%">
    <thead>
        <tr>
            <th style="width: 10px">No.</th>
            <th style="width: 300px">Product</th>
            <?php for ($month = 1; $month <= 12; $month++): ?>
                <th style="text-align: center"><?php echo CHtml::encode($monthList[$month]); ?></th>
            <?php endfor; ?>
            <th style="text-align: center">Total</th>
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
        <?php foreach ($yearlyProductSaleTransactionReportData as $productId => $yearlyProductSaleTransactionReportDataItem): ?>
            <tr>
                <td style="text-align: center"><?php echo ++$ordinal; ?></td>
                <td><?php echo $yearlyProductSaleTransactionReportDataItem['product_name']; ?></td>
                <?php $invoiceTotals = array(); ?>
                <?php for ($month = 1; $month <= 12; $month++): ?>
                    <?php $invoiceTotal = isset($yearlyProductSaleTransactionReportDataItem['totals'][$month]) ? $yearlyProductSaleTransactionReportDataItem['totals'][$month] : '0.00'; ?>
                    <?php if ($month <= $maxMonthNum): ?>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $invoiceTotal)); ?></td>
                    <?php else: ?>
                        <td></td>
                    <?php endif; ?>
                    <?php $invoiceTotals[] = $invoiceTotal; ?>
                <?php endfor; ?>
                <?php $invoiceTotalSum = array_sum($invoiceTotals); ?>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $invoiceTotalSum)); ?></td>
                <?php $invoiceMean = $invoiceTotalSum / $maxMonthNum; ?>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $invoiceMean)); ?></td>
                <?php $invoiceMinAmount = min($invoiceTotals); ?>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $invoiceMinAmount)); ?></td>
                <?php $invoiceMaxAmount = max($invoiceTotals); ?>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $invoiceMaxAmount)); ?></td>
                <?php sort($invoiceTotals); ?>
                <?php $invoiceMedian = ($invoiceTotals[5] + $invoiceTotals[6]) / 2; ?>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $invoiceMedian)); ?></td>
                <td></td>
                <?php $quantityStock = isset($inventoryCurrentStockData[$productId]) ? $inventoryCurrentStockData[$productId] : '0.00'; ?>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $quantityStock)); ?></td>
                <?php $product = Product::model()->findByPk($productId); ?>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $product->minimum_stock)); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $invoiceMedian)); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $product->minimum_stock - $quantityStock)); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
    
