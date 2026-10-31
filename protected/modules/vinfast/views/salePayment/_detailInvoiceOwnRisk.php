<table>
    <thead>
        <tr>
            <th>Invoice OR #</th>
            <th>Tanggal</th>
            <th>Plat #</th>
            <th>Note</th>
            <th>OR Amount</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($paymentIn->details as $i => $detail): ?>
            <tr>
                <td>
                    <?php echo CHtml::activeHiddenField($detail, "[$i]sale_invoice_insurance_own_risk_id"); ?>
                    <?php echo CHtml::activeHiddenField($detail, "[$i]registration_transaction_id"); ?>
                    <?php echo CHtml::encode(CHtml::value($detail, "saleInvoiceInsuranceOwnRisk.transaction_number")); ?>
                </td>
                <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", strtotime(CHtml::value($detail, "saleInvoiceInsuranceOwnRisk.transaction_date")))); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($detail, "saleInvoiceInsuranceOwnRisk.vehicle.plate_number")); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($detail, "saleInvoiceInsuranceOwnRisk.note")); ?></td>
                <td style="text-align: right">
                    <?php echo CHtml::activeHiddenField($detail, "[$i]own_risk_amount"); ?>
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, "own_risk_amount"))); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
