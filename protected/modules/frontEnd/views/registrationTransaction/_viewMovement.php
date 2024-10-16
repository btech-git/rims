<?php $movementOutHeaders = MovementOutHeader::model()->findAllByAttributes(array('registration_transaction_id'=>$model->id), array('order' => 't.id ASC', 'limit' => 10)); ?>
<?php if (count($movementOutHeaders) > 0): ?>
    <div class="detail">
        <table>
            <thead>
                <tr>
                    <th>Movement Number</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Qty Left</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($movementOutHeaders as $i => $movementOutHeader): ?>
                    <?php foreach ($movementOutHeader->movementOutDetails as $i => $movementOutDetail): ?>
                        <tr>
                            <td>
                                <?php //echo CHtml::link($movementOutHeader->movement_out_no, array("/transaction/movementOutHeader/view", "id"=>$movementOutHeader->id), array('target' => 'blank')); ?>
                                <?php echo CHtml::encode(CHtml::value($movementOutHeader, 'movement_out_no')); ?>
                            </td>
                            <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy H:m:s", CHtml::value($movementOutHeader, 'date_posting'))); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($movementOutHeader, 'status')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($movementOutDetail, 'product.name')); ?></td>
                            <td><?php echo CHtml::encode(number_format(CHtml::value($movementOutDetail, 'quantity'),0)); ?></td>
                            <td><?php echo number_format($movementOutDetail->registrationProduct->quantity_movement_left,0); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <?php echo "NO Movement Out"; ?>
<?php endif; ?>