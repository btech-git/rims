<fieldset>
    <?php $historyTransactions = RegistrationTransaction::model()->findAllByAttributes(array('vehicle_id'=>$model->vehicle_id), array('order' => 't.id DESC', 'limit' => 10)); ?>
	
    <table class="table table-bordered table-primary">
        <thead>
            <tr class="table-primary">
                <th>Transaction Number</th>
                <th>Tanggal</th>
                <th>Quick Service</th>
                <th>Repair Type</th>
                <th>Total Jasa</th>
                <th>Total Produk</th>
                <th>Total Price</th>
            </tr>
        </thead>

        <tbody>
            <?php if (count($historyTransactions) > 0): ?>
                <?php foreach ($historyTransactions as $i => $historyTransaction): ?>
                    <tr class="table-light">
                        <td><?php echo $historyTransaction->transaction_number; ?></td>
                        <td><?php echo Yii::app()->dateFormatter->format("d MMMM yyyy", $historyTransaction->transaction_date); ?></td>
                        <td><?php echo $historyTransaction->is_quick_service == 1 ? 'Yes' : 'No'; ?></td>
                        <td><?php echo $historyTransaction->repair_type; ?></td>
                        <td class="text-end"><?php echo number_format($historyTransaction->total_service_price, 2); ?></td>
                        <td class="text-end"><?php echo number_format($historyTransaction->total_product_price, 2); ?></td>
                        <td class="text-end"><?php echo number_format($historyTransaction->grand_total, 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7"><?php echo "NO HISTORY"; ?></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</fieldset>