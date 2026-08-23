<?php
$deliveryOrders = TransactionDeliveryOrder::model()->findAllByAttributes(array('transfer_request_id' => $model->id));
if (count($deliveryOrders) != 0) {
    foreach ($deliveryOrders as $key => $deliveryOrder) :
        ?>
        <table>
            <tr>
                <td width="20%">Delivery Order No</td>
                <td><?php echo CHTml::link($deliveryOrder->delivery_order_no, array("/transaction/transactionDeliveryOrder/show", "id" => $deliveryOrder->id), array('target' => 'blank')); ?></td>
            </tr>
            <tr>
                <td  width="20%">Date Delivery</td>
                <td><?php echo $deliveryOrder->posting_date; ?></td>
            </tr>
            <tr>
                <td  width="20%">Quantity Delivered</td>
                <td><?php echo $deliveryOrder->totalQuantityDelivered; ?></td>
            </tr>
            <?php
            $receives = TransactionReceiveItem::model()->findAllByAttributes(array('delivery_order_id' => $deliveryOrder->id));
            if (count($receives) != 0) :
                foreach ($receives as $receive) :
                    ?>
                    <tr>
                        <td colspan="2">
                            <table>
                                <thead>
                                    <tr>
                                        <td>Receive No</td>
                                        <td>Receive Date</td>
                                        <td>Product</td>
                                        <td>QTY Request</td>
                                        <td>QTY Delivered</td>
                                        <td>QTY Received</td>									
                                        <td>QTY Delivered LEFT</td>
                                        <td>QTY Request LEFT</td>
                                        <td>Note</td>
                                        <!--<td>Barcode Product</td>-->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $totalQuantity = 0; ?>
                                    <?php $receiveDetails = TransactionReceiveItemDetail::model()->findAllByAttributes(array('receive_item_id' => $receive->id)); ?>
                                    <?php foreach ($receiveDetails as $receiveDetail) : ?>
                                        <?php $quantityReceived = CHtml::encode(CHtml::value($receiveDetail, 'qty_received')); ?>
                                        <tr>
                                            <td><?php echo CHTml::link($receive->receive_item_no, array("/transaction/transactionReceiveItem/show", "id" => $receive->id), array('target' => 'blank')); ?></td>
                                            <td><?php echo CHtml::encode(CHtml::value($receive, 'receive_item_date')); ?></td>
                                            <td><?php echo CHtml::encode(CHtml::value($receiveDetail, 'product.name')); ?></td>
                                            <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($receiveDetail, 'qty_request')); ?></td>
                                            <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($receiveDetail, 'quantity_delivered')); ?></td>
                                            <td style="text-align: center"><?php echo $quantityReceived; ?></td>
                                            <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($receiveDetail, 'quantity_delivered_left')); ?></td>
                                            <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($receiveDetail, 'qty_request_left')); ?></td>
                                            <td><?php echo CHtml::encode(CHtml::value($receiveDetail, 'note')); ?></td>
                                            <!--<td><?php //echo $receiveDetail->barcode_product; ?></td>-->
                                        </tr>
                                        <?php $totalQuantity += $quantityReceived; ?>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" style="text-align: right; font-weight: bold">TOTAL</td>
                                        <td style="text-align: center; font-weight: bold"><?php echo CHtml::encode($totalQuantity); ?></td>
                                        <td colspan="3">&nbsp;</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </td>
                    </tr>
            <?php
            endforeach; //endforeach receive Item 
        endif; //end if count receive				
        ?>
        </table>

    <?php endforeach; ?>

    <?php
} else {
    echo "NO RECEIVE HISTORY FOUND.";
}
?>