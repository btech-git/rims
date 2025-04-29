<div class="large-12 columns">
    <fieldset>
        <legend>Movement Out</legend>
        <table>
            <thead>
                <tr>
                    <th>MO #</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>RG #</th>
                    <th>Warehouse</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($movementOutData as $movementOutItem): ?>
                    <tr>
                        <td><?php echo CHtml::encode(CHtml::value($movementOutItem, 'movementOutHeader.movement_out_no')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($movementOutItem, 'movementOutHeader.date_posting')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($movementOutItem, 'movementOutHeader.status')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($movementOutItem, 'movementOutHeader.registrationTransaction.transaction_number')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($movementOutItem, 'warehouse.name')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($movementOutItem, 'quantity')); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </fieldset>
</div>