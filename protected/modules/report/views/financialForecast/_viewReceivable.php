<div class="row">
    <p><h2></h2></p>
    <table>
        <thead>
            <tr>
                <th>Invoice #</th>
                <th>Customer</th>
                <th>Amount</th>
                <th>Jatuh Tempo</th>
                <th>Hari</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($receivableTransactionDataProvider->data as $receivableTransaction): ?>
                <tr>
                    <td><?php echo CHtml::encode(CHtml::value($receivableTransaction, 'invoice_number')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($receivableTransaction, 'customer.name')); ?></td>
                    <td style="text-align: right"><?php echo number_format(CHtml::encode(CHtml::value($receivableTransaction, 'payment_left')), 0); ?></td>
                    <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", CHtml::value($receivableTransaction, 'due_date'))); ?></td>
                    <td><?php echo CHtml::encode(date('l', strtotime(CHtml::value($receivableTransaction, 'due_date')))); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>