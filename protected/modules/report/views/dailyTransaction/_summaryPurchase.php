<fieldset>
    <legend>Pembelian</legend>
    <table class="report">
        <thead>
            <tr id="header1">
                <th class="width1-1">Transaksi #</th>
                <th class="width1-2">Tanggal</th>
                <th class="width1-3">Tipe</th>
                <th class="width1-4">Supplier</th>
                <th class="width1-5">Note</th>
                <th class="width1-6">Status</th>
                <th class="width1-7">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($purchaseOrderData as $header): ?>
                <tr class="items1">
                    <td class="width1-1">
                        <?php echo CHtml::link(CHtml::encode($header->purchase_order_no), array("/transaction/transactionPurchaseOrder/view", "id"=>$header->id), array("target" => "_blank")); ?>
                    </td>
                    <td class="width1-2">
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->purchase_order_date))); ?>
                    </td>
                    <td class="width1-3"><?php echo CHtml::encode($header->getPurchaseStatus($header->purchase_type)); ?></td>
                    <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'supplier.name')); ?></td>
                    <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'note')); ?></td>
                    <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'status_document')); ?></td>
                    <td class="width1-7" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'total_price'))); ?>
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
                <th class="width1-1">Transaksi #</th>
                <th class="width1-2">Tanggal</th>
                <th class="width1-3">Tipe</th>
                <th class="width1-4">Supplier</th>
                <th class="width1-5">Note</th>
                <th class="width1-6">Status</th>
                <th class="width1-7">Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($paymentOutData as $header): ?>
                <tr class="items1">
                    <td class="width1-1">
                        <?php echo CHtml::link(CHtml::encode($header->payment_number), array("/transaction/paymentIn/view", "id"=>$header->id), array("target" => "_blank")); ?>
                    </td>
                    <td class="width1-2">
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->payment_date))); ?>
                    </td>
                    <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'paymentType.name')); ?></td>
                    <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'supplier.name')); ?></td>
                    <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'notes')); ?></td>
                    <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
                    <td class="width1-7" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'payment_amount'))); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>
