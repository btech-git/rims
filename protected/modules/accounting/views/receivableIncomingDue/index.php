<h3>Data Piutang Jatuh Tempo</h3>

<fieldset>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Invoice #</th>
                <th>Tanggal</th>
                <th>Jatuh Tempo</th>
                <th>Customer</th>
                <th>Plat #</th>
                <th>Total</th>
                <th>Payment</th>
                <th>Remaining</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($receivableIncomingDueDate as $i => $dataItem): ?>
                <tr>
                    <td><?php echo CHtml::encode($i + 1); ?></td>
                    <td><?php echo CHtml::encode($dataItem['invoice_number']); ?></td>
                    <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($dataItem['invoice_date']))); ?></td>
                    <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($dataItem['due_date']))); ?></td>
                    <td><?php echo CHtml::encode($dataItem['customer']); ?></td>
                    <td><?php echo CHtml::encode($dataItem['plate_number']); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['total_price'])); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['payment_amount'])); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['payment_left'])); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>