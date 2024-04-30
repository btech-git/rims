
<?php //foreach ($requestDetails as $key => $requestDetail): ?>	
<?php $receive = TransactionReceiveItem::model()->findByAttributes(array('purchase_order_id'=>$model->id)); ?>
<?php if (!empty($receive)): ?>
    <?php foreach ($model->transactionReceiveItems as $receiveHeader): ?>
        <table>
            <tr>
                <td width="15%">Receive Item No</td>
                <td><?php echo CHTml::link($receiveHeader->receive_item_no, array("/transaction/transactionReceiveItem/view", "id"=>$receiveHeader->id), array('target' => 'blank')); ?></td>
            </tr>
            <tr>
                <td width="15%">Tanggal</td>
                <td><?php echo Yii::app()->dateFormatter->format("d MMMM yyyy", $receiveHeader->receive_item_date); ?></td>
            </tr>
            <tr>
                <td width="15%">Supplier SJ#</td>
                <td><?php echo $receiveHeader->supplier_delivery_number; ?></td>
            </tr>
            <tr>
                <td colspan="2">
                    <?php //if ($receiveHeader->request_type != 'Internal Delivery Order'): ?>
                        <?php echo CHtml::link('<span class="fa fa-plus"></span>Add / Edit Supporting Docs', Yii::app()->baseUrl . '/transaction/transactionReceiveItem/addInvoice?id=' . $receiveHeader->id, array('visible' => Yii::app()->user->checkAccess("transaction.transactionReceiveItem.update"))) ?>
                    <?php //endif; ?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <?php $receiveDetails= TransactionReceiveItemDetail::model()->findAllByAttributes(array('receive_item_id'=>$receive->id));?>
                    <table>
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Code</td>
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
                                    <td><?php echo $receiveDetail->product->id; ?></td>
                                    <td><?php echo $receiveDetail->product->manufacturer_code; ?></td>
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