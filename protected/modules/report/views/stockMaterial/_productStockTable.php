<div style="text-align: center">
    <span style="text-align: center"><h2>Stok Bahan Material</h2></span>
    <span style="text-align: center">
        <h2>Per Tanggal: <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></h2>
    </span>
</div>

<div class="table_wrapper">
    <table class="responsive">
        <thead style="position: sticky; top: 0">
            <tr>
                <th style="text-align: center">ID</th>
                <th style="text-align: center">Code</th>
                <th style="text-align: center">Name</th>
                <th style="text-align: center">Brand</th>
                <th style="text-align: center">Satuan</th>
                <?php foreach ($branches as $branch): ?>
                    <th style="text-align: center"><?php echo CHtml::encode(CHtml::value($branch, 'code')); ?></th>
                <?php endforeach; ?>
                <th style="text-align: center; font-weight: bold">Total</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($inventoryMaterialStockReportData as $productId => $inventoryMaterialStockReportItem): ?>
                <?php $totalStockSum = '0.00'; ?>
                <?php $product = Product::model()->findByPk($productId); ?>
                <tr>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'id')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'manufacturer_code')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'name')); ?></td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($product, 'brand.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($product, 'subBrand.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($product, 'subBrandSeries.name')); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'unit.name')); ?></td>
                    <?php foreach ($branches as $branch): ?>
                        <?php $totalStock = isset($inventoryMaterialStockReportItem[$branch->id]) ? $inventoryMaterialStockReportItem[$branch->id] : 0; ?>
                        <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.000', $totalStock)); ?></td>
                        <?php $totalStockSum += $totalStock; ?>
                    <?php endforeach; ?>

                    <td style="text-align: center; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.000',$totalStockSum)); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>