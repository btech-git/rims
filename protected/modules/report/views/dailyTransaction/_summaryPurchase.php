<fieldset>
    <legend>Pembelian</legend>
    <table class="report">
        <thead>
            <tr id="header1">
                <th style="width: 3%">No.</th>
                <th style="width: 15%">Transaksi #</th>
                <th style="width: 10%">Tipe</th>
                <th style="width: 20%">Supplier</th>
                <th style="width: 20%">Note</th>
                <th style="width: 10%">Status</th>
                <th style="width: 12%">Total</th>
                <th style="width: 10%">Verified By</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($purchaseOrderData as $i => $header): ?>
                <tr class="items1">
                    <td style="text-align: center"><?php echo $i + 1; ?></td>
                    <td>
                        <?php echo CHtml::link(CHtml::encode($header->purchase_order_no), array("/transaction/transactionPurchaseOrder/view", "id"=>$header->id), array("target" => "_blank")); ?>
                    </td>
                    <td><?php echo CHtml::encode($header->getPurchaseStatus($header->purchase_type)); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'supplier.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'note')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'status_document')); ?></td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'total_price'))); ?>
                    </td>
                    <td>
                        <?php if ($header->is_verified == 0): ?>
                            <?php echo CHtml::link('<span class="fa fa-check"></span>Verify', array(
                                "/report/dailyTransaction/verifyPurchase", 
                                "id" => $header->id, 
                                'branchId' => $branchId, 
                                'transactionDate' => $transactionDate
                            ), array(
                                'class' => 'button success center', 
                                'style' => 'margin-right:10px',  
                                'confirm' => 'Are you sure you want to verify this transaction?',
                            )); ?>
                        <?php else: ?>
                            <?php echo CHtml::encode(CHtml::value($header, 'userIdVerified.username')); ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>

<hr />

<fieldset>
    <legend>Payment Out</legend>
    <table class="report">
        <thead>
            <tr id="header1">
                <th style="width: 3%">No.</th>
                <th style="width: 15%">Transaksi #</th>
                <th style="width: 10%">Tipe</th>
                <th style="width: 20%">Supplier</th>
                <th style="width: 20%">Note</th>
                <th style="width: 10%">Status</th>
                <th style="width: 12%">Amount</th>
                <th style="width: 10%">Verified By</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($paymentOutData as $i => $header): ?>
                <tr class="items1">
                    <td style="text-align: center"><?php echo $i + 1; ?></td>
                    <td>
                        <?php echo CHtml::link(CHtml::encode($header->payment_number), array(
                            "/transaction/paymentIn/view", 
                            "id"=>$header->id
                        ), array("target" => "_blank")); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'paymentType.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'supplier.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'notes')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'payment_amount'))); ?>
                    </td>
                    <td>
                        <?php if ($header->is_verified == 0): ?>
                            <?php echo CHtml::link('<span class="fa fa-check"></span>Verify', array(
                                "/report/dailyTransaction/verifyPaymentOut", 
                                "id" => $header->id, 
                                'branchId' => $branchId, 
                                'transactionDate' => $transactionDate
                            ), array(
                                'class' => 'button success center', 
                                'style' => 'margin-right:10px',  
                                'confirm' => 'Are you sure you want to verify this transaction?',
                            )); ?>
                        <?php else: ?>
                            <?php echo CHtml::encode(CHtml::value($header, 'userIdVerified.username')); ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>
