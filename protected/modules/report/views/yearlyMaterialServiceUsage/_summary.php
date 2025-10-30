<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Raperind Motor</div>
    <div style="font-size: larger">Laporan Pemakaian Material Tahunan</div>
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
            <th style="text-align: center">Pakai Rata2</th>
            <th style="text-align: center">Pakai Min</th>
            <th style="text-align: center">Pakai Max</th>
            <th style="text-align: center">Pakai Median</th>
            <th style="text-align: center">Stock</th>
            <th style="text-align: center">Min</th>
            <th style="text-align: center">Target</th>
            <th style="text-align: center">Order Plan</th>
        </tr>
    </thead>
    <tbody>
        <?php $ordinal = 0; ?>
        <?php foreach ($yearlyMaterialServiceUsageReportData as $productId => $yearlyMaterialServiceUsageReportDataItem): ?>
            <tr>
                <td style="text-align: center"><?php echo ++$ordinal; ?></td>
                <td><?php echo $yearlyMaterialServiceUsageReportDataItem['product_name']; ?></td>
                <?php $materialTotals = array(); ?>
                <?php for ($month = 1; $month <= 12; $month++): ?>
                    <?php $materialTotal = isset($yearlyMaterialServiceUsageReportDataItem['totals'][$month]) ? $yearlyMaterialServiceUsageReportDataItem['totals'][$month] : '0.00'; ?>
                    <?php if ($month <= $maxMonthNum): ?>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $materialTotal)); ?></td>
                    <?php else: ?>
                        <td></td>
                    <?php endif; ?>
                    <?php $materialTotals[] = $materialTotal; ?>
                <?php endfor; ?>
                <?php $materialTotalSum = array_sum($materialTotals); ?>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $materialTotalSum)); ?></td>
                <?php $materialMean = $materialTotalSum / $maxMonthNum; ?>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $materialMean)); ?></td>
                <?php $materialMinAmount = min($materialTotals); ?>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $materialMinAmount)); ?></td>
                <?php $materialMaxAmount = max($materialTotals); ?>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $materialMaxAmount)); ?></td>
                <?php sort($materialTotals); ?>
                <?php $materialMedian = ($materialTotals[5] + $materialTotals[6]) / 2; ?>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $materialMedian)); ?></td>
                <?php $quantityStock = isset($inventoryCurrentStockData[$productId]) ? $inventoryCurrentStockData[$productId] : '0.00'; ?>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $quantityStock)); ?></td>
                <?php $product = Product::model()->findByPk($productId); ?>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $product->minimum_stock)); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $materialMedian)); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $product->minimum_stock - $quantityStock)); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
    
