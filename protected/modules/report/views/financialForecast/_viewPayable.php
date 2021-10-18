<div class="row">
    <p><h2></h2></p>
    <table>
        <thead>
            <tr>
                <th>Purchase #</th>
                <th>Supplier</th>
                <th>Amount</th>
                <th>Jatuh Tempo</th>
                <th>Hari</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($payableTransactionDataProvider->data as $payableTransaction): ?>
            <tr>
                <td><?php echo CHtml::encode(CHtml::value($payableTransaction, 'purchase_order_no')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($payableTransaction, 'supplier.name')); ?></td>
                <td style="text-align: right"><?php echo number_format(CHtml::encode(CHtml::value($payableTransaction, 'payment_left')), 0); ?></td>
                <td>
                    <?php echo CHtml::link(Yii::app()->dateFormatter->format("d MMM yyyy", CHtml::value($payableTransaction, 'estimate_payment_date')), array('javascript:;'), array(
                        'onclick' => 'window.open("' . CController::createUrl('/accounting/financialForecast/updateDueDate', array('id' => $payableTransaction->id)) . '", "_blank", "top=100, left=425, width=500, height=500"); return false;'
                    )); ?>
                </td>
                <td><?php echo CHtml::encode(date('l', strtotime(CHtml::value($payableTransaction, 'estimate_payment_date')))); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>