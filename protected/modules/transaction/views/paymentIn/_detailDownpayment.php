<table>
    <thead>
        <tr>
            <th>Invoice DP #</th>
            <th>Tanggal</th>
            <th>Plat #</th>
            <th>Note</th>
            <th>DP Amount</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($paymentIn->details as $i => $detail): ?>
            <tr>
                <td>
                    <?php echo CHtml::activeHiddenField($detail, "[$i]registration_transaction_id"); ?>
                    <?php echo CHtml::encode(CHtml::value($detail, "registrationTransaction.downpayment_transaction_number")); ?>
                </td>
                <td><?php echo CHtml::encode(CHtml::value($detail, "registrationTransaction.downpayment_transaction_date")); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($detail, "registrationTransaction.vehicle.plate_number")); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($detail, "registrationTransaction.downpayment_note")); ?></td>
                <td style="text-align: right">
                    <?php echo CHtml::activeHiddenField($detail, "[$i]downpayment_amount"); ?>
                    <?php echo CHtml::encode(CHtml::value($detail, "downpayment_amount")); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
