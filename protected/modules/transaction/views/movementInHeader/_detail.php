<?php if (!empty($movementIn->details)): ?>
    <table>
        <thead>
            <tr>
                <th class="required">Product</th>
                <th class="required">Transaction Quantity</th>
                <th class="required">Warehouses</th>
                <th class="required">Warehouse</th>
                <th class="required">Quantity</th>
                <th>Action</th>
            </tr>
        </thead>
        
        <tbody>
            <?php foreach ($movementIn->details as $i => $detail): ?>
                <?php
                $branchId = isset($_POST['MovementInHeader']['branch_id']) ? $_POST['MovementInHeader']['branch_id'] : $movementIn->header->branch_id;
                $warehouses = Warehouse::model()->findAllByAttributes(array('branch_id' => $branchId));
                $list = CHtml::listData($warehouses, 'id', 'name');
                ?>
                <tr>
                    <td>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]receive_item_detail_id", array('size' => 20, 'maxlength' => 20)); ?>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]return_item_detail_id", array('size' => 20, 'maxlength' => 20)); ?>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]product_id", array('size' => 20, 'maxlength' => 20)); ?>
                        <?php echo CHtml::activeTextField($detail, "[$i]product_name", array('size' => 20, 'maxlength' => 20, 'readonly' => true, 'value' => $detail->product_id != "" ? $detail->product->name : '')); ?>
                    </td>
                    
                    <td><?php echo CHtml::activeTextField($detail, "[$i]quantity_transaction", array('readonly' => true)); ?></td>
                    
                    <td>
                        <table>
                            <tr>
                                <?php foreach ($warehouses as $key => $warehouse) :
                                    $inventory = Inventory::model()->findByAttributes(array('product_id' => $detail->product_id, 'warehouse_id' => $warehouse->id));
                                    $stock = !empty($inventory) != 0 ? $inventory->total_stock : 0;
                                ?>
                                    <td><?php echo $warehouse->name . '- ( ' . $stock . ' )'; ?></td>
                                <?php endforeach; ?>
                            </tr>
                        </table>
                    </td>
                    
                    <td><?php echo CHtml::activeDropDownList($detail, "[$i]warehouse_id", $list, array('prompt' => '[--Select Warehouse--]')); ?></td>
                    <td><?php echo CHtml::activeTextField($detail, "[$i]quantity", array('class' => 'qtyleft_input productID_' . $detail->product_id, 'rel' => $detail->product_id)); ?></td>

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
