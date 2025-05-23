<div class="grid-view">
    <table class="report" style="width: 4000px">
        <thead>
            <tr id="header1">
                <th></th>
                <?php foreach ($productSaleData as $productSaleItem): ?>
                    <th><?php echo CHtml::encode($productSaleItem['product_name']); ?></th>
                <?php endforeach; ?>
                <th style="width: 120px">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $footerQuantities = array(); ?>
            <?php $footerPrices = array(); ?>
            <?php for ($n = 1; $n <= $numberOfDays; $n++): ?>
                <tr>
                    <td style="width: 10px; overflow: hidden"><?php echo $n; ?></td>
                    <?php $quantitySum = '0.00'; ?>
                    <?php $priceSum = '0.00'; ?>
                    <?php foreach ($productSaleData as $productId => $productSaleItem): ?>
                        <?php $day = str_pad($n, 2, '0', STR_PAD_LEFT); ?>
                        <?php $date = $year . '-' . $month . '-' . $day; ?>
                        <?php $quantity = isset($productSaleItem[$date]['total_quantity']) ? $productSaleItem[$date]['total_quantity'] : ''; ?>
                        <?php $price = isset($productSaleItem[$date]['total_price']) ? $productSaleItem[$date]['total_price'] : ''; ?>
                        <td style="padding: 16px">
                            <?php if (isset($productSaleItem[$date])): ?>
                                <div><strong>Qty:</strong> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $quantity)); ?></div>
                                <div><strong>Price:</strong> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $price)); ?></div>
                            <?php endif; ?>
                        </td>
                        <?php $quantitySum += $quantity; ?>
                        <?php $priceSum += $price; ?>
                        <?php if (!isset($footerQuantities[$productId])): ?>
                            <?php $footerQuantities[$productId] = '0.00'; ?>
                        <?php endif; ?>
                        <?php if (!isset($footerPrices[$productId])): ?>
                            <?php $footerPrices[$productId] = '0.00'; ?>
                        <?php endif; ?>
                        <?php $footerQuantities[$productId] += $quantity; ?>
                        <?php $footerPrices[$productId] += $price; ?>
                    <?php endforeach; ?>
                    <td style="text-align: right; font-weight: bold">
                        <div><strong>Qty:</strong> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $quantitySum)); ?></div>
                        <div><strong>Price:</strong> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $priceSum)); ?></div>
                    </td>
                </tr>
            <?php endfor; ?>
        </tbody>
        <tfoot>
            <tr>
                <td>Total</td>
                <?php $footerQuantitiesSum = '0.00'; ?>
                <?php $footerPricesSum = '0.00'; ?>
                <?php foreach ($productSaleData as $productId => $productSaleItem): ?>
                    <td>
                        <div><strong>Qty:</strong> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $footerQuantities[$productId])); ?></div>
                        <div><strong>Price:</strong> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $footerPrices[$productId])); ?></div>
                    </td>
                    <?php $footerQuantitiesSum += $footerQuantities[$productId]; ?>
                    <?php $footerPricesSum += $footerPrices[$productId]; ?>
                <?php endforeach; ?>
                <td>
                    <div><strong>Qty:</strong> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $footerQuantitiesSum)); ?></div>
                    <div><strong>Price:</strong> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $footerPricesSum)); ?></div>
                </td>
            </tr>
        </tfoot>
    </table>
</div>