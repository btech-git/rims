<?php if (count($products) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Product name</th>
                <th>Quantity</th>
                <th>Retail Price</th>
                <?php if (Yii::app()->user->checkAccess('director')): ?>
                    <th>HPP</th>
                <?php endif; ?>
                <th>Sale Price</th>
                <th>Discount Type</th>
                <th>Discount</th>
                <th>Total Price</th>
                <th>Quantity Movement</th>
                <th>Quantity Movement left</th>
                <th>Quantity Receive</th>
                <th>Quantity Receive left</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $i => $product): ?>
                <tr>
                    <td><?php echo $product->product->name; ?></td>
                    <td><?php echo $product->quantity; ?></td>
                    <td><?php echo number_format($product->retail_price, 2); ?></td>
                    <?php if (Yii::app()->user->checkAccess('director')): ?>
                        <td><?php echo number_format($product->hpp, 2); ?></td>
                    <?php endif; ?>
                    <td><?php echo number_format($product->sale_price, 2); ?></td>
                    <td><?php echo $product->discount_type; ?></td>
                    <td><?php echo $product->discount_type == 'Percent' ? $product->discount : number_format($product->discount, 0); ?></td>
                    <td><?php echo number_format($product->total_price, 2); ?></td>
                    <td><?php echo $product->quantity_movement; ?></td>
                    <td><?php echo $product->quantity_movement_left; ?></td>
                    <td><?php echo $product->quantity_receive; ?></td>
                    <td><?php echo $product->quantity_receive_left; ?></td>
                    <td>
                        <?php echo CHtml::tag('button', array(
                            // 'name'=>'btnSubmit',
                            'type' => 'button',
                            'class' => 'hello button expand',
                            'onclick' => '$("#detail-' . $product->id . '").toggle();'
                        ), '<span class="fa fa-caret-down">&nbsp;</span>'); ?>
                    </td>

                </tr>
                <tr>
                    <td id="detail-<?php echo $product->id ?>" class="hide" colspan=12>
                        <?php $getMovementDetails = MovementOutDetail::model()->findAllByAttributes(array('registration_product_id' => $product->id)); ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Movement #</th>
                                    <th>Quantity Movement</th>
                                    <th>Quantity Received</th>
                                    <th>Quantity Received Left</th>

                                </tr>
                            </thead>
                            <?php foreach ($getMovementDetails as $i => $md): ?>
                                <tr>
                                    <td>
                                        <?php echo $md->movementOutHeader->movement_out_no; ?>
                                        <input type="hidden" id="movementOut-<?php echo $i ?>" value="<?php echo $md->movement_out_header_id; ?>">
                                        <input type="hidden" id="movementOutDetail-<?php echo $i ?>" value="<?php echo $md->id; ?>">
                                    </td>
                                    <td><input type="text" id="quantityMovement-<?php echo $i ?>" value="<?php echo $md->quantity ?>" readonly="true"></td>
                                    <td><input type="text" id="quantityReceived-<?php echo $i ?>" value="<?php echo $md->quantity_receive ?>" readonly="true"></td>
                                    <td><input type="text" id="quantityReceivedLeft-<?php echo $i ?>" value="<?php echo $md->quantity_receive_left ?>" readonly="true"></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
