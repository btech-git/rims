<div style="text-align: center">
    <span style="text-align: center"><h2>Stok Oli</h2></span>
    <span style="text-align: center">
        <h2>Per Tanggal: <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></h2>
    </span>
</div>

<table>
    <thead style="position: sticky; top: 0">
        <tr>
            <th style="text-align: center">ID</th>
            <th style="text-align: center">Code</th>
            <th style="text-align: center">Name</th>
            <th style="text-align: center">Ukuran</th>
            <th style="text-align: center">Brand</th>
            <th style="text-align: center">Satuan</th>
            <?php foreach ($branches as $branch): ?>
                <th style="text-align: center"><?php echo CHtml::encode(CHtml::value($branch, 'code')); ?></th>
            <?php endforeach; ?>
            <th style="text-align: center; font-weight: bold">Total</th>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach ($inventoryOilStockReportData as $productId => $inventoryOilStockReportItem): ?>
            <?php $totalStockSum = '0.00'; ?>
            <?php $product = Product::model()->findByPk($productId); ?>
            <?php $multiplier = $unitConversion !== null && $unitConversion->unit_from_id == $product->unit_id ? $unitConversion->multiplier : 1; ?>
            <tr>
                <td><?php echo CHtml::encode(CHtml::value($product, 'id')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($product, 'manufacturer_code')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($product, 'name')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($product, 'oilSae.oilName')); ?></td>
                <td>
                    <?php echo CHtml::encode(CHtml::value($product, 'brand.name')); ?> - 
                    <?php echo CHtml::encode(CHtml::value($product, 'subBrand.name')); ?> - 
                    <?php echo CHtml::encode(CHtml::value($product, 'subBrandSeries.name')); ?>
                </td>
                <td>
                    <?php if (empty($convertToLitre)): ?>
                        <?php echo CHtml::encode(CHtml::value($product, 'unit.name')); ?>
                    <?php else: ?>
                        <?php echo 'Liter'; ?>
                    <?php endif; ?>
                </td>
                <?php foreach ($branches as $branch): ?>
                    <?php $originalStock = isset($inventoryOilStockReportItem[$branch->id]) ? $inventoryOilStockReportItem[$branch->id] : 0; ?>
                    <?php $totalStock = $multiplier * $originalStock; ?>
                    <td style="text-align: center"><?php echo CHtml::encode($totalStock); ?></td>
                    <?php $totalStockSum += $totalStock; ?>
                <?php endforeach; ?>
                        
                <td style="text-align: center; font-weight: bold"><?php echo CHtml::encode($totalStockSum); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>