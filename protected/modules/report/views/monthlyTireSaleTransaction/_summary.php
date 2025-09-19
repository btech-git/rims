<div style="text-align: right">
    <?php echo ReportHelper::summaryText($productDataProvider); ?>
</div>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Raperind Motor</div>
    <div style="font-size: larger">Penjualan Ban Bulanan</div>
    <div><?php echo CHtml::encode(strftime("%B",mktime(0,0,0,$month))); ?> - <?php echo CHtml::encode($year); ?></div>
</div>

<br />

<table>
    <thead style="position: sticky; top: 0">
        <tr>
            <th style="text-align: center">ID</th>
            <th style="text-align: center">Code</th>
            <th style="text-align: center">Name</th>
            <th style="text-align: center">Brand</th>
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
            <?php $tireSaleTotalQuantities = $product->getTireSaleTotalQuantitiesReport($year, $month); ?>
            <?php $totalQuantity = 0; ?>
            <tr>
                <td><?php echo CHtml::encode(CHtml::value($product, 'id')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($product, 'manufacturer_code')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($product, 'name')); ?></td>
                <td>
                    <?php echo CHtml::encode(CHtml::value($product, 'brand.name')); ?> - 
                    <?php echo CHtml::encode(CHtml::value($product, 'subBrand.name')); ?> - 
                    <?php echo CHtml::encode(CHtml::value($product, 'subBrandSeries.name')); ?>
                </td>
                <td><?php echo CHtml::encode(CHtml::value($product, 'masterSubCategoryCode')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($product, 'unit.name')); ?></td>
                
                <?php foreach ($branches as $branch): ?>
                    <?php $saleQuantity = '0'; ?>
                    <?php foreach ($tireSaleTotalQuantities as $i => $tireSaleTotalQuantity): ?>
                        <?php if ($tireSaleTotalQuantity['branch_id'] == $branch->id): ?>
                            <?php $saleQuantity = CHtml::value($tireSaleTotalQuantities[$i], 'total_quantity'); ?>
                            <?php break; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <td style="text-align: center">
                        <?php echo CHtml::encode($saleQuantity); ?>
                    </td>
                    <?php $totalQuantity += $saleQuantity; ?>
                <?php endforeach; ?>
                <td style="text-align: center"><?php echo CHtml::encode($totalQuantity); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>