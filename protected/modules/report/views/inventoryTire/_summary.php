<style> 
 .table_wrapper{
    display: block;
    overflow-x: auto;
    white-space: nowrap;
}
</style>

<div style="text-align: right">
    <?php $dataCount = count($inventoryTireProductionYearStockReportData); ?>
    <?php if ($dataCount > 0): ?>
        <?php echo "Displaying 1-{$dataCount} of {$dataCount} result(s)."; ?>
    <?php endif; ?>
    <span style="text-align: center"><h2>Stok Gudang Ban</h2></span>
</div>

<div class="table_wrapper">
    <table class="responsive">
        <thead style="position: sticky; top: 0">
            <tr>
                <th style="text-align: center">ID</th>
                <th style="text-align: center">Code</th>
                <th style="text-align: center">Name</th>
                <th style="text-align: center">Brand</th>
                <th style="text-align: center">Size</th>
                <th style="text-align: center">Satuan</th>
                <?php foreach ($branches as $branch): ?>
                    <th style="text-align: center"><?php echo CHtml::encode(CHtml::value($branch, 'code')); ?></th>
                <?php endforeach; ?>
                <th style="text-align: center">Total</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($inventoryTireProductionYearStockReportData as $productId => $inventoryTireProductionYearStockReportDataItem): ?>
                <?php $product = Product::model()->findByPk($productId); ?>
                <?php $totalStockSums = array(); ?>
                <tr>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'id')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'manufacturer_code')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'nameAndSpecification')); ?></td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($product, 'brand.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($product, 'subBrand.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($product, 'subBrandSeries.name')); ?>
                    </td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($product, 'tireSize.tireName')); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'unit.name')); ?></td>

                    <?php foreach ($branches as $branch): ?>
                        <td style="text-align: left">
                            <?php if (isset($inventoryTireProductionYearStockReportDataItem[$branch->id])): ?>
                                <?php $inventoryBranchItem = $inventoryTireProductionYearStockReportDataItem[$branch->id]; ?>
                                <?php /*$stockValue = 0; ?>
                                <?php foreach ($inventoryTotalQuantities as $i => $inventoryTotalQuantity): ?>
                                    <?php if ($inventoryTotalQuantity['branch_id'] == $branch->id): ?>
                                        <?php $stockValue = CHtml::value($inventoryTotalQuantities[$i], 'total_stock'); ?>
                                        <?php break; ?>
                                    <?php endif; ?>
                                <?php endforeach;*/ ?>
                                <?php foreach ($inventoryBranchItem as $productionYear => $totalStock): ?>
                                    <?php if (!isset($totalStockSums[$productionYear])): ?>
                                        <?php $totalStockSums[$productionYear] = '0.00'; ?>
                                    <?php endif; ?>
                                    <?php echo CHtml::encode($productionYear . ': ' . Yii::app()->numberFormatter->format('#,##0.00', $totalStock)); ?>
                                    <br />
                                    <?php $totalStockSums[$productionYear] += $totalStock; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </td>
                        <?php //$totalStock += $stockValue; ?>
                    <?php endforeach; ?>

                    <td style="text-align: left">
                        <?php foreach ($totalStockSums as $productionYear => $totalStockSum): ?>
                            <?php echo CHtml::encode($productionYear . ': ' . Yii::app()->numberFormatter->format('#,##0.00', $totalStockSum)); ?>
                            <br />
                        <?php endforeach; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>