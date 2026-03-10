<fieldset>
    <legend>Sent Request</legend>
    <table class="report">
        <thead>
            <tr id="header1">
                <th style="width: 3%">No.</th>
                <th style="width: 15%">Transaksi #</th>
                <th style="width: 20%">Tujuan</th>
                <th style="width: 10%">Status</th>
                <th style="width: 10%">Verified By</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sentRequestData as $i => $header): ?>
                <tr class="items1">
                    <td style="text-align: center"><?php echo $i + 1; ?></td>
                    <td>
                        <?php echo CHtml::link(CHtml::encode($header->sent_request_no), array("/transaction/transactionSentRequest/view", "id"=>$header->id), array("target" => "_blank")); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'destinationBranch.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'status_document')); ?></td>
                    <td>
                        <?php if ($header->is_verified == 0): ?>
                            <?php echo CHtml::link('<span class="fa fa-check"></span>Verify', array("/report/dailyTransaction/verifySent", "id" => $header->id), array(
                                'class' => 'button success center', 
                                'style' => 'margin-right:10px', 
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
    <legend>Transfer Request</legend>
    <table class="report">
        <thead>
            <tr id="header1">
                <th style="width: 3%">No.</th>
                <th style="width: 15%">Transaksi #</th>
                <th style="width: 20%">Tujuan</th>
                <th style="width: 10%">Status</th>
                <th style="width: 10%">Verified By</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transferRequestData as $i => $header): ?>
                <tr class="items1">
                    <td style="text-align: center"><?php echo $i + 1; ?></td>
                    <td>
                        <?php echo CHtml::link(CHtml::encode($header->transfer_request_no), array("/transaction/transactionTransferRequest/view", "id"=>$header->id), array("target" => "_blank")); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'destinationBranch.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'status_document')); ?></td>
                    <td>
                        <?php if ($header->is_verified == 0): ?>
                            <?php echo CHtml::link('<span class="fa fa-check"></span>Verify', array("/report/dailyTransaction/verifyTransfer", "id" => $header->id), array(
                                'class' => 'button success center', 
                                'style' => 'margin-right:10px', 
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
    <legend>Pengiriman</legend>
    <table class="report">
        <thead>
            <tr id="header1">
                <th style="width: 3%">No.</th>
                <th style="width: 15%">Transaksi #</th>
                <th style="width: 10%">Tipe</th>
                <th style="width: 20%">Tujuan</th>
                <th style="width: 15%">Reference #</th>
                <th style="width: 10%">Verified By</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($deliveryData as $i => $header): ?>
                <tr class="items1">
                    <td style="text-align: center"><?php echo $i + 1; ?></td>
                    <td>
                        <?php echo CHtml::link(CHtml::encode($header->delivery_order_no), array("/transaction/transactionDeliveryOrder/view", "id"=>$header->id), array("target" => "_blank")); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'request_type')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'destinationBranch.name')); ?></td>
                    <td>
                        <?php if (!empty($header->sales_order_id)): ?>
                            <?php echo CHtml::encode(CHtml::value($header, 'salesOrder.sale_order_no')); ?>
                        <?php elseif (!empty($header->sent_request_id)): ?>
                            <?php echo CHtml::encode(CHtml::value($header, 'sentRequest.sent_request_no')); ?>
                        <?php elseif (!empty($header->consignment_out_id)): ?>
                            <?php echo CHtml::encode(CHtml::value($header, 'consignmentOut.consignment_out_no')); ?>
                        <?php elseif (!empty($header->transfer_request_id)): ?>
                            <?php echo CHtml::encode(CHtml::value($header, 'transferRequest.transfer_request_no')); ?>
                        <?php else: ?> 
                            <?php echo ''; ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($header->is_verified == 0): ?>
                            <?php echo CHtml::link('<span class="fa fa-check"></span>Verify', array("/report/dailyTransaction/verifyDelivery", "id" => $header->id), array(
                                'class' => 'button success center', 
                                'style' => 'margin-right:10px', 
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
    <legend>Movement Out</legend>
    <table class="report">
        <thead>
            <tr id="header1">
                <th style="width: 3%">No.</th>
                <th style="width: 15%">Transaksi #</th>
                <th style="width: 10%">Tipe</th>
                <th style="width: 10%">Status</th>
                <th style="width: 15%">Reference #</th>
                <th style="width: 10%">Verified By</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($movementOutData as $i => $header): ?>
                <tr class="items1">
                    <td style="text-align: center"><?php echo $i + 1; ?></td>
                    <td>
                        <?php echo CHtml::link(CHtml::encode($header->movement_out_no), array("/transaction/movementOut/view", "id"=>$header->id), array("target" => "_blank")); ?>
                    </td>
                    <td><?php echo CHtml::encode($header->getMovementType($header->movement_type)); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
                    <td>
                        <?php if (!empty($header->delivery_order_id)): ?>
                            <?php echo CHtml::encode(CHtml::value($header, 'deliveryOrder.delivery_order_no')); ?>
                        <?php elseif (!empty($header->return_order_id)): ?>
                            <?php echo CHtml::encode(CHtml::value($header, 'returnOrder.return_order_no')); ?>
                        <?php elseif (!empty($header->registration_transaction_id)): ?>
                            <?php echo CHtml::encode(CHtml::value($header, 'registrationTransaction.transaction_number')); ?>
                        <?php elseif (!empty($header->material_request_header_id)): ?>
                            <?php echo CHtml::encode(CHtml::value($header, 'materialRequestHeader.transaction_number')); ?>
                        <?php else: ?> 
                            <?php echo ''; ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($header->is_verified == 0): ?>
                            <?php echo CHtml::link('<span class="fa fa-check"></span>Verify', array("/report/dailyTransaction/verifyMovementOut", "id" => $header->id), array(
                                'class' => 'button success center', 
                                'style' => 'margin-right:10px', 
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
    <legend>Penerimaan</legend>
    <table class="report">
        <thead>
            <tr id="header1">
                <th style="width: 3%">No.</th>
                <th style="width: 15%">Transaksi #</th>
                <th style="width: 15%">Tipe</th>
                <th style="width: 20%">Supplier</th>
                <th style="width: 10%">ETA</th>
                <th style="width: 10%">Tujuan</th>
                <th style="width: 15%">Reference #</th>
                <th style="width: 10%">Verified By</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($receiveItemData as $i => $header): ?>
                <tr class="items1">
                    <td style="text-align: center"><?php echo $i + 1; ?></td>
                    <td>
                        <?php echo CHtml::link(CHtml::encode($header->receive_item_no), array("/transaction/transactionReceiveItem/view", "id"=>$header->id), array("target" => "_blank")); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'request_type')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'supplier.name')); ?></td>
                    <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime(CHtml::value($header, 'estimate_arrival_date')))); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'destinationBranch.name')); ?></td>
                    <td>
                        <?php if (!empty($header->purchase_order_id)): ?>
                            <?php echo CHtml::encode(CHtml::value($header, 'purchaseOrder.purchase_order_no')); ?>
                        <?php elseif (!empty($header->transfer_request_id)): ?>
                            <?php echo CHtml::encode(CHtml::value($header, 'transferRequest.transfer_request_no')); ?>
                        <?php elseif (!empty($header->consignment_in_id)): ?>
                            <?php echo CHtml::encode(CHtml::value($header, 'consignmentIn.consignment_in_number')); ?>
                        <?php elseif (!empty($header->delivery_order_id)): ?>
                            <?php echo CHtml::encode(CHtml::value($header, 'deliveryOrder.delivery_order_no')); ?>
                        <?php elseif (!empty($header->movement_out_id)): ?>
                            <?php echo CHtml::encode(CHtml::value($header, 'movementOut.movement_out_no')); ?>
                        <?php else: ?> 
                            <?php echo ''; ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($header->is_verified == 0): ?>
                            <?php echo CHtml::link('<span class="fa fa-check"></span>Verify', array("/report/dailyTransaction/verifyReceive", "id" => $header->id), array(
                                'class' => 'button success center', 
                                'style' => 'margin-right:10px', 
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
    <legend>Movement In</legend>
    <table class="report">
        <thead>
            <tr id="header1">
                <th style="width: 3%">No.</th>
                <th style="width: 15%">Transaksi #</th>
                <th style="width: 10%">Tipe</th>
                <th style="width: 10%">Status</th>
                <th style="width: 15%">Reference #</th>
                <th style="width: 10%">Verified By</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($movementInData as $i => $header): ?>
                <tr class="items1">
                    <td style="text-align: center"><?php echo $i + 1; ?></td>
                    <td>
                        <?php echo CHtml::link(CHtml::encode($header->movement_in_number), array("/transaction/movementIn/view", "id"=>$header->id), array("target" => "_blank")); ?>
                    </td>
                    <td><?php echo CHtml::encode($header->getMovementType($header->movement_type)); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
                    <td>
                        <?php if (!empty($header->return_item_id)): ?>
                            <?php echo CHtml::encode(CHtml::value($header, 'returnItem.return_item_no')); ?>
                        <?php elseif (!empty($header->receive_item_id)): ?>
                            <?php echo CHtml::encode(CHtml::value($header, 'receiveItem.receive_item_no')); ?>
                        <?php else: ?> 
                            <?php echo ''; ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($header->is_verified == 0): ?>
                            <?php echo CHtml::link('<span class="fa fa-check"></span>Verify', array("/report/dailyTransaction/verifyMovementIn", "id" => $header->id), array(
                                'class' => 'button success center', 
                                'style' => 'margin-right:10px', 
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
