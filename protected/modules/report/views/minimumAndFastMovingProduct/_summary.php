<div style="text-align: right">
    <?php //echo ReportHelper::summaryText($productDataProvider); ?>
    <span style="text-align: center"><h2>Minimum Stok Fast Moving Item</h2></span>
</div>

<table>
    <thead style="position: sticky; top: 0">
        <tr>
            <th style="text-align: center">ID</th>
            <th style="text-align: center">Code</th>
            <th style="text-align: center">Name</th>
            <th style="text-align: center">Brand</th>
            <th style="text-align: center">Category</th>
            <th style="text-align: center">Unit</th>
            <th style="text-align: center">Total Stok</th>
            <th style="text-align: center">Minimum Stok</th>
            <th style="text-align: center">Average Jual Bulanan</th>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach ($minimumAndFastMovingProduct as $detailItem): ?>
            <?php $product = Product::model()->findByPk($detailItem['id']); ?>
            <tr>
                <td><?php echo CHtml::encode($detailItem['id']); ?></td>
                <td><?php echo CHtml::encode($detailItem['manufacturer_code']); ?></td>
                <td><?php echo CHtml::encode($detailItem['name']); ?></td>
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
                <td><?php echo CHtml::encode(CHtml::value($product, 'unit.name')); ?></td>
                <?php $totalStock = isset($inventoryCurrentStocksData[$detailItem['id']]) ? $inventoryCurrentStocksData[$detailItem['id']] : 0; ?>
                <?php $averageQuantity = isset($fastMovingAverageProductQuantitiesData[$detailItem['id']]) ? $fastMovingAverageProductQuantitiesData[$detailItem['id']] : 0; ?>
                <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalStock)); ?></td>
                <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $product->minimum_stock)); ?></td>
                <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $averageQuantity)); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>