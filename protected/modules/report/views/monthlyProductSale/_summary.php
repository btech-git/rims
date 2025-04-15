<div class="grid-view">
    <table class="report" style="width: 4000px">
        <thead>
            <tr id="header1">
                <th></th>
                <?php foreach ($productSaleData as $productSaleItem): ?>
                    <th><?php echo CHtml::encode($productSaleItem['product_name']); ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php for ($n = 1; $n <= $numberOfDays; $n++): ?>
                <tr>
                    <td style="width: 10px; overflow: hidden"><?php echo $n; ?></td>
                    <?php foreach ($productSaleData as $productSaleItem): ?>
                        <?php $day = str_pad($n, 2, '0', STR_PAD_LEFT); ?>
                        <?php $date = $year . '-' . $month . '-' . $day; ?>
                        <td style="padding: 16px">
                            <?php if (isset($productSaleItem[$date])): ?>
                                <div><strong>Qty:</strong> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $productSaleItem[$date]['total_quantity'])); ?></div>
                                <div><strong>Price:</strong> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $productSaleItem[$date]['total_price'])); ?></div>
                            <?php endif; ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endfor; ?>
        </tbody>
    </table>
</div>