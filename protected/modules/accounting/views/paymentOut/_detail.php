<table style="border: 1px solid">
    <thead>
        <tr style="background-color: skyblue">
            <th style="text-align: center; width: 10%">Invoice #</th>
            <th style="text-align: center; width: 10%">Tanggal</th>
            <th style="text-align: center; width: 10%">Jatuh Tempo</th>
            <th style="text-align: center">Memo</th>
            <th style="text-align: center; width: 10%">Amount</th>
            <th style="width: 5%"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($paymentOut->details as $i => $detail): ?>
            <tr style="background-color: azure">
                <td>
                    <?php echo CHtml::activeHiddenField($detail, "[$i]receive_item_id"); ?>
                    <?php echo CHtml::encode($detail->receiveItem->invoice_number); ?>
                    <?php echo CHtml::error($detail, 'receive_item_id'); ?>
                </td>
                <td>
                    <?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", CHtml::value($detail, 'receiveItem.invoice_date'))); ?>
                </td>
                <td>
                    <?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", CHtml::value($detail, 'receiveItem.invoice_due_date'))); ?>
                </td>
                <td style="text-align: right">
                    <?php echo CHtml::activeTextField($detail, "[$i]memo", array('size'=>20, 'maxlength'=>60)); ?>
                    <?php echo CHtml::error($detail, 'memo'); ?>
                </td>
                <td style="text-align: right">
                    <?php echo CHtml::activeHiddenField($detail, "[$i]total_invoice"); ?>
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'receiveItem.invoice_grand_total'))); ?>
                    <?php echo CHtml::error($detail, 'invoice_grand_total'); ?>
                </td>
                <td>
                    <?php if ($detail->isNewRecord): ?>
                        <?php echo CHtml::button('Delete', array(
                            'onclick' => CHtml::ajax(array(
                                'type' => 'POST',
                                'url' => CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $paymentOut->header->id, 'index' => $i)),
                                'update' => '#detail_div',
                            )),
                        )); ?>
                    <?php else: ?>
                        <?php echo CHtml::activeDropDownList($detail, "[$i]is_inactive", array(
                            ActiveRecord::ACTIVE => ActiveRecord::ACTIVE_LITERAL, 
                            ActiveRecord::INACTIVE => ActiveRecord::INACTIVE_LITERAL
                        )); ?>
                    <?php endif; ?>
                </td>
            </tr>
	<?php endforeach; ?>
    </tbody>
    <tfoot>
	<tr style="background-color: aquamarine">
            <td colspan="4" style="text-align: right; font-weight: bold">Total Hutang:</td>
            <td style="text-align: right; font-weight: bold">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($paymentOut, 'totalInvoice'))); ?>
            </td>
            <td></td>
	</tr>
	<tr style="background-color: aquamarine">
            <td colspan="4" style="text-align: right; font-weight: bold">Pembayaran:</td>
            <td style="text-align: right;font-weight: bold">
                <?php echo CHtml::activeTextField($paymentOut->header, 'payment_amount'); ?>
                <?php echo CHtml::error($paymentOut->header, 'payment_amount'); ?>
            </td>
            <td></td>
	</tr>
    </tfoot>
</table>
