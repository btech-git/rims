<?php if ($model->vehicle_id != ""): ?>
    <?php $historyTransactions = RegistrationTransaction::model()->findAllByAttributes(array('vehicle_id'=>$model->vehicle_id), array('order' => 't.id DESC', 'limit' => 50)); ?>
    <?php if (count($historyTransactions) > 0): ?>
        <div class="detail">
            <table>
                <thead>
                    <tr>
                        <th>Transaction Number</th>
                        <th>Transaction Date</th>
                        <th>Quick Service</th>
                        <th>Repair Type</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php foreach ($historyTransactions as $i => $historyTransaction): ?>
                        <tr>
                            <td><?php echo $historyTransaction->transaction_number; ?></td>
                            <td><?php echo $historyTransaction->transaction_date; ?></td>
                            <td><?php echo $historyTransaction->is_quick_service == 1 ? 'Yes' : 'No'; ?></td>
                            <td><?php echo $historyTransaction->repair_type; ?></td>
                            <td><?php echo number_format($historyTransaction->grand_total,0); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <?php echo "NO HISTORY"; ?>
    <?php endif; ?>
<?php endif; ?>