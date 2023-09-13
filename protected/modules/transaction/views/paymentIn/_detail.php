<table>
    <thead>
        <tr>
            <th class="required">Invoice #</th>
            <th>Giro #</th>
            <th class="required">Payment Amount</th>
            <th>PPh</th>
            <th class="required">Note</th>
            <th></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($paymentIn->details as $i => $detail): ?>
            <tr>
                <td><?php echo CHtml::encode(CHtml::value($detail, "invoice.invoice_number")); ?></td>
                <td>
                    <?php echo CHtml::activeHiddenField($detail, "[$i]invoice_id"); ?>
                    <?php echo CHtml::activeHiddenField($detail, "[$i]vehicle_id"); ?>
                    <?php echo CHtml::activeTextField($detail, "[$i]nomor_giro"); ?>
                </td>
                <td><?php echo CHtml::activeTextField($detail, "[$i]payment_amount"); ?></td>
                <td><?php echo CHtml::activeTextField($detail, "[$i]tax_service_amount"); ?></td>
                <td><?php echo CHtml::activeTextField($detail, "[$i]notes"); ?></td>
                <td>
                    <?php echo CHtml::button('X', array(
                        'onclick' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlRemoveDetail', array('index' => $i)),
                            'update' => '#detail_div',
                        )),
                    )); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
