<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Raperind Motor</div>
    <div style="font-size: larger">Penjualan Oli Bulanan</div>
    <div><?php echo 'Periode: ' . CHtml::encode($monthList[$month]) . ' ' . CHtml::encode($year); ?></div>
</div>

<br />

<?php $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year); ?>

<div class="table_wrapper">
    <table class="responsive">
        <thead>
            <tr>
                <th colspan="8"></th>
                <?php foreach ($branches as $branch): ?>
                    <th style="text-align: center" colspan="5"><?php echo CHtml::encode(CHtml::value($branch, 'code')); ?></th>
                <?php endforeach; ?>
                <th style="text-align: center" colspan="5">All Branch</th>
            </tr>
            <tr>
                <th style="width: 10px">No.</th>
                <th style="text-align: center">ID</th>
                <th style="text-align: center">Code</th>
                <th style="text-align: center">Name</th>
                <th style="text-align: center">SAE</th>
                <th style="text-align: center">Brand</th>
                <th style="text-align: center">Category</th>
                <th style="text-align: center">Satuan</th>
                <?php foreach ($branches as $branch): ?>
                    <th style="text-align: center">Total Jual</th>
                    <th style="text-align: center">Average Jual</th>
                    <th style="text-align: center">Klasifikasi</th>
                    <th style="text-align: center">Min Stok</th>
                    <th style="text-align: center">Posisi Stok</th>
                <?php endforeach; ?>
                <th style="text-align: center">Total Jual</th>
                <th style="text-align: center">Average Jual</th>
                <th style="text-align: center">Klasifikasi</th>
                <th style="text-align: center">Min Stok</th>
                <th style="text-align: center">Posisi Stok</th>
            </tr>
        </thead>
        <tbody>
            <?php $ordinal = 0; ?>
            <?php foreach ($monthlyOilSaleTransactionReportData as $productId => $monthlyOilSaleTransactionReportDataItem): ?>
                <?php $product = Product::model()->findByPk($productId); ?>
                <?php $multiplier = $unitConversion !== null && $unitConversion->unit_from_id == $product->unit_id ? $unitConversion->multiplier : 1; ?>
                <?php $unitName = $unitConversion !== null && $unitConversion->unit_from_id == $product->unit_id ? $unitConversion->unitTo->name : $product->unit->name; ?>
            
                <tr>
                    <td style="text-align: center"><?php echo ++$ordinal; ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'id')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'manufacturer_code')); ?></td>
                    <td><?php echo $monthlyOilSaleTransactionReportDataItem['product_name']; ?></td>
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
                    <?php $quantityStocks = array(); ?>
                    <?php foreach ($branches as $branch): ?>
                        <?php $minimumStock = $multiplier * $product->minimum_stock; ?>
                        <?php $invoiceOriginal = isset($monthlyOilSaleTransactionReportDataItem['totals'][$branch->id]) ? $monthlyOilSaleTransactionReportDataItem['totals'][$branch->id] : '0.00'; ?>
                        <?php $invoiceTotal = $multiplier * $invoiceOriginal; ?>
                        <?php $quantityStockOriginal = isset($inventoryAllBranchCurrentStockData[$productId][$branch->id]) ? $inventoryAllBranchCurrentStockData[$productId][$branch->id] : '0.00'; ?>
                        <?php $quantityStock = $multiplier * $quantityStockOriginal; ?>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $invoiceTotal)); ?></td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $invoiceTotal / $numberOfDays)); ?></td>
                        <td style="text-align: right"></td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $minimumStock)); ?></td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $quantityStock)); ?></td>
                        <?php $invoiceTotals[] = $invoiceTotal; ?>
                        <?php $quantityStocks[] = $quantityStock; ?>
                    <?php endforeach; ?>
                    <?php $invoiceTotalSum = array_sum($invoiceTotals); ?>
                    <?php $quantityStockSum = array_sum($quantityStocks); ?>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $invoiceTotalSum)); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $invoiceTotalSum / $numberOfDays)); ?></td>
                    <td style="text-align: right"></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $minimumStock)); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $quantityStockSum)); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>