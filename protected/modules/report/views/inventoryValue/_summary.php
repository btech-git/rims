<div style="text-align: right">
    <?php echo ReportHelper::summaryText($productDataProvider); ?>
</div>

<table>
    <thead>
        <tr>
            <th style="text-align: center">ID</th>
            <th style="text-align: center">Code</th>
            <th style="text-align: center">Name</th>
            <th style="text-align: center">Brand</th>
            <th style="text-align: center">Sub Brand</th>
            <th style="text-align: center">Sub Brand Series</th>
            <th style="text-align: center">Category</th>
            <?php foreach ($branches as $branch): ?>
                <th style="text-align: center"><?php echo CHtml::encode(CHtml::value($branch, 'code')); ?></th>
            <?php endforeach; ?>
            <th style="text-align: center">Stock</th>
            <th style="text-align: center">HPP</th>
            <th style="text-align: center">Inventory</th>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach ($productDataProvider->data as $product): ?>
            <?php $inventoryTotalQuantities = $product->getInventoryTotalQuantities(); ?>
            <?php $inventoryCostOfGoodsSold = $product->getInventoryCostOfGoodsSold(); ?>
            <?php $totalStock = 0; ?>
            <?php $totalCogs = 0; ?>
            <?php $totalValue = 0; ?>
            <tr>
                <td><?php echo CHtml::encode(CHtml::value($product, 'id')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($product, 'manufacturer_code')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($product, 'name')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($product, 'brand.name')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($product, 'subBrand.name')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($product, 'subBrandSeries.name')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($product, 'masterSubCategoryCode')); ?></td>
                
                <?php foreach ($branches as $branch): ?>
                    <?php $index = -1; ?>
                    <?php foreach ($inventoryTotalQuantities as $i => $inventoryTotalQuantity): ?>
                        <?php if ($inventoryTotalQuantity['branch_id'] == $branch->id): ?>
                            <?php $index = $i; ?>
                            <?php break; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <?php $stockValue = CHtml::value($inventoryTotalQuantities[$i], 'total_stock'); ?>
                    <?php if ($index >= 0): ?>
                        <td><?php echo CHtml::encode($stockValue); ?></td>
                    <?php else: ?>
                        <td><?php echo 0; ?></td>
                    <?php endif; ?>
                    <?php $totalStock += $stockValue; ?>
                    <?php $totalCogs += CHtml::value($inventoryCostOfGoodsSold[$i], 'cogs'); ?>
                    <?php $totalValue += CHtml::value($inventoryCostOfGoodsSold[$i], 'value'); ?>
                <?php endforeach; ?>
                        
                <td style="text-align: center"><?php echo CHtml::encode($totalStock); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalCogs)); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalValue)); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>