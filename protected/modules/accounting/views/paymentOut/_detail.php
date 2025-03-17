<table style="border: 1px solid">
    <thead>
        <tr style="background-color: skyblue">
            <?php if ($movementType == 2): ?>
                <th style="text-align: center; width: 17%">Sub Pekerjaan #</th>
                <th style="text-align: center; width: 12%">Tanggal</th>
                <th style="text-align: center; width: 17%">RG #</th>
            <?php elseif ($movementType == 1): ?>
                <th style="text-align: center; width: 12%">Invoice #</th>
                <th style="text-align: center; width: 12%">Tanggal</th>
                <th style="text-align: center; width: 12%">SJ #</th>
                <th style="text-align: center; width: 12%">Jatuh Tempo</th>
            <?php elseif ($movementType == 3): ?>
                <th style="text-align: center; width: 12%">Pembelian #</th>
                <th style="text-align: center; width: 12%">Tanggal</th>
                <th style="text-align: center; width: 12%">Note</th>
            <?php endif; ?>
            <th style="text-align: center; width: 12%">Invoice</th>
            <th style="text-align: center; width: 12%">Payment</th>
            <th style="text-align: center">Memo</th>
            <th style="width: 5%"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($paymentOut->details as $i => $detail): ?>
            <tr style="background-color: azure">
                <td style="display: none">
                    <?php echo CHtml::activeHiddenField($detail, "[$i]receive_item_id"); ?>
                    <?php echo CHtml::activeHiddenField($detail, "[$i]work_order_expense_header_id"); ?>
                    <?php echo CHtml::activeHiddenField($detail, "[$i]item_request_header_id"); ?>
                </td>
                <?php if ($movementType == 2): ?>
                    <?php $workOrderExpenseHeader = WorkOrderExpenseHeader::model()->findByPk($detail->work_order_expense_header_id); ?>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($workOrderExpenseHeader, 'transaction_number')); ?>
                        <?php echo CHtml::error($detail, 'work_order_expense_header_id'); ?>
                    </td>
                    <td>
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", CHtml::value($workOrderExpenseHeader, 'transaction_date'))); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($workOrderExpenseHeader, 'registrationTransaction.transaction_number')); ?></td>
                <?php elseif ($movementType == 1): ?>
                    <?php $receiveItem = TransactionReceiveItem::model()->findByPk($detail->receive_item_id); ?>
                    <td>
                        <?php echo CHtml::encode($receiveItem->invoice_number); ?>
                        <?php echo CHtml::error($detail, 'receive_item_id'); ?>
                    </td>
                    <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", CHtml::value($receiveItem, 'invoice_date'))); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($receiveItem, 'supplier_delivery_number')); ?></td>
                    <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", CHtml::value($receiveItem, 'invoice_due_date'))); ?></td>
                <?php elseif ($movementType == 3): ?>
                    <?php $itemRequestHeader = ItemRequestHeader::model()->findByPk($detail->item_request_header_id); ?>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($itemRequestHeader, 'transaction_number')); ?>
                        <?php echo CHtml::error($detail, 'item_request_header_id'); ?>
                    </td>
                    <td>
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", CHtml::value($itemRequestHeader, 'transaction_date'))); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($itemRequestHeader, 'note')); ?></td>
                <?php endif; ?>
                    
                <td style="text-align: right">
                    <?php echo CHtml::activeHiddenField($detail, "[$i]total_invoice"); ?>
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'total_invoice'))); ?>
                    <?php echo CHtml::error($detail, 'total_invoice'); ?>
                </td>
                <td style="text-align: right">
                    <?php echo CHtml::activeTextField($detail, "[$i]amount", array(
                        'onchange' => '
                            $.ajax({
                                type: "POST",
                                dataType: "JSON",
                                url: "' . CController::createUrl('ajaxJsonTotal', array(
                                    'id' => $paymentOut->header->id, 
                                    'index' => $i, 
                                )) . '", 
                                data: $("form").serialize(), 
                                success: function(data) {
                                    $("#payment_amount").html(data.paymentAmountFormatted);
                                    $("#' . CHtml::activeId($paymentOut->header, "payment_amount") . '").val(data.paymentAmount);
                                },
                            });	
                        ',
                    )); ?>
                    <?php echo CHtml::error($detail, 'amount'); ?>
                </td>
                
                <td style="text-align: right">
                    <?php echo CHtml::activeTextField($detail, "[$i]memo", array('size'=>20, 'maxlength'=>60)); ?>
                    <?php echo CHtml::error($detail, 'memo'); ?>
                </td>

                <td>
                    <?php echo CHtml::button('X', array(
                        'onclick' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $paymentOut->header->id, 'index' => $i, 'movementType' => $movementType)),
                            'update' => '#detail_div',
                        )),
                    )); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
	<tr style="background-color: aquamarine">
            <td colspan=<?php echo $movementType == 1 ? 4 : 3; ?> style="text-align: right; font-weight: bold">Total</td>
            <td style="text-align: right; font-weight: bold">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($paymentOut, 'totalInvoice'))); ?>
            </td>
            <td style="text-align: right;font-weight: bold">
                <?php echo CHtml::activeHiddenField($paymentOut->header, 'payment_amount'); ?>
                <span id="payment_amount">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($paymentOut->header, 'payment_amount'))); ?>
                </span>
                <?php echo CHtml::error($paymentOut->header, 'payment_amount'); ?>
            </td>
            <td colspan="2"></td>
	</tr>
    </tfoot>
</table>
