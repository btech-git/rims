
<?php //foreach ($requestDetails as $key => $requestDetail): ?>	
<?php $receive = TransactionReceiveItem::model()->findByAttributes(array('purchase_order_id'=>$model->id)); ?>
<?php if (count($receive) > 0): ?>
    <?php foreach ($model->transactionReceiveItems as $receiveHeader): ?>
        <table>
            <tr>
                <td width="15%">Receive Item No</td>
                <td><?php echo $receiveHeader->receive_item_no; ?></td>
            </tr>
            <tr>
                <td width="15%">Tanggal</td>
                <td><?php echo $receiveHeader->receive_item_date; ?></td>
            </tr>
            <tr>
                <td colspan="2">
                    <?php $receiveDetails= TransactionReceiveItemDetail::model()->findAllByAttributes(array('receive_item_id'=>$receive->id));?>
                    <table>
                        <thead>
                            <tr>
                                <td>Product</td>
                                <td>Quantity</td>
                                <td>Qty Received</td>
                                <td>Qty Request Left</td>	
                                <td>Notes</td>
                                <td>Barcode Product</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($receiveHeader->transactionReceiveItemDetails as $key => $receiveDetail): ?>
                                <tr>
                                    <td><?php echo $receiveDetail->product->name; ?></td>
                                    <td><?php echo $receiveDetail->qty_request; ?></td>
                                    <td><?php echo $receiveDetail->qty_received; ?></td>
                                    <td><?php echo $receiveDetail->qty_request_left; ?></td>
                                    <td><?php echo $receiveDetail->note; ?></td>
                                    <td><?php echo $receiveDetail->barcode_product; ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
    <?php endforeach ?>
<?php else: ?>
	<?php echo "NO REVISION HISTORY FOUND"; ?>
<?php endif ?>

<?php //endforeach ?>