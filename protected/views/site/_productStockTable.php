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
            <th style="text-align: center">Series</th>
            <th style="text-align: center">Category</th>
            <th style="text-align: center">Unit</th>
            <?php foreach ($branches as $branch): ?>
                <th style="text-align: center"><?php echo CHtml::encode(CHtml::value($branch, 'code')); ?></th>
            <?php endforeach; ?>
            <th style="text-align: center">Total</th>
            <th style="text-align: center">Sell Price</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($productDataProvider->data as $product): ?>
            <?php $inventoryTotalQuantities = $product->getInventoryTotalQuantitiesByPeriodic($endDate); ?>
            <?php $totalStock = 0; ?>
            <tr>
                <td><?php echo CHtml::link(CHtml::value($product, 'id'), array('/master/product/view', 'id' => $product->id), array('target' => 'blank')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($product, 'manufacturer_code')); ?></td>
                <td><?php echo CHtml::link(CHtml::value($product, 'name'), array('/master/product/view', 'id' => $product->id), array('target' => 'blank')); ?></td>
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
                    <td><?php echo CHtml::encode($stockValue); ?></td>
                    <?php $totalStock += $stockValue; ?>
                <?php endforeach; ?>

                <td><?php echo CHtml::encode($totalStock); ?></td>
                <td style="text-align: right">
                    <?php $registrationProduct = RegistrationProduct::model()->findByAttributes(array('product_id' => $product->id), array('order' => 't.id DESC')); ?>
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($registrationProduct, 'sale_price'))); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>