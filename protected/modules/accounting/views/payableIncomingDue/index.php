<h3>Data Hutang Jatuh Tempo</h3>

<fieldset>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Invoice #</th>
                <th>Tanggal</th>
                <th>Jatuh Tempo</th>
                <th>Supplier</th>
                <th>Total</th>
                <th>Payment</th>
                <th>Remaining</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($payableIncomingDueDate as $i => $dataItem): ?>
                <tr>
                    <td><?php echo CHtml::encode($i + 1); ?></td>
                    <td>
                        <?php echo CHtml::link(CHtml::encode($dataItem['invoice_number']), array(
                            "/transaction/transactionReceiveItem/show", 
                            "id" => $dataItem['id']
                        ), array('target' => '_blank')); ?>
                    </td>
                    <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($dataItem['invoice_date']))); ?></td>
                    <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($dataItem['invoice_due_date']))); ?></td>
                    <td><?php echo CHtml::encode($dataItem['supplier']); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['invoice_grand_total'])); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['payment'])); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['remaining'])); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>