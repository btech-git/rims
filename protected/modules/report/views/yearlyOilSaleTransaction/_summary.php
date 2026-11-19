<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Raperind Motor</div>
    <div style="font-size: larger">Penjualan Oli Tahunan</div>
    <div><?php echo 'Periode tahun: ' . CHtml::encode($year); ?></div>
</div>

<br />

<?php $maxMonthNum = (int) $year === (int) $yearNow ? $monthNow : 12; ?>

<div class="table_wrapper">
    <table class="responsive">
        <thead>
            <tr>
                <th style="width: 10px">No.</th>
                <th style="width: 5%">ID</th>
                <th style="width: 10%">Code</th>
                <th style="width: 10%">Name</th>
                <th style="width: 10%">SAE</th>
                <th style="width: 10%">Brand</th>
                <th style="width: 10%">Category</th>
                <th style="width: 5%">Satuan</th>
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
            <?php foreach ($yearlyOilSaleTransactionReportData as $productId => $yearlyOilSaleTransactionReportDataItem): ?>
                <?php $product = Product::model()->findByPk($productId); ?>
                <?php $multiplier = $unitConversion !== null && $unitConversion->unit_from_id == $product->unit_id ? $unitConversion->multiplier : 1; ?>
                <?php $unitName = $unitConversion !== null && $unitConversion->unit_from_id == $product->unit_id ? $unitConversion->unitTo->name : $product->unit->name; ?>
            
                <tr>
                    <td style="text-align: center"><?php echo ++$ordinal; ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'id')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'manufacturer_code')); ?></td>
                    <td><?php echo $yearlyOilSaleTransactionReportDataItem['product_name']; ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'oilSae.oilName')); ?></td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($product, 'brand.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($product, 'subBrand.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($product, 'subBrandSeries.name')); ?>
                    </td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($product, 'productMasterCategory.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($product, 'productSubMasterCategory.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($product, 'productSubCategory.name')); ?>
                    </td>
                    <td><?php echo CHtml::encode($unitName); ?></td>
                    
                    <?php $invoiceTotals = array(); ?>
                    <?php for ($month = 1; $month <= 12; $month++): ?>
                        <?php $invoiceOriginal = isset($yearlyOilSaleTransactionReportDataItem['totals'][$month]) ? $yearlyOilSaleTransactionReportDataItem['totals'][$month] : '0.00'; ?>
                        <?php $invoiceTotal = $multiplier * $invoiceOriginal; ?>
                        <?php if ($month <= $maxMonthNum): ?>
                            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $invoiceTotal)); ?></td>
                        <?php else: ?>
                            <td></td>
                        <?php endif; ?>
                        <?php $invoiceTotals[] = $invoiceTotal; ?>
                    <?php endfor; ?>
                            
                    <?php $invoiceTotalSum = array_sum($invoiceTotals); ?>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $invoiceTotalSum)); ?></td>
                    <?php $invoiceMean = $multiplier * ($invoiceTotalSum / $maxMonthNum); ?>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $invoiceMean)); ?></td>
                    <?php $invoiceMinAmount = min($invoiceTotals); ?>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $invoiceMinAmount)); ?></td>
                    <?php $invoiceMaxAmount = max($invoiceTotals); ?>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $invoiceMaxAmount)); ?></td>
                    <?php sort($invoiceTotals); ?>
                    <?php $invoiceMedian = $multiplier * (($invoiceTotals[5] + $invoiceTotals[6]) / 2); ?>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $invoiceMedian)); ?></td>
                    <td></td>
                    <?php $quantityStockOriginal = isset($inventoryCurrentStockData[$productId]) ? $inventoryCurrentStockData[$productId] : '0.00'; ?>
                    <?php $quantityStock = $multiplier * $quantityStockOriginal; ?>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $quantityStock)); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $product->minimum_stock)); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $invoiceMedian)); ?></td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $product->minimum_stock - $quantityStock)); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>