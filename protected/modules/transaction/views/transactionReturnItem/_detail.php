<?php if (count($returnItem->details) != 0) { ?>
    <table>
        <thead>
            <tr>
                <td>Product</td>
                <td>Code</td>
                <td>Kategori</td>
                <td>Brand</td>
                <td>Sub Brand</td>
                <td>Sub Brand Series</td>
                <td>Qty Delivery</td>
                <td>Qty Return</td>
                <td>Unit</td>
                <td>Note</td>
                <td>Barcode</td>
                <td></td>
            </tr>
        </thead>
        
        <tbody>
            <?php foreach ($returnItem->details as $i => $detail): ?>
                <tr>
                    <td>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]product_id"); ?>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]return_type"); ?>
                        <?php $product = Product::model()->findByPK($detail->product_id); ?>
                        <?php echo CHtml::activeTextField($detail, "[$i]product_name", array('value' => $product->name, 'readOnly' => true)); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'manufacturer_code')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'masterSubCategoryCode')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'brand.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'subBrand.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'subBrandSeries.name')); ?></td>
                    <td>
                        <?php echo CHtml::hiddenField("quantity_delivery_{$i}", ($quantityDelivered = $detail->quantity_delivery)); ?>
                        <?php echo CHtml::activeTextField($detail, "[$i]quantity_delivery", array('readOnly' => true)); ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeTextField($detail, "[$i]quantity", array(
                            'onchange' => 'if (parseInt($(this).val()) > parseInt($("#quantity_delivery_' . $i . '").val())) $(this).val($("#quantity_delivery_' . $i . '").val())'
                        )); ?>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]price"); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'unit.name')); ?></td>
                    <td><?php echo CHtml::activeTextField($detail, "[$i]note"); ?></td>
                    <td><?php echo CHtml::activeTextField($detail, "[$i]barcode_product"); ?></td>
                    <td>
                        <?php echo CHtml::button('X', array(
                            'onclick' => CHtml::ajax(array(
                                'type' => 'POST',
                                'url' => CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $returnItem->header->id, 'index' => $i)),
                                'update' => '.detail',
                            )),
                        )); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php } ?>
	