<div class="reportDisplay">
    <?php echo ReportHelper::summaryText($tireDataProvider); ?>
</div>

<br />

<div class="table_wrapper">
    <table class="responsive">
        <thead>
            <tr>
                <th style="text-align: center">ID</th>
                <th style="text-align: center">Code</th>
                <th style="text-align: center">Name</th>
                <th style="text-align: center">Uk. Ban</th>
                <th style="text-align: center">Brand</th>
                <th style="text-align: center">DOT</th>
                <?php foreach ($branches as $branch): ?>
                    <th style="text-align: center"><?php echo CHtml::encode(CHtml::value($branch, 'code')); ?></th>
                <?php endforeach; ?>
                <th style="text-align: center">Total</th>
                <th style="text-align: center">Pricelist</th>
                <th style="text-align: center">Sell Price</th>
                <th style="text-align: center">Frekuensi Jual</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($tireDataProvider->data as $product): ?>
                <?php $inventoryTotalQuantities = $product->getTotalTireQuantitiesByProductionYear($endDate, $productionYear); ?>
                <?php $totalStock = 0; ?>
                <tr>
                    <td><?php echo CHtml::link(CHtml::value($product, 'id'), array('showProduct', 'id' => $product->id), array('target' => 'blank')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'manufacturer_code')); ?></td>
                    <td><?php echo CHtml::link(CHtml::value($product, 'name'), array('showProduct', 'id' => $product->id), array('target' => 'blank')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'tireSize.tireName')); ?></td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($product, 'brand.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($product, 'subBrand.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($product, 'subBrandSeries.name')); ?>
                    </td>
                    <td><?php echo CHtml::encode($productionYear); ?></td>

                    <?php foreach ($branches as $branch): ?>
                        <?php $stockValue = 0; ?>
                        <?php foreach ($inventoryTotalQuantities as $i => $inventoryTotalQuantity): ?>
                            <?php if ($inventoryTotalQuantity['branch_id'] == $branch->id): ?>
                                <?php $stockValue = CHtml::value($inventoryTotalQuantities[$i], 'total_stock'); ?>
                                <?php break; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <td><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $stockValue)); ?></td>
                        <?php $totalStock += $stockValue; ?>
                    <?php endforeach; ?>

                    <td><?php echo CHtml::encode($totalStock); ?></td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($product, 'retail_price'))); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($product, 'recommended_selling_price'))); ?>
                    </td>
                    <td style="text-align: right">
                        <?php $averageQuantity = InvoiceDetail::getAverageQuantityProductYearly($product->id); ?>
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $averageQuantity)); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="right">
        <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
            'pages' => $tireDataProvider->pagination,
        )); ?>
    </div>
    <br /><br />
</div>