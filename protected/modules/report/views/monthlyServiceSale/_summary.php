<div class="grid-view">
    <table class="report" style="width: 4000px">
        <thead>
            <tr id="header1">
                <th></th>
                <?php foreach ($serviceSaleData as $serviceSaleItem): ?>
                    <th><?php echo CHtml::encode($serviceSaleItem['service_name']); ?></th>
                <?php endforeach; ?>
                <th style="width: 120px">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php for ($n = 1; $n <= $numberOfDays; $n++): ?>
                <tr>
                    <td style="width: 10px; overflow: hidden"><?php echo $n; ?></td>
                    <?php $quantitySum = '0.00'; ?>
                    <?php $priceSum = '0.00'; ?>
                    <?php foreach ($serviceSaleData as $serviceId => $serviceSaleItem): ?>
                        <?php $day = str_pad($n, 2, '0', STR_PAD_LEFT); ?>
                        <?php $date = $year . '-' . $month . '-' . $day; ?>
                        <?php $quantity = isset($serviceSaleItem[$date]['total_quantity']) ? $serviceSaleItem[$date]['total_quantity'] : ''; ?>
                        <?php $price = isset($serviceSaleItem[$date]['total_price']) ? $serviceSaleItem[$date]['total_price'] : ''; ?>
                        <td style="padding: 16px">
                            <?php if (isset($serviceSaleItem[$date])): ?>
                                <div><strong>Qty:</strong> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $quantity)); ?></div>
                                <div><strong>Price:</strong> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $price)); ?></div>
                            <?php endif; ?>
                        </td>
                        <?php $quantitySum += $quantity; ?>
                        <?php $priceSum += $price; ?>
                        <?php if (!isset($footerQuantities[$serviceId])): ?>
                            <?php $footerQuantities[$serviceId] = '0.00'; ?>
                        <?php endif; ?>
                        <?php if (!isset($footerPrices[$serviceId])): ?>
                            <?php $footerPrices[$serviceId] = '0.00'; ?>
                        <?php endif; ?>
                        <?php $footerQuantities[$serviceId] += $quantity; ?>
                        <?php $footerPrices[$serviceId] += $price; ?>
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
                <?php foreach ($serviceSaleData as $serviceId => $serviceSaleItem): ?>
                    <td>
                        <div><strong>Qty:</strong> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $footerQuantities[$serviceId])); ?></div>
                        <div><strong>Price:</strong> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $footerPrices[$serviceId])); ?></div>
                    </td>
                    <?php $footerQuantitiesSum += $footerQuantities[$serviceId]; ?>
                    <?php $footerPricesSum += $footerPrices[$serviceId]; ?>
                <?php endforeach; ?>
                <td>
                    <div><strong>Qty:</strong> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $footerQuantitiesSum)); ?></div>
                    <div><strong>Price:</strong> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $footerPricesSum)); ?></div>
                </td>
            </tr>
        </tfoot>
    </table>
</div>