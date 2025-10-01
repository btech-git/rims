<div>
    <span style="text-align: center; font-weight: bold">
        <h2>Stok Quantity + Nilai Persediaan</h2>
        <h2><?php echo CHtml::encode(CHtml::value($product, 'name')); ?></h2>
        <h2><?php echo CHtml::encode(CHtml::value($warehouse, 'name')); ?></h2>
    </span>
    
    <hr /> 
    
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
                <th>Value</th>
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
                <?php $currentValue = $currentStock * $latestInventoryItem['stock_value']; ?>
                <tr>
                    <td><?php echo CHtml::encode($latestInventoryItem['transaction_type']); ?></td>
                    <td><?php echo CHtml::link($latestInventoryItem['transaction_number'], Yii::app()->createUrl("frontDesk/inventory/redirectTransaction", array("codeNumber" => $latestInventoryItem['transaction_number'])), array('target' => '_blank')); ?></td>
                    <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($latestInventoryItem['transaction_date']))); ?></td>
                    <td><?php echo CHtml::encode($lastCurrentStock); ?></td>
                    <td style="text-align: center"><?php echo CHtml::encode($latestInventoryItem['stock_in']); ?></td>
                    <td style="text-align: center"><?php echo CHtml::encode($latestInventoryItem['stock_out']); ?></td>
                    <td style="text-align: center"><?php echo CHtml::encode($currentStock); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $currentValue)); ?></td>
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
                <td class="text-center"><?php echo CHtml::encode($totalStockIn); ?></td>
                <td class="text-center"><?php echo CHtml::encode($totalStockOut); ?></td>
                <td colspan="3"></td>
            </tr>
        </tfoot>
    </table>
</div>