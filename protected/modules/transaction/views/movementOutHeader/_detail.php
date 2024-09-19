<?php if (!empty($movementOut->details)): ?>
    <table>
        <thead>
            <tr>
                <th class="required">ID</th>
                <th class="required">Product</th>
                <th>Code</th>
                <th>Kategori</th>
                <th>Brand</th>
                <th>Sub Brand</th>
                <th>Sub Brand Series</th>
                <th class="required">Warehouse</th>
                <th class="required">Qty Req</th>
                <th class="required">Qty Out</th>
                <th class="required">Satuan</th>
                <th>Action</th>
            </tr>
        </thead>
        
        <tbody>
            <?php foreach ($movementOut->details as $i => $detail): ?>
                <?php $product = Product::model()->findByPK($detail->product_id); ?>
                <tr>
                    <td><?php echo CHtml::encode(CHtml::value($detail, "product.id")); ?></td>
                    <td>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]delivery_order_detail_id"); ?>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]return_order_detail_id"); ?>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]registration_product_id"); ?>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]material_request_detail_id"); ?>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]product_id"); ?>
                        <?php echo CHtml::activeTextField($detail, "[$i]product_name", array('size' => 20, 'maxlength' => 20, 'readonly' => true, 'value' => $detail->product_id != "" ? $detail->product->name : '')); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'manufacturer_code')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'masterSubCategoryCode')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'brand.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'subBrand.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'subBrandSeries.name')); ?></td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($detail, "warehouse.name")); ?>
                        <?php //echo CHtml::activeDropDownList($detail, "[$i]warehouse_id", CHtml::listData($warehouses, 'id', 'name'), array('prompt' => '[--Select Warehouse--]', 'readonly' => 'readonly')); ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]quantity_transaction"); ?>
                        <?php echo CHtml::encode(CHtml::value($detail, 'quantity_transaction')); ?>
                    </td>
                    <td>
                        <?php if ($movementOut->header->isNewRecord): ?>
                        <?php echo CHtml::activeTextField($detail, "[$i]quantity", array(
                            'class' => 'qtyleft_input productID_' . $detail->product_id, 
                            'rel' => $detail->product_id,
                            'onchange'=> '
                                var qty = +jQuery("#MovementOutDetail_'.$i.'_quantity").val();
                                var temp = +jQuery("#MovementOutDetail_'.$i.'_quantity_transaction").val();
                                var count = temp - qty;

                                if (count < 0) {
                                    alert("QTY Movement could not be less than QTY LEFT.");
                                    $( "#save" ).prop( "disabled", true );
                                } else {
                                    $( "#save" ).prop( "disabled", false );
                                }
                            ',
                        )); ?>
                        <?php else: ?>
                            <?php echo CHtml::activeTextField($detail, "[$i]quantity"); ?> 
                        <?php endif; ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo CHtml::activeHiddenField($detail, "[$i]unit_id"); ?>
                        <?php echo CHtml::encode(CHtml::value($detail, 'unit.name')); ?>
                        <?php echo CHtml::error($detail, 'unit_id'); ?>
                    </td>
                    <td>
                        <?php echo CHtml::button('X', array(
                            'onclick' => CHtml::ajax(array(
                                'type' => 'POST',
                                'url' => CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $movementOut->header->id, 'index' => $i)),
                                'update' => '#mmtype',
                            )),
                        )); ?>
                    </td>
                </tr>	
                <tr>
                    <td colspan="12">
                        <?php //foreach ($warehouses as $key => $warehouse):
                        ?>
                        <?php 
                            $inventory = Inventory::model()->findByAttributes(array('product_id' => $detail->product_id, 'warehouse_id' => $detail->warehouse_id));
                            $stock = !empty($inventory) ? $inventory->total_stock : 0;
                        ?>
                            <?php if ($stock < 0): ?>
                                <?php echo $warehouse->name . '- ( ' . $stock . ' )'; ?>
                            <?php endif; ?>
                        <?php //endforeach; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
