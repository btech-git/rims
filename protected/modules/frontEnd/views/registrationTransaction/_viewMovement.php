<fieldset>
    <table class="table table-bordered table-primary">
        <thead>
            <tr class="table-primary">
                <th>ID</th>
                <th>Code</th>
                <th>Product name</th>
                <th>Quantity</th>
                <th>Qty Movement</th>
                <th>Qty Movement left</th>
            </tr>
            <tr class="table-secondary">
                <th>Movement Number</th>
                <th>Date</th>
                <th>Status</th>
                <th>Quantity Transaction</th>
                <th>Quantity Movement</th>
                <th>Quantity Stock</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $i => $product): ?>
                <tr class="table-light">
                    <td><?php echo $product->product->id; ?></td>
                    <td><?php echo $product->product->manufacturer_code; ?></td>
                    <td><?php echo $product->product->name; ?></td>
                    <td class="text-center"><?php echo $product->quantity; ?></td>
                    <td class="text-center"><?php echo $product->quantity_movement; ?></td>
                    <td class="text-center"><?php echo $product->quantity_movement_left; ?></td>
                </tr>
                <?php $movementOutDetails = MovementOutDetail::model()->findAllByAttributes(array('registration_product_id'=>$product->id), array('order' => 't.id ASC')); ?>
                <?php if (count($movementOutDetails) > 0): ?>
                    <?php foreach ($movementOutDetails as $i => $movementOutDetail): ?>
                        <tr class="table-secondary">
                            <td><?php echo CHtml::encode(CHtml::value($movementOutDetail, 'movementOutHeader.movement_out_no')); ?></td>
                            <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy", CHtml::value($movementOutDetail, 'movementOutHeader.date_posting'))); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($movementOutDetail, 'movementOutHeader.status')); ?></td>
                            <td class="text-center"><?php echo CHtml::encode(number_format(CHtml::value($movementOutDetail, 'quantity_transaction'),0)); ?></td>
                            <td class="text-center"><?php echo CHtml::encode(number_format(CHtml::value($movementOutDetail, 'quantity'),0)); ?></td>
                            <td class="text-center"><?php echo CHtml::encode(number_format(CHtml::value($movementOutDetail, 'quantity_stock'),0)); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr class="table-secondary">
                        <td colspan="6" class="text-center"><?php echo "NO Movement Out"; ?></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>