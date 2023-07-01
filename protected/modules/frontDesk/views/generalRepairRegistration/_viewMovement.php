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
                </tr>
            </thead>

            <tbody>
                <?php foreach ($movementOutHeaders as $i => $movementOutHeader): ?>
                    <?php foreach ($movementOutHeader->movementOutDetails as $i => $movementOutDetail): ?>
                        <tr>
                            <td><?php echo CHtml::link($movementOutHeader->movement_out_no, array("/transaction/movementOut/view", "id"=>$movementOutHeader->id)); ?></td>
                            <td><?php echo $movementOutHeader->date_posting; ?></td>
                            <td><?php echo $movementOutHeader->status; ?></td>
                            <td><?php echo $movementOutDetail->product->name; ?></td>
                            <td><?php echo number_format($movementOutDetail->quantity,0); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <?php echo "NO Movement Out"; ?>
<?php endif; ?>