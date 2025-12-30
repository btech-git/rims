<div style="text-align: right">
    <span style="text-align: center"><h2>Kartu Stok Ban</h2></span>
</div>

<table>
    <thead style="position: sticky; top: 0">
        <tr>
            <th colspan="5"></th>
            <?php foreach ($branches as $branch): ?>
                <th style="text-align: center" colspan="<?php echo $endYear - $startYear + 1; ?>"><?php echo CHtml::encode(CHtml::value($branch, 'code')); ?></th>
            <?php endforeach; ?>
            <th style="text-align: center"></th>
        </tr>
        <tr>
            <th style="text-align: center">ID</th>
            <th style="text-align: center">Code</th>
            <th style="text-align: center">Name</th>
            <th style="text-align: center">Ukuran</th>
            <th style="text-align: center">Brand</th>
            <?php foreach ($branches as $branch): ?>
                <?php for ($year = $startYear; $year <= $endYear; $year++): ?>
                    <th style="text-align: center"><?php echo CHtml::encode($year); ?></th>
                <?php endfor; ?>
            <?php endforeach; ?>
            <th style="text-align: center">Total</th>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach ($inventoryTireStockReportData as $productId => $inventoryTireStockReportItem): ?>
            <?php $totalStockSum = 0; ?>
            <?php $product = Product::model()->findByPk($productId); ?>
            <tr>
                <td><?php echo CHtml::encode(CHtml::value($product, 'id')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($product, 'manufacturer_code')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($product, 'name')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($product, 'tireSize.tireName')); ?></td>
                <td>
                    <?php echo CHtml::encode(CHtml::value($product, 'brand.name')); ?> - 
                    <?php echo CHtml::encode(CHtml::value($product, 'subBrand.name')); ?> - 
                    <?php echo CHtml::encode(CHtml::value($product, 'subBrandSeries.name')); ?>
                </td>
                <?php foreach ($branches as $branch): ?>
                    <?php for ($year = $startYear; $year <= $endYear; $year++): ?>
                        <?php $totalStock = isset($inventoryTireStockReportItem[$branch->id][$year]) ? $inventoryTireStockReportItem[$branch->id][$year] : '0'; ?>
                        <th style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalStock)); ?></th>
                        <?php $totalStockSum += $totalStock; ?>
                    <?php endfor; ?>
                <?php endforeach; ?>
                        
                <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalStockSum)); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>