<div style="text-align: right">
    <?php echo ReportHelper::summaryText($productSubCategoryDataProvider); ?>
</div>

<table>
    <thead style="position: sticky; top: 0">
        <tr>
            <th style="text-align: center">Sub Category</th>
            <th style="text-align: center">Sub Master Category</th>
            <th style="text-align: center">Master Category</th>
            <?php foreach ($branches as $branch): ?>
                <th style="text-align: center"><?php echo CHtml::encode(CHtml::value($branch, 'code')); ?></th>
            <?php endforeach; ?>
            <th style="text-align: center">Stock</th>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach ($productSubCategoryDataProvider->data as $productSubCategory): ?>
            <?php $inventoryTotalQuantities = $productSubCategory->getInventoryTotalQuantities(); ?>
            <?php $totalStock = 0; ?>
            <tr>
                <td><?php echo CHtml::link(CHtml::value($productSubCategory, 'name'), array('detail', 'id' => $productSubCategory->id)); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($productSubCategory, 'productSubMasterCategory.name')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($productSubCategory, 'productSubMasterCategory.productMasterCategory.name')); ?></td>
                
                <?php foreach ($branches as $branch): ?>
                    <?php $stockValue = 0; ?>
                    <?php foreach ($inventoryTotalQuantities as $i => $inventoryTotalQuantity): ?>
                        <?php if ($inventoryTotalQuantity['branch_id'] == $branch->id): ?>
                            <?php $stockValue = CHtml::value($inventoryTotalQuantities[$i], 'total_stock'); ?>
                            <?php break; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <td><?php echo CHtml::encode($stockValue); ?></td>
                    <?php $totalStock += $stockValue; ?>
                <?php endforeach; ?>
                        
                <td style="text-align: center"><?php echo CHtml::encode($totalStock); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>