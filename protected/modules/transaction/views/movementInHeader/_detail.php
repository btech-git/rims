<?php if (!empty($movementIn->details)): ?>
    <table>
        <thead>
            <tr>
                <th class="required">ID</th>
                <th class="required">Code</th>
                <th class="required">Product</th>
                <th class="required">Transaction Quantity</th>
                <!--<th class="required">Warehouses</th>-->
                <th class="required">Warehouse</th>
                <th class="required">Quantity</th>
                <th>Action</th>
            </tr>
        </thead>
        
        <tbody>
            <?php foreach ($movementIn->details as $i => $detail): ?>
                <tr>
                    <td><?php echo CHtml::encode(CHtml::value($detail, "product.id")); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($detail, "product.manufacturer_code")); ?></td>
                    
                    <td>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]receive_item_detail_id", array('size' => 20, 'maxlength' => 20)); ?>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]return_item_detail_id", array('size' => 20, 'maxlength' => 20)); ?>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]product_id", array('size' => 20, 'maxlength' => 20)); ?>
                        <?php echo CHtml::activeTextField($detail, "[$i]product_name", array('size' => 20, 'maxlength' => 20, 'readonly' => true, 'value' => $detail->product_id != "" ? $detail->product->name : '')); ?>
                    </td>
                    
                    <td><?php echo CHtml::activeTextField($detail, "[$i]quantity_transaction", array('readonly' => true)); ?></td>
                    
<!--                    <td>
                        <table>
                            <tr>
                                <?php //foreach ($warehouses as $key => $warehouse) : ?>
                                <?php /*
                                    $inventory = Inventory::model()->findByAttributes(array('product_id' => $detail->product_id, 'warehouse_id' => $detail->warehouse_id));
                                    $stock = !empty($inventory) != 0 ? $inventory->total_stock : 0;
                                ?>
                                    <?php if ($stock < 0): ?>
                                        <td><?php echo $warehouse->name . '- ( ' . $stock . ' )'; ?></td>
                                    <?php endif;*/ ?>
                                <?php //endforeach; ?>
                            </tr>
                        </table>
                    </td>-->
                    
                    <td>
                        <?php echo CHtml::encode(CHtml::value($detail, "warehouse.name")); ?>
                        <?php //echo CHtml::activeDropDownList($detail, "[$i]warehouse_id", CHtml::listData($warehouses, 'id', 'name'), array('prompt' => '[--Select Warehouse--]')); ?>
                    </td>
                    <td>
                        <?php if ($movementIn->header->isNewRecord): ?>
                            <?php echo CHtml::activeTextField($detail, "[$i]quantity", array(
                                'class' => 'qtyleft_input productID_' . $detail->product_id, 
                                'rel' => $detail->product_id,
                                'onchange'=> '
                                    var qty = +jQuery("#MovementInDetail_'.$i.'_quantity").val();
                                    var temp = +jQuery("#MovementInDetail_'.$i.'_quantity_transaction").val();
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

                    <td>
                        <?php echo CHtml::button('X', array(
                            'onclick' => CHtml::ajax(array(
                                'type' => 'POST',
                                'url' => CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $movementIn->header->id, 'index' => $i)),
                                'update' => '#mmtype',
                            )),
                        )); ?>
                    </td>
                </tr>	
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
