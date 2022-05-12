<table>
    <thead>
        <tr>
            <th style="text-align: center">No</th>
            <th style="text-align: center">Transaction #</th>
            <th style="text-align: center">Tanggal</th>
            <th style="text-align: center">Customer</th>
            <th style="text-align: center">Amount</th>
            <th style="text-align: center">Approved By</th>
            <th style="text-align: center">Note</th>
        </tr>
    </thead>
    
    <tbody>
        <?php $grandTotal = 0.00; ?>
        <?php foreach ($saleOrderDataProvider->data as $i => $header): ?>
            <?php $totalPrice = CHtml::value($header, 'total_price'); ?>
            <tr>
                <td><?php echo CHtml::encode($i); ?></td>
                <td>
                    <?php echo CHtml::link($header->sale_order_no, array('javascript:;'), array(
                        'onclick' => 'window.open("' . CController::createUrl('/accounting/cashDailySummary/redirectTransaction', array(
                            "codeNumber" => $header->sale_order_no
                        )) . '", "_blank", "top=100, left=225, width=900, height=650"); return false;'
                    )); ?>
                </td>
                <td>
                    <?php echo CHtml::encode(CHtml::value($header, 'requesterBranch.name')); ?>
                </td>
                <td style="text-align: right">
                    <?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?>
                </td>
                <td style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPrice)); ?>
                </td>
                <td style="text-align: right">
                    <?php echo CHtml::encode(CHtml::value($header, 'approval.username')); ?>
                </td>
                <td style="text-align: right">
                    <?php echo CHtml::encode(CHtml::value($header, 'note')); ?>
                </td>
            </tr>
            <?php $grandTotal += $totalPrice; ?>
        <?php endforeach; ?>
    </tbody>
    
    <tfoot>
        <tr>
            <td style="text-align: right" colspan="4">TOTAL</td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotal)); ?></td>
            <td colspan="2">&nbsp;</td>
        </tr>
    </tfoot>
</table>