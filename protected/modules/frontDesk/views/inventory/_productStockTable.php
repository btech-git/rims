<div style="text-align: right">
    <?php echo ReportHelper::summaryText($productDataProvider); ?>
    <span style="text-align: center"><h2>Kartu Stok Gudang</h2></span>
</div>

<table>
    <thead style="position: sticky; top: 0">
        <tr>
            <th style="text-align: center">ID</th>
            <th style="text-align: center">Code</th>
            <th style="text-align: center">Name</th>
            <th style="text-align: center">Brand</th>
            <th style="text-align: center">Sub Brand</th>
            <th style="text-align: center">Sub Brand Series</th>
            <th style="text-align: center">Category</th>
            <th style="text-align: center">Unit</th>
            <?php foreach ($branches as $branch): ?>
                <th style="text-align: center"><?php echo CHtml::encode(CHtml::value($branch, 'code')); ?></th>
            <?php endforeach; ?>
            <th style="text-align: center">Total</th>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach ($productDataProvider->data as $product): ?>
            <?php $inventoryTotalQuantities = $product->getInventoryTotalQuantitiesByPeriodic($endDate); ?>
            <?php $totalStock = 0; ?>
            <tr>
                <td><?php echo CHtml::link(CHtml::value($product, 'id'), array('detail', 'id' => $product->id, 'endDate' => $endDate)); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($product, 'manufacturer_code')); ?></td>
                <td><?php echo CHtml::link(CHtml::value($product, 'name'), array('detail', 'id' => $product->id, 'endDate' => $endDate)); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($product, 'brand.name')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($product, 'subBrand.name')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($product, 'subBrandSeries.name')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($product, 'masterSubCategoryCode')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($product, 'unit.name')); ?></td>
                
                <?php foreach ($branches as $branch): ?>
                    <?php $stockValue = 0; ?>
                    <?php foreach ($inventoryTotalQuantities as $i => $inventoryTotalQuantity): ?>
                        <?php if ($inventoryTotalQuantity['branch_id'] == $branch->id): ?>
                            <?php $stockValue = CHtml::value($inventoryTotalQuantities[$i], 'total_stock'); ?>
                            <?php break; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <td style="text-align: center"><?php echo CHtml::encode($stockValue); ?></td>
                    <?php $totalStock += $stockValue; ?>
                <?php endforeach; ?>
                        
                <td style="text-align: center"><?php echo CHtml::encode($totalStock); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>