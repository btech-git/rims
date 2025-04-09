<div class="grid-view">
    <table class="report" style="width: 4000px">
        <thead>
            <tr id="header1">
                <th style="width: 80px"></th>
                <?php for ($n = 1; $n <= $numberOfDays; $n++): ?>
                    <th style="width: 120px; overflow: hidden"><?php echo $n; ?></th>
                <?php endfor; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productSaleData as $productSaleItem): ?>
                <tr>
                    <td><?php echo CHtml::encode($productSaleItem['product_name']); ?></td>
                    <?php for ($n = 1; $n <= $numberOfDays; $n++): ?>
                        <?php $day = str_pad($n, 2, '0', STR_PAD_LEFT); ?>
                        <?php $date = $year . '-' . $month . '-' . $day; ?>
                        <td style="padding: 16px">
                            <?php if (isset($productSaleItem[$date])): ?>
                                <div><strong>Qty:</strong> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $productSaleItem[$date]['total_quantity'])); ?></div>
                                <div><strong>Price:</strong> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $productSaleItem[$date]['total_price'])); ?></div>
                            <?php endif; ?>
                        </td>
                    <?php endfor; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>