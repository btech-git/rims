<div style="text-align: right">
    <?php echo ReportHelper::summaryText($productDataProvider); ?>
</div>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Raperind Motor</div>
    <div style="font-size: larger">Penjualan Oli Bulanan</div>
    <div><?php echo CHtml::encode(strftime("%B",mktime(0,0,0,$month))); ?> - <?php echo CHtml::encode($year); ?></div>
</div>

<br />

<table>
    <thead style="position: sticky; top: 0">
        <tr>
            <th style="text-align: center">ID</th>
            <th style="text-align: center">Code</th>
            <th style="text-align: center">Name</th>
            <th style="text-align: center">SAE</th>
            <th style="text-align: center">Brand</th>
            <th style="text-align: center">Category</th>
            <th style="text-align: center">Satuan</th>
            <?php foreach ($branches as $branch): ?>
                <th style="text-align: center"><?php echo CHtml::encode(CHtml::value($branch, 'code')); ?></th>
            <?php endforeach; ?>
            <th style="text-align: center">Total</th>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach ($productDataProvider->data as $product): ?>
            <?php $oilSaleTotalQuantities = $product->getOilSaleTotalQuantitiesReport($year, $month); ?>
            <?php $totalQuantity = 0; ?>
            <?php $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year); ?>
            <?php $yearMonth = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT); ?>
            <?php $startDate = $yearMonth . '-01'; ?>
            <?php $endDate = $yearMonth . '-' . $daysInMonth; ?>
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
                <td><?php echo CHtml::encode(CHtml::value($product, 'masterSubCategoryCode')); ?></td>
                <td>
                    <?php if (empty($convertToLitre)): ?>
                        <?php echo CHtml::encode(CHtml::value($product, 'unit.name')); ?>
                    <?php else: ?>
                        <?php echo 'Liter'; ?>
                    <?php endif; ?>
                </td>
                
                <?php foreach ($branches as $branch): ?>
                    <?php $saleQuantity = 0; ?>
                    <?php foreach ($oilSaleTotalQuantities as $i => $oilSaleTotalQuantity): ?>
                        <?php if ($oilSaleTotalQuantity['branch_id'] == $branch->id): ?>
                            <?php $originalQuantity = CHtml::value($oilSaleTotalQuantities[$i], 'total_quantity'); ?>
                            <?php $saleQuantity = $multiplier * $originalQuantity; ?>
                            <?php break; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <td style="text-align: center">
                        <?php echo CHtml::link($saleQuantity, array(
                            '/report/monthlyOilSaleTransaction/transactionInfo', 
                            'productId' => $product->id, 
                            'startDate' => $startDate, 
                            'endDate' => $endDate,
                            'branchId' => $branch->id,
                        ), array('target' => '_blank')); ?>
                    </td>
                    <?php $totalQuantity += $saleQuantity; ?>
                <?php endforeach; ?>
                <td style="text-align: center">
                    <?php echo CHtml::link($totalQuantity, array(
                        '/report/monthlyOilSaleTransaction/transactionInfo', 
                        'productId' => $product->id, 
                        'startDate' => $startDate, 
                        'endDate' => $endDate,
                        'branchId' => null,
                    ), array('target' => '_blank')); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>