<div>
    <table>
        <thead>
            <tr>
                <th>Type</th>
                <th>Transaction Number</th>
                <th>Date</th>
                <th>Beginning</th>
                <th>Qty In</th>
                <th>Qty Out</th>
                <th>Stock</th>
                <th>Warehouse</th>
                <th>Notes</th>
            </tr>
        </thead>
        
        <tbody>
            <tr>
                <td colspan="6">Beginning Stock</td>
                <td><?php echo CHtml::encode($inventoryBeginningStock); ?></td>
                <td colspan="2"></td>
            </tr>
            <?php $currentStock = $inventoryBeginningStock; ?>
            <?php $totalStockIn = 0; ?>
            <?php $totalStockOut = 0; ?> 
            <?php $lastCurrentStock = $currentStock; ?>
            <?php foreach (array_reverse($latestInventoryData) as $latestInventoryItem): ?>
                <?php $currentStock += $latestInventoryItem['stock_in'] + $latestInventoryItem['stock_out']; ?>
                <tr>
                    <td><?php echo CHtml::encode($latestInventoryItem['transaction_type']); ?></td>
                    <td><?php echo CHtml::encode($latestInventoryItem['transaction_number']); ?><?php //echo CHtml::link($latestInventoryItem['transaction_number'], Yii::app()->createUrl("frontDesk/inventory/redirectTransaction", array("codeNumber" => $latestInventoryItem['transaction_number'])), array('target' => '_blank')); ?></td>
                    <td><?php echo CHtml::encode($latestInventoryItem['transaction_date']); ?></td>
                    <td><?php echo CHtml::encode($lastCurrentStock); ?></td>
                    <td><?php echo CHtml::encode($latestInventoryItem['stock_in']); ?></td>
                    <td><?php echo CHtml::encode($latestInventoryItem['stock_out']); ?></td>
                    <td><?php echo CHtml::encode($currentStock); ?></td>
                    <td><?php echo CHtml::encode($latestInventoryItem['warehouse_code']); ?></td>
                    <td><?php echo CHtml::encode($latestInventoryItem['notes']); ?></td>
                </tr>
                <?php $totalStockIn += $latestInventoryItem['stock_in']; ?>
                <?php $totalStockOut += $latestInventoryItem['stock_out']; ?>
                <?php $lastCurrentStock = $currentStock; ?>
            <?php endforeach; ?>
        </tbody>
        
        <tfoot>
            <tr>
                <td colspan="4" class="text-right"><strong>Total</strong></td>
                <td><?php echo CHtml::encode($totalStockIn); ?></td>
                <td><?php echo CHtml::encode($totalStockOut); ?></td>
                <td colspan="3"></td>
            </tr>
        </tfoot>
    </table>
</div>