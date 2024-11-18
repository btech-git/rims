<fieldset>
    <legend>Movement In</legend>
    <table class="report">
        <thead>
            <tr id="header1">
                <th class="width1-1">Transaksi #</th>
                <th class="width1-2">Tanggal</th>
                <th class="width1-3">Tipe</th>
                <th class="width1-4">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($movementInData as $header): ?>
                <tr class="items1">
                    <td class="width1-1">
                        <?php echo CHtml::link(CHtml::encode($header->movement_in_number), array("/transaction/movementIn/view", "id"=>$header->id), array("target" => "_blank")); ?>
                    </td>
                    <td class="width1-2">
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date_posting))); ?>
                    </td>
                    <td class="width1-3"><?php echo CHtml::encode($header->getMovementType($header->movement_type)); ?></td>
                    <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>

<hr />

<fieldset>
    <legend>Movement Out</legend>
    <table class="report">
        <thead>
            <tr id="header1">
                <th class="width1-1">Transaksi #</th>
                <th class="width1-2">Tanggal</th>
                <th class="width1-3">Tipe</th>
                <th class="width1-4">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($movementOutData as $header): ?>
                <tr class="items1">
                    <td class="width1-1">
                        <?php echo CHtml::link(CHtml::encode($header->movement_out_no), array("/transaction/movementOut/view", "id"=>$header->id), array("target" => "_blank")); ?>
                    </td>
                    <td class="width1-2">
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date_posting))); ?>
                    </td>
                    <td class="width1-3"><?php echo CHtml::encode($header->getMovementType($header->movement_type)); ?></td>
                    <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>

<hr />

<fieldset>
    <legend>Pengiriman</legend>
    <table class="report">
        <thead>
            <tr id="header1">
                <th class="width1-1">Transaksi #</th>
                <th class="width1-2">Tanggal</th>
                <th class="width1-3">Tipe</th>
                <th class="width1-4">Tujuan</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($deliveryData as $header): ?>
                <tr class="items1">
                    <td class="width1-1">
                        <?php echo CHtml::link(CHtml::encode($header->delivery_order_no), array("/transaction/transactionDeliveryOrder/view", "id"=>$header->id), array("target" => "_blank")); ?>
                    </td>
                    <td class="width1-2">
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->delivery_date))); ?>
                    </td>
                    <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'request_type')); ?></td>
                    <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'destinationBranch.name')); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>

<hr />

<fieldset>
    <legend>Penerimaan</legend>
    <table class="report">
        <thead>
            <tr id="header1">
                <th class="width1-1">Transaksi #</th>
                <th class="width1-2">Tanggal</th>
                <th class="width1-3">Tipe</th>
                <th class="width1-4">Supplier</th>
                <th class="width1-5">Note</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($receiveItemData as $header): ?>
                <tr class="items1">
                    <td class="width1-1">
                        <?php echo CHtml::link(CHtml::encode($header->receive_item_no), array("/transaction/transactionReceiveItem/view", "id"=>$header->id), array("target" => "_blank")); ?>
                    </td>
                    <td class="width1-2">
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->receive_item_date))); ?>
                    </td>
                    <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'request_type')); ?></td>
                    <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'supplier.name')); ?></td>
                    <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'note')); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>

<hr />

<fieldset>
    <legend>Sent Request</legend>
    <table class="report">
        <thead>
            <tr id="header1">
                <th class="width1-1">Transaksi #</th>
                <th class="width1-2">Tanggal</th>
                <th class="width1-3">Tujuan</th>
                <th class="width1-4">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sentRequestData as $header): ?>
                <tr class="items1">
                    <td class="width1-1">
                        <?php echo CHtml::link(CHtml::encode($header->sent_request_no), array("/transaction/transactionSentRequest/view", "id"=>$header->id), array("target" => "_blank")); ?>
                    </td>
                    <td class="width1-2">
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->sent_request_date))); ?>
                    </td>
                    <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'destinationBranch.name')); ?></td>
                    <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'status_document')); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>

<hr />

<fieldset>
    <legend>Transfer Request</legend>
    <table class="report">
        <thead>
            <tr id="header1">
                <th class="width1-1">Transaksi #</th>
                <th class="width1-2">Tanggal</th>
                <th class="width1-3">Tujuan</th>
                <th class="width1-4">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transferRequestData as $header): ?>
                <tr class="items1">
                    <td class="width1-1">
                        <?php echo CHtml::link(CHtml::encode($header->transfer_request_no), array("/transaction/transactionTransferRequest/view", "id"=>$header->id), array("target" => "_blank")); ?>
                    </td>
                    <td class="width1-2">
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->transfer_request_date))); ?>
                    </td>
                    <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'destinationBranch.name')); ?></td>
                    <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'status_document')); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>