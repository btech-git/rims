<?php if (count($model->paymentOuts) > 0): ?>
    <?php foreach ($model->paymentOuts as $paymentOut): ?>
            <table>
                <tr>
                    <td width="15%">Payment #</td>
                    <td><?php echo $paymentOut->payment_number; ?></td>
                    <td width="15%">Payment Type</td>
                    <td><?php echo $paymentOut->paymentType->name; ?></td>
                </tr>
                <tr>
                    <td width="15%">Tanggal</td>
                    <td><?php echo Yii::app()->dateFormatter->format("d MMMM yyyy", $paymentOut->payment_date); ?></td>
                    <td width="15%">Company Bank</td>
                    <td><?php echo CHtml::encode(CHtml::value($paymentOut, 'companyBank.name')); ?></td>
                </tr>
                <tr>
                    <td width="15%">Supplier</td>
                    <td><?php echo $paymentOut->supplier->name; ?></td>
                    <td width="15%">Admin</td>
                    <td><?php echo $paymentOut->user->username; ?></td>
                </tr>
                <tr>
                    <td width="15%">Branch</td>
                    <td><?php echo $paymentOut->branch->name; ?></td>
                    <td width="15%">Note</td>
                    <td><?php echo $paymentOut->notes; ?></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <table>
                            <thead>
                                <tr>
                                    <td>Invoice #</td>
                                    <td>Tanggal</td>
                                    <td>PO #</td>
                                    <td>Jatuh Tempo</td>
                                    <td>Memo</td>
                                    <td>Amount</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($paymentOut->payOutDetails as $key => $payOutDetail): ?>
                                    <tr>
                                        <?php $receiveHeader = $payOutDetail->receiveHeader; ?>
                                        <td><?php echo CHtml::encode(CHtml::value($receiveHeader, 'invoice_number')); ?></td>
                                        <td><?php echo CHtml::encode(CHtml::value($receiveHeader, 'invoice_date')); ?></td>
                                        <td><?php echo CHtml::encode(CHtml::value($receiveHeader, 'purchaseOrder.purchase_order_no')); ?></td>
                                        <td><?php echo CHtml::encode(CHtml::value($receiveHeader, 'invoice_due_date')); ?></td>
                                        <td><?php echo CHtml::encode(CHtml::value($payOutDetail, 'memo')); ?></td>
                                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($payOutDetail, 'total_invoice'))); ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" style="text-align: right">TOTAL</td>
                                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($paymentOut, 'totalInvoice'))); ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </td>
                </tr>
            </table>
    <?php endforeach; ?>
<?php else: ?>
    <?php echo "NO DATA FOUND"; ?>
<?php endif; ?>