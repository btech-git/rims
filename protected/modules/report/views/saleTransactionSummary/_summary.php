<table>
    <tr>
        <td>RG #</td>
        <td>WO #</td>
        <td>MO #</td>
        <td>Invoice #</td>
        <td>Payment #</td>
    </tr>
    <?php foreach ($registrationTransactionDataProvider->data as $registrationTransaction): ?>
        <?php $movementOutHeaders = MovementOutHeader::model()->findAllByAttributes(array('registration_transaction_id' => $registrationTransaction->id)); ?>
        <?php $invoiceHeaders = InvoiceHeader::model()->findAllByAttributes(array('registration_transaction_id' => $registrationTransaction->id)); ?>
        <tr>
            <td>
                <?php echo CHtml::encode(CHtml::value($registrationTransaction, 'transaction_number')); ?>
            </td>
            <td>
                <?php echo CHtml::encode(CHtml::value($registrationTransaction, 'work_order_number')); ?>
            </td>
            <td>
                <?php foreach ($movementOutHeaders as $movementOutHeader): ?>
                    <?php echo CHtml::encode(CHtml::value($movementOutHeader, 'movement_out_no')); ?>
                <?php endforeach; ?>
            </td>
                <td>
            <?php foreach ($invoiceHeaders as $invoiceHeader): ?>
                    <?php echo CHtml::encode(CHtml::value($invoiceHeader, 'invoice_number')); ?>
            <?php endforeach; ?>
                </td>
                <td>
            <?php foreach ($invoiceHeaders as $invoiceHeader): ?>
                <?php $paymentInDetails = PaymentInDetail::model()->findAllByAttributes(array('invoice_header_id' => $invoiceHeader->id)); ?>
            <?php foreach ($paymentInDetails as $paymentInDetail): ?>
                    <?php echo CHtml::encode(CHtml::value($paymentInDetail, 'paymentIn.payment_number')); ?>
            <?php endforeach; ?>
            <?php endforeach; ?>
                </td>
        </tr>
    <?php endforeach; ?>
</table>