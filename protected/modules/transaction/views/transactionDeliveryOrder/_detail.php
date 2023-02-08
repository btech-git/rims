
<?php if ($deliveryOrder->header->request_type == 'Sales Order'){
    $itemHeaders= TransactionDeliveryOrder::model()->findAllByAttributes(array('sales_order_id'=>$deliveryOrder->header->sales_order_id));
}elseif ($deliveryOrder->header->request_type == 'Sent Request'){ ?>
    <?php $itemHeaders= TransactionDeliveryOrder::model()->findAllByAttributes(array('sent_request_id'=>$deliveryOrder->header->sent_request_id)); ?>
<?php }else $itemHeaders= array(); ?>

<?php if (count($itemHeaders)!= 0): ?>
    <table>
        <caption>History</caption>
        <thead>
            <tr>
                <th>Product</th>
                <th>Qty Request</th>
                <th>Qty Delivery</th>
                <th>Qty Request Left</th>
                <th>Unit</th>
                <th>Note</th>
                <th>Barcode</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($itemHeaders as $key => $itemHeader): ?>
                <?php $deliveryDetails = TransactionDeliveryOrderDetail::model()->findAllByAttributes(array('delivery_order_id'=>$itemHeader->id)); ?>
                <?php foreach ($deliveryDetails as $key => $deliveryDetail): ?>
                    <tr>
                        <td><?php echo $deliveryDetail->product->name; ?></td>
                        <td><?php echo $deliveryDetail->quantity_request; ?></td>
                        <td><?php echo $deliveryDetail->quantity_delivery; ?></td>
                        <td><?php echo $deliveryDetail->quantity_request_left; ?></td>
                        <td><?php echo $deliveryDetail->product->unit->name; ?></td>
                        <td><?php echo $deliveryDetail->note; ?></td>
                        <td><?php echo $deliveryDetail->barcode_product; ?></td>
                    </tr>
                    <tr>
                        <td colspan="7">
                            Code: <?php echo CHtml::encode(CHtml::value($deliveryDetail, "product.manufacturer_code")); ?> ||
                            Kategori: <?php echo CHtml::encode(CHtml::value($deliveryDetail, "product.masterSubCategoryCode")); ?> ||
                            Brand: <?php echo CHtml::encode(CHtml::value($deliveryDetail, "product.brand.name")); ?> ||
                            Sub Brand: <?php echo CHtml::encode(CHtml::value($deliveryDetail, "product.subBrand.name")); ?> ||
                            Sub Brand Series: <?php echo CHtml::encode(CHtml::value($deliveryDetail, "product.subBrandSeries.name")); ?> 
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php endforeach ?>
        </tbody>
    </table>
<?php endif; ?>

<?php if(count($deliveryOrder->details) != 0) {	?>
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Qty Request</th>
                <th>Qty Request Left</th>
                <th>Qty Delivery</th>
                <th>Unit</th>
                <th>Note</th>
                <th>Barcode</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($deliveryOrder->details as $i => $detail): ?>
                <tr>
                    <td>
                        <?php echo CHtml::activeHiddenField($detail,"[$i]product_id");  ?>
                        <?php echo CHtml::activeHiddenField($detail,"[$i]sales_order_detail_id");  ?>
                        <?php echo CHtml::activeHiddenField($detail,"[$i]sent_request_detail_id");  ?>
                        <?php echo CHtml::activeHiddenField($detail,"[$i]transfer_request_detail_id");  ?>
                        <?php echo CHtml::activeHiddenField($detail,"[$i]consignment_out_detail_id");  ?>
                        <?php $product = Product::model()->findByPK($detail->product_id); ?>
                        <?php echo CHtml::activeTextField($detail,"[$i]product_name",array('value'=>$product->name,'readOnly'=>true));  ?>
                    </td>
                    <td><?php echo CHtml::activeTextField($detail,"[$i]quantity_request",array('readOnly'=>true));  ?></td>
                    <td><?php echo CHtml::activeTextField($detail,"[$i]quantity_request_left",array('readOnly'=>true));  ?></td>
                    <td>
                        <?php echo CHtml::activeTextField($detail,"[$i]quantity_delivery",array('onchange'=>
                            'var quantity = +jQuery("#TransactionDeliveryOrderDetail_'.$i.'_quantity_request").val();
                            var delivery = +jQuery("#TransactionDeliveryOrderDetail_'.$i.'_quantity_delivery").val();
                            var temp = +jQuery("#TransactionDeliveryOrderDetail_'.$i.'_quantity_request_left").val();
                            var count = temp - delivery;

                            if(count <0)
                            {
                                alert("QTY Delivery could not be less than QTY LEFT.");
                                $( "#save" ).prop( "disabled", true );
                            }else{
                                $( "#save" ).prop( "disabled", false );

                            }
                            //jQuery("#TransactionDeliveryOrderDetail_'.$i.'_quantity_request_left").val(count);
                            console.log(count);
                            '
                        ));  ?>
                    </td>
                    <td><?php echo $detail->product->unit->name; ?></td>
                    <td><?php echo CHtml::activeTextField($detail,"[$i]note");  ?></td>
                    <td><?php echo CHtml::activeTextField($detail,"[$i]barcode_product"); ?></td>
                    <td>
                        <?php echo CHtml::button('X', array(
                            'onclick' => CHtml::ajax(array(
                                'type' => 'POST',
                                'url' => CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $deliveryOrder->header->id, 'index' => $i)),
                                'update' => '.detail',
                            )),
                        )); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="8">
                        Code: <?php echo CHtml::encode(CHtml::value($detail, "product.manufacturer_code")); ?> ||
                        Kategori: <?php echo CHtml::encode(CHtml::value($detail, "product.masterSubCategoryCode")); ?> ||
                        Brand: <?php echo CHtml::encode(CHtml::value($detail, "product.brand.name")); ?> ||
                        Sub Brand: <?php echo CHtml::encode(CHtml::value($detail, "product.subBrand.name")); ?> ||
                        Sub Brand Series: <?php echo CHtml::encode(CHtml::value($detail, "product.subBrandSeries.name")); ?> 
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php } ?>
	