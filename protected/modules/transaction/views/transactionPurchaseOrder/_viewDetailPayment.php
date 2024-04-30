<?php if (count($model->transactionReceiveItems) > 0): ?>
    <?php $totalAmount = 0; ?>
    <?php foreach ($model->transactionReceiveItems as $receiveItem): ?>
        <?php foreach ($receiveItem->payOutDetails as $paymentOutDetail): ?>
            <table>
                <tr>
                    <td width="15%">Payment #</td>
                    <td><?php echo CHTml::link($paymentOutDetail->paymentOut->payment_number, array("/accounting/paymentOut/view", "id"=>$paymentOutDetail->payment_out_id), array('target' => 'blank')); ?></td>
                    <td width="15%">Payment Type</td>
                    <td><?php echo $paymentOutDetail->paymentOut->paymentType->name; ?></td>
                </tr>
                <tr>    
                    <td width="15%">Tanggal</td>
                    <td><?php echo Yii::app()->dateFormatter->format("d MMMM yyyy", $paymentOutDetail->paymentOut->payment_date); ?></td>
                    <td width="15%">Company Bank</td>
                    <td><?php echo CHtml::encode(CHtml::value($paymentOutDetail, 'paymentOut.companyBank.name')); ?></td>
                </tr>
                <tr>
                    <td width="15%">Supplier</td>
                    <td><?php echo $paymentOutDetail->paymentOut->supplier->name; ?></td>
                    <td width="15%">Admin</td>
                    <td><?php echo $paymentOutDetail->paymentOut->user->username; ?></td>
                </tr>
                <tr>
                    <td width="15%">Branch</td>
                    <td><?php echo $paymentOutDetail->paymentOut->branch->name; ?></td>
                    <td width="15%">Note</td>
                    <td><?php echo $paymentOutDetail->paymentOut->notes; ?></td>
                </tr>
                <tr>
                    <td width="15%">Invoice #</td>
                    <td><?php echo CHtml::encode(CHtml::value($receiveItem, 'invoice_number')); ?></td>
                    <td width="15%">Amount</td>
                    <td><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($paymentOutDetail, 'amount'))); ?></td>
                </tr>
                <tr>
                    <td width="15%">Tanggal</td>
                    <td><?php echo CHtml::encode(CHtml::value($receiveItem, 'invoice_date')); ?></td>
                    <td width="15%">Memo</td>
                    <td><?php echo CHtml::encode(CHtml::value($paymentOutDetail, 'memo')); ?></td>
                </tr>
                <tr>
                    <td width="15%">Jatuh Tempo</td>
                    <td><?php echo CHtml::encode(CHtml::value($receiveItem, 'invoice_due_date')); ?></td>
                </tr>
                <?php $totalAmount += CHtml::encode(CHtml::value($paymentOutDetail, 'amount')); ?>
            </table>
        <?php endforeach; ?>
    <?php endforeach; ?>
    <div style="font-weight: bold; text-align: center">
        Total Payment: <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalAmount)); ?>
    </div>
<?php else: ?>
    <?php echo "NO DATA FOUND"; ?>
<?php endif; ?>