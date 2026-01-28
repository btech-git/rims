<div style="text-align: right">
    <span style="text-align: center"><h2>Kartu Stok Oli</h2></span>
</div>

<table>
    <thead style="position: sticky; top: 0">
        <tr>
            <th style="text-align: center">ID</th>
            <th style="text-align: center">Code</th>
            <th style="text-align: center">Name</th>
            <th style="text-align: center">Ukuran</th>
            <th style="text-align: center">Brand</th>
            <?php foreach ($branches as $branch): ?>
                <th style="text-align: center"><?php echo CHtml::encode(CHtml::value($branch, 'code')); ?></th>
            <?php endforeach; ?>
            <th style="text-align: center">Total</th>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach ($inventoryOilStockReportData as $productId => $inventoryOilStockReportItem): ?>
            <?php $totalStockSum = 0; ?>
            <?php $product = Product::model()->findByPk($productId); ?>
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
                <?php foreach ($branches as $branch): ?>
                    <?php $totalStock = isset($inventoryOilStockReportItem[$branch->id]) ? $inventoryOilStockReportItem[$branch->id] : '0'; ?>
                    <th style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalStock)); ?></th>
                    <?php $totalStockSum += $totalStock; ?>
                <?php endforeach; ?>
                        
                <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalStockSum)); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>