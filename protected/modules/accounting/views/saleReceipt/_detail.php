<table>
    <thead>
        <tr>
            <th>Invoice #</th>
            <th>Plat #</th>
            <th>Memo</th>
            <th>Total Invoice</th>
            <th style="width: 3%"></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($saleReceipt->details as $i => $detail): ?>
            <tr>
                <td>
                    <?php echo CHtml::activeHiddenField($detail, "[$i]invoice_header_id"); ?>
                    <?php echo CHtml::encode(CHtml::value($detail, "invoiceHeader.invoice_number")); ?>
                </td>
                <td><?php echo CHtml::encode(CHtml::value($detail, "invoiceHeader.vehicle.plate_number")); ?></td>
                <td><?php echo CHtml::activeTextField($detail, "[$i]memo"); ?></td>
                <td style="text-align: right">
                    <?php echo CHtml::activeHiddenField($detail, "[$i]invoice_amount"); ?>
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, "invoice_amount"))); ?>
                </td>
                <td>
                    <?php echo CHtml::button('X', array(
                        'onclick' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $saleReceipt->header->id, 'index' => $i)),
                            'update' => '#detail_div',
                        )),
                    )); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3" style="text-align: right">Total</td>
            <td style="text-align: right">
                <span id="total_invoice">
                    <?php echo CHtml::activeHiddenField($saleReceipt->header, "total_invoice_amount"); ?>
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($saleReceipt->header, 'total_invoice_amount'))); ?>
                </span>
            </td>
            <td></td>
        </tr>
    </tfoot>
</table>
