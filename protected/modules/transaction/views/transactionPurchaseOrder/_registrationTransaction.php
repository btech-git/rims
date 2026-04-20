<table style="border: 1px solid">
    <tbody>
        <tr style="background-color: greenyellow">
            <td>WO 1 #</td>
            <td>WO 2 #</td>
            <td>WO 3 #</td>
        </tr>
        <tr>
            <td>
                <?php echo CHtml::activeTextField($purchaseOrder->header, 'registration_transaction_id', array(
                    'readonly' => true,
                    'onclick' => '$("#RegistrationMode").val(1); $("#registration-transaction-dialog").dialog("open"); return false;',
                    'onkeypress' => 'if (event.keyCode == 13) { $("#RegistrationMode").val(1);  $("#registration-transaction-dialog").dialog("open"); return false; }',
                )); ?>
                <?php echo CHtml::openTag('span', array('id' => 'registration_transaction_id_span')); ?>
                <?php echo CHtml::encode(CHtml::value($purchaseOrder->header, 'registrationTransaction.work_order_number')); ?>
                <?php echo CHtml::closeTag('span'); ?>
                <?php echo CHtml::error($purchaseOrder->header, 'registration_transaction_id'); ?>
            </td>
            <td>
                <?php echo CHtml::activeTextField($purchaseOrder->header, 'registration_transaction_id_extra_2', array(
                    'readonly' => true,
                    'onclick' => '$("#RegistrationMode").val(2); $("#registration-transaction-dialog").dialog("open"); return false;',
                    'onkeypress' => 'if (event.keyCode == 13) { $("#RegistrationMode").val(2);  $("#registration-transaction-dialog").dialog("open"); return false; }',
                )); ?>
                <?php echo CHtml::openTag('span', array('id' => 'registration_transaction_id_extra_2_span')); ?>
                <?php echo CHtml::encode(CHtml::value($purchaseOrder->header, 'registrationTransactionIdExtra2.work_order_number')); ?>
                <?php echo CHtml::closeTag('span'); ?>
                <?php echo CHtml::error($purchaseOrder->header, 'registration_transaction_id_extra_2'); ?>
            </td>
            <td>
                <?php echo CHtml::activeTextField($purchaseOrder->header, 'registration_transaction_id_extra_3', array(
                    'readonly' => true,
                    'onclick' => '$("#RegistrationMode").val(3); $("#registration-transaction-dialog").dialog("open"); return false;',
                    'onkeypress' => 'if (event.keyCode == 13) { $("#RegistrationMode").val(3);  $("#registration-transaction-dialog").dialog("open"); return false; }',
                )); ?>
                <?php echo CHtml::openTag('span', array('id' => 'registration_transaction_id_extra_3_span')); ?>
                <?php echo CHtml::encode(CHtml::value($purchaseOrder->header, 'registrationTransactionIdExtra3.work_order_number')); ?>
                <?php echo CHtml::closeTag('span'); ?>
                <?php echo CHtml::error($purchaseOrder->header, 'registration_transaction_id_extra_3'); ?>
            </td>
        </tr>
    </tbody>
</table>
