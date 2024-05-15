<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 10% }
    .width1-3 { width: 18% }
    .width1-4 { width: 15% }
    .width1-4 { width: 10% }
    .width1-5 { width: 10% }
    .width1-6 { width: 10% }
    .width1-7 { width: 15% }
');
?>

<div class="relative">
    <div style="font-weight: bold; text-align: center">
        <div style="font-size: larger">RAPERIND MOTOR</div>
        <div style="font-size: larger">Mutasi per Gudang</div>
        <div>
            <?php echo ' Tanggal: ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' - ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?>
        </div>
    </div>

    <br />

    <table style="width: 80%; margin: 0 auto; border-spacing: 0pt">
        <thead style="position: sticky; top: 0">
            <tr>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Tanggal</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Jenis Transaksi</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Transaksi #</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Product</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Masuk</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Keluar</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Stok</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Nilai</th>
            </tr>
        </thead>
        
        <tbody>
            <?php foreach ($stockCardSummary->dataProvider->data as $header): ?>
                <tr class="items1">
                    <td><?php echo CHtml::encode(CHtml::value($header, 'code')); ?></td>
                    <td colspan="2"><?php echo CHtml::encode(CHtml::value($header, 'name')); ?></td>
                    <td colspan="3"><?php echo CHtml::encode(CHtml::value($header, 'description')); ?></td>
                    <td style="text-align: right; font-weight: bold">
                        <?php $stock = $header->getBeginningStockReport($startDate, $branchId); ?>
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $stock)); ?>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                
                <?php $stockData = $header->getInventoryStockReport($startDate, $endDate); ?>
                <?php $totalStockIn = 0; ?>
                <?php $totalStockOut = 0; ?>
                <?php foreach ($stockData as $stockRow): ?>
                    <?php $transactionNumber = $stockRow['transaction_number']; ?>
                    <?php $stockIn = $stockRow['stock_in']; ?>
                    <?php $stockOut = $stockRow['stock_out']; ?>
                    <?php $stock += $stockIn + $stockOut; ?>
                    <?php $inventoryValue = $stockRow['purchase_price'] * $stock; ?>
                    <tr class="items2">
                        <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($stockRow['transaction_date']))); ?></td>
                        <td><?php echo CHtml::encode($stockRow['transaction_type']); ?></td>
                        <td><?php echo CHtml::link($transactionNumber, Yii::app()->createUrl("report/payableLedger/redirectTransaction", array("codeNumber" => $transactionNumber)), array('target' => '_blank')); ?></td>
                        <td><?php echo CHtml::encode($stockRow['product_name']); ?></td>
                        <td style="text-align: right"><?php echo Yii::app()->numberFormatter->format('#,##0', $stockIn); ?></td>
                        <td style="text-align: right"><?php echo Yii::app()->numberFormatter->format('#,##0', $stockOut); ?></td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $stock)); ?></td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $inventoryValue)); ?></td>
                    </tr>
                    <?php $totalStockIn += $stockIn; ?>
                    <?php $totalStockOut += $stockOut; ?>
                <?php endforeach; ?>
                    
                <tr>
                    <td colspan="4" style="text-align: right; font-weight: bold">Total</td>
                    <td style="text-align: right; font-weight: bold; border-top: 1px solid">
                        <?php echo Yii::app()->numberFormatter->format('#,##0', $totalStockIn); ?>
                    </td>
                    <td style="text-align: right; font-weight: bold; border-top: 1px solid">
                        <?php echo Yii::app()->numberFormatter->format('#,##0', $totalStockOut); ?>
                    </td>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr><td colspan="8">&nbsp;</td></tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>