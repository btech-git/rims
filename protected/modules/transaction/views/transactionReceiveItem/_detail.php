	<?php
if ($receiveItem->header->request_type == 'Purchase Order') {
    $itemHeaders = TransactionReceiveItem::model()->findAllByAttributes(array('purchase_order_id' => $receiveItem->header->purchase_order_id));
} elseif ($receiveItem->header->request_type == 'Transfer Request') {
    ?>
    <?php $itemHeaders = TransactionReceiveItem::model()->findAllByAttributes(array('transfer_request_id' => $receiveItem->header->transfer_request_id)); ?>
<?php } else $itemHeaders = array(); ?>

<?php if (count($itemHeaders) != 0): ?>
    <table>
        <caption>History</caption>
        <thead>
            <tr>
                <td>Product</td>
                <td>Code</td>
                <td>Kategori</td>
                <td>Brand</td>
                <td>Sub Brand</td>
                <td>Sub Brand Series</td>
                <td>Qty Request</td>
                <td>Qty Received</td>
                <td>Qty Request Left</td>
                <td>Unit</td>
                <td>Note</td>
                <!--<td>Barcode</td>-->
                <td>&nbsp;</td>
            </tr>
        </thead>
        
        <tbody>
            <?php foreach ($itemHeaders as $key => $itemHeader): ?>
                <?php $receiveItemDetails = TransactionReceiveItemDetail::model()->findAllByAttributes(array('receive_item_id' => $itemHeader->id)); ?>
                <?php foreach ($receiveItemDetails as $key => $receiveItemDetail): ?>
                    <tr>
                        <td><?php echo $receiveItemDetail->product->name; ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($receiveItemDetail, 'product.manufacturer_code')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($receiveItemDetail, 'product.masterSubCategoryCode')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($receiveItemDetail, 'product.brand.name')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($receiveItemDetail, 'product.subBrand.name')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($receiveItemDetail, 'product.subBrandSeries.name')); ?></td>
                        <td><?php echo $receiveItemDetail->qty_request; ?></td>
                        <td><?php echo $receiveItemDetail->qty_received; ?></td>
                        <td><?php echo $receiveItemDetail->qty_request_left; ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($receiveItemDetail, 'product.unit.name')); ?></td>
                        <td><?php echo $receiveItemDetail->note; ?></td>
                        <!--<td><?php // echo $receiveItemDetail->barcode_product; ?></td>-->
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php if (count($receiveItem->details) != 0) { ?>
    <?php $request = isset($_POST['TransactionReceiveItem']['request_type']) ? $_POST['TransactionReceiveItem']['request_type'] : $receiveItem->header->request_type; ?>
    <table>
        <thead>
            <tr>
                <td>Product</td>
                <td>Code</td>
                <td>Kategori</td>
                <td>Brand</td>
                <td>Sub Brand</td>
                <td>Sub Brand Series</td>
                <td>Qty Order</td>
                <td class ="additional <?php echo $request != "Internal Delivery Order" ? 'hide' : ''; ?>">Qty Delivered Left</td>
                <td>Qty Order Remaining</td>
                <td>Qty Received</td>
                <td>Unit</td>
                <td>Note</td>
                <!--<td>Barcode</td>-->
                <td>&nbsp;</td>
            </tr>
        </thead>
        
        <tbody>
            <?php foreach ($receiveItem->details as $i => $detail): ?>
                <tr>
                    <td>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]purchase_order_detail_id"); ?>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]transfer_request_detail_id"); ?>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]delivery_order_detail_id"); ?>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]consignment_in_detail_id"); ?>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]product_id"); ?>
                        <?php $receiveItemDetail = Product::model()->findByPK($detail->product_id); ?>
                        <?php echo CHtml::activeTextField($detail, "[$i]product_name", array('value' => $receiveItemDetail->name, 'readOnly' => true)); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($receiveItemDetail, 'manufacturer_code')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($receiveItemDetail, 'masterSubCategoryCode')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($receiveItemDetail, 'brand.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($receiveItemDetail, 'subBrand.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($receiveItemDetail, 'subBrandSeries.name')); ?></td>
                    <td><?php echo CHtml::activeTextField($detail, "[$i]qty_request", array('readOnly' => true)); ?></td>
                    <?php
                    $deliverValue = "";
                    if ($request == "Internal Delivery Order") {
                        $delivered = TransactionDeliveryOrderDetail::model()->findByPK($detail->delivery_order_detail_id);
                        $deliverValue = $delivered->quantity_delivery;
                    }
                    ?>
                    <td class="additional <?php echo $request != "Internal Delivery Order" ? 'hide' : ''; ?>">
                        <?php echo CHtml::activeHiddenField($detail, "[$i]quantity_delivered", array('readOnly' => true,)); ?>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]quantity_delivered_left", array('readOnly' => true,)); ?>
                        <?php echo CHtml::encode(CHtml::value($detail, 'quantity_delivered_left')); ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]qty_request_left", array('rel' => $detail->qty_request_left, 'readOnly' => true,)); ?>
                        <?php echo CHtml::encode(CHtml::value($detail, 'qty_request_left')); ?>
                    </td>
                    <td>
                        <?php if ($receiveItem->header->isNewRecord): ?>
                            <?php echo CHtml::activeTextField($detail, "[$i]qty_received", array(
                                'onchange' => '
                                    var quantity = +jQuery("#TransactionReceiveItemDetail_' . $i . '_quantity_delivered").val();
                                    var delivery = +jQuery("#TransactionReceiveItemDetail_' . $i . '_qty_received").val();
                                    var temp = +jQuery("#TransactionReceiveItemDetail_' . $i . '_qty_request_left").val();
                                    var count = temp - delivery;

                                    if (count < 0) {
                                        alert("QTY Received could not be less than QTY Remaining.");
                                        $( "#save" ).prop( "disabled", true );
                                    } else {
                                        $( "#save" ).prop( "disabled", false );
                                    }
                                    //jQuery("#TransactionReceiveItemDetail_' . $i . '_qty_request_left").val(count);
//                                    console.log(count);
                                '
                            )); ?>
                        <?php else: ?>
                            <?php echo CHtml::activeTextField($detail, "[$i]qty_received"); ?> 
                        <?php endif; ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($receiveItemDetail, 'brand.name')); ?></td>
                    <td><?php echo CHtml::activeTextField($detail, "[$i]note"); ?></td>
                    <!--<td><?php //echo CHtml::activeTextField($detail, "[$i]barcode_product"); ?></td>-->
                    <td>
                        <?php echo CHtml::button('X', array(
                            'onclick' => CHtml::ajax(array(
                                'type' => 'POST',
                                'url' => CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $receiveItem->header->id, 'index' => $i)),
                                'update' => '.detail',
                            )),
                        )); ?>
                    </td>
                </tr>
                
                <tr>
                    <td colspan="13">
                        <div class="row">
                            <div class="small-12 columns" style="padding-left: 0px; padding-right: 0px;">
                                <table>
                                    <thead>
                                        <tr>
                                            <?php foreach ($branches as $branch): ?>
                                                <th style="text-align: center"><?php echo CHtml::encode(CHtml::value($branch, 'code')); ?></th>
                                            <?php endforeach; ?>
                                            <th style="text-align: center">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php $inventoryTotalQuantities = $receiveItemDetail->getInventoryTotalQuantities(); ?>
                                            <?php $totalStock = 0; ?>
                                            <?php foreach ($branches as $branch): ?>
                                                <?php $index = -1; ?>
                                                <?php foreach ($inventoryTotalQuantities as $i => $inventoryTotalQuantity): ?>
                                                    <?php if ($inventoryTotalQuantity['branch_id'] == $branch->id): ?>
                                                        <?php $index = $i; ?>
                                                        <?php break; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <?php if ($index >= 0): ?>
                                                    <td>
                                                        <?php echo CHtml::encode(CHtml::value($inventoryTotalQuantities[$i], 'total_stock')); ?>
                                                        <?php $totalStock += CHtml::value($inventoryTotalQuantities[$i], 'total_stock'); ?>
                                                    </td>
                                                <?php else: ?>
                                                    <td>0</td>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            <td><?php echo CHtml::encode($totalStock); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php } ?>
	