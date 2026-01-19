<table>
    <thead>
        <tr>
            <th style="text-align: center">No</th>
            <th style="text-align: center">Transaction #</th>
            <th style="text-align: center">Branch</th>
            <th style="text-align: center">Supplier</th>
            <th style="text-align: center">Approved By</th>
            <th style="text-align: center">Note</th>
            <th style="text-align: center">Amount</th>
        </tr>
    </thead>
    
    <tbody>
        <?php $grandTotal = '0.00'; ?>
        <?php foreach ($purchaseOrderDataProvider->data as $i => $header): ?>
            <?php $totalPrice = CHtml::value($header, 'total_price'); ?>
            <tr>
                <td><?php echo CHtml::encode($i + 1); ?></td>
                <td>
                    <?php echo CHtml::link($header->purchase_order_no, array('javascript:;'), array(
                        'onclick' => 'window.open("' . CController::createUrl('/accounting/cashDailySummary/redirectTransaction', array(
                            "codeNumber" => $header->purchase_order_no
                        )) . '", "_blank", "top=100, left=225, width=900, height=650"); return false;'
                    )); ?>
                </td>
                <td><?php echo CHtml::encode(CHtml::value($header, 'mainBranch.name')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($header, 'supplier.name')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($header, 'approval.username')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($header, 'status_document')); ?></td>
                <td style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPrice)); ?>
                </td>
            </tr>
            <?php $grandTotal += $totalPrice; ?>
        <?php endforeach; ?>
    </tbody>
    
    <tfoot>
        <tr>
            <td style="text-align: right" colspan="6">TOTAL</td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotal)); ?></td>
        </tr>
    </tfoot>
</table>