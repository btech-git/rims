<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Raperind Motor</div>
    <div style="font-size: larger">Laporan Pemakaian Material Bulanan</div>
    <div><?php echo 'Periode: ' . CHtml::encode($monthList[$month]) . ' ' . CHtml::encode($year); ?></div>
</div>

<br />

<?php $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year); ?>

<table style="width: 100%">
    <thead>
        <tr>
            <th colspan="2"></th>
            <?php foreach ($branches as $branch): ?>
                <th style="text-align: center" colspan="4"><?php echo CHtml::encode(CHtml::value($branch, 'code')); ?></th>
            <?php endforeach; ?>
            <th style="text-align: center" colspan="4">All Branch</th>
        </tr>
        <tr>
            <th style="width: 10px">No.</th>
            <th style="width: 300px">Product</th>
            <?php foreach ($branches as $branch): ?>
                <th style="text-align: center">Total Pakai</th>
                <th style="text-align: center">Average Pakai</th>
                <th style="text-align: center">Min Stok</th>
                <th style="text-align: center">Posisi Stok</th>
            <?php endforeach; ?>
            <th style="text-align: center">Total Pakai</th>
            <th style="text-align: center">Average Pakai</th>
            <th style="text-align: center">Min Stok</th>
            <th style="text-align: center">Posisi Stok</th>
        </tr>
    </thead>
    <tbody>
        <?php $ordinal = 0; ?>
        <?php foreach ($monthlyMaterialServiceUsageReportData as $productId => $monthlyMaterialServiceUsageReportDataItem): ?>
            <?php $product = Product::model()->findByPk($productId); ?>
            <tr>
                <td style="text-align: center"><?php echo ++$ordinal; ?></td>
                <td><?php echo $monthlyMaterialServiceUsageReportDataItem['product_name']; ?></td>
                <?php $invoiceTotals = array(); ?>
                <?php $quantityStocks = array(); ?>
                <?php foreach ($branches as $branch): ?>
                    <?php $invoiceTotal = isset($monthlyMaterialServiceUsageReportDataItem['totals'][$branch->id]) ? $monthlyMaterialServiceUsageReportDataItem['totals'][$branch->id] : '0.00'; ?>
                    <?php $quantityStock = isset($inventoryAllBranchCurrentStockData[$productId][$branch->id]) ? $inventoryAllBranchCurrentStockData[$productId][$branch->id] : '0.00'; ?>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $invoiceTotal)); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $invoiceTotal / $numberOfDays)); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $product->minimum_stock)); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $quantityStock)); ?></td>
                    <?php $invoiceTotals[] = $invoiceTotal; ?>
                    <?php $quantityStocks[] = $quantityStock; ?>
                <?php endforeach; ?>
                <?php $invoiceTotalSum = array_sum($invoiceTotals); ?>
                <?php $quantityStockSum = array_sum($quantityStocks); ?>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $invoiceTotalSum)); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $invoiceTotalSum / $numberOfDays)); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $product->minimum_stock)); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $quantityStockSum)); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
