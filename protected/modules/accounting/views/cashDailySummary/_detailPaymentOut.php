<table>
    <thead>
        <tr>
            <th style="text-align: center">No</th>
            <th style="text-align: center">Branch</th>
            <th style="text-align: center">Supplier</th>
            <th style="text-align: center">Payment Type</th>
            <th style="text-align: center">Amount</th>
            <th style="text-align: center">Payment #</th>
            <!--<th style="text-align: center">PO #</th>-->
            <th style="text-align: center">Notes</th> 
        </tr>
    </thead>
    <tbody>
        <?php $grandTotal = 0; ?>
        <?php foreach ($paymentOutDataProvider->data as $i => $paymentOut): ?>
            <?php $totalAmount = $paymentOut->payment_amount; ?>
            <tr>
                <td><?php echo CHtml::encode($i + 1); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($paymentOut, 'branch.name')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($paymentOut, 'supplier.name')); ?></td>
                <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($paymentOut, 'paymentType.name')); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalAmount)); ?></td>
                <td>
                    <?php echo CHtml::link($paymentOut->payment_number, array('javascript:;'), array(
                        'onclick' => 'window.open("' . CController::createUrl('/accounting/cashDailySummary/redirectTransaction', array(
                            "codeNumber" => $paymentOut->payment_number
                        )) . '", "_blank", "top=100, left=225, width=900, height=650"); return false;'
                    )); ?>
                </td>
<!--                <td>
                    <?php /*echo CHtml::link($paymentOut->receiveItem->purchaseOrder->purchase_order_no, array('javascript:;'), array(
                        'onclick' => 'window.open("' . CController::createUrl('/accounting/cashDailySummary/redirectTransaction', array(
                            "codeNumber" => $paymentOut->receiveItem->purchaseOrder->purchase_order_no
                        )) . '", "_blank", "top=100, left=225, width=900, height=650"); return false;'
                    ));*/ ?>
                </td>-->
                <td><?php echo CHtml::encode(CHtml::value($paymentOut, 'notes')); ?></td>
            </tr>
            <?php $grandTotal += $totalAmount; ?>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4" style="text-align: right; border-top: 1px solid">Total</td>
            <td style="text-align: right; border-top: 1px solid">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotal)); ?>
            </td>
            <td colspan="3" style="border-top: 1px solid">&nbsp;</td>
        </tr>
    </tfoot>
</table>