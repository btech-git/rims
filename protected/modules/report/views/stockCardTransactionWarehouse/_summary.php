<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 10% }
    .width1-3 { width: 50% }
    .width1-4 { width: 8% }
    .width1-5 { width: 7% }
    .width1-6 { width: 5% }
    .width1-7 { width: 10% }
');
?>

<div class="relative">
    <?php $warehouse = Warehouse::model()->findByPk($warehouseId); ?>
    <div style="font-weight: bold; text-align: center">
        <div style="font-size: larger">RAPERIND MOTOR</div>
        <div style="font-size: larger">Mutasi Stok Jual Beli Gudang <?php echo CHtml::encode(CHtml::value($warehouse, 'name')); ?></div>
        <div>
            <?php echo ' Tanggal: ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' - ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?>
        </div>
    </div>

    <br />

    <table style="width: 95%; margin: 0 auto; border-spacing: 0pt">
        <thead style="position: sticky; top: 0">
            <tr style="text-align: center; font-weight: bold; border-bottom: 1px solid">
                <th class="width1-1">Tanggal</th>
                <th class="width1-2">Jenis Transaksi</th>
                <th class="width1-3">Transaksi #</th>
                <th class="width1-4">Masuk</th>
                <th class="width1-5">Keluar</th>
                <th class="width1-6">Stok</th>
                <th class="width1-7">Nilai</th>
            </tr>
        </thead>
        
        <tbody>
            <?php foreach ($stockCardSummary->dataProvider->data as $header): ?>
            <?php $stock = $header->getBeginningTransactionStockReport($startDate, $warehouse->branch_id); ?>
            <?php //$beginningValue = $header->getBeginningValueReport($startDate, $warehouse->branch_id); ?>
                <tr class="items1">
                    <td colspan="2">
                        <?php echo CHtml::encode(CHtml::value($header, 'id')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($header, 'manufacturer_code')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($header, 'name')); ?>
                    </td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($header, 'brand.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($header, 'subBrand.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($header, 'subBrandSeries.name')); ?>
                    </td>
                    <td colspan="2">
                        <?php echo CHtml::encode(CHtml::value($header, 'productMasterCategory.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($header, 'productSubMasterCategory.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($header, 'productSubCategory.name')); ?>
                    </td>
                    <td style="text-align: center; font-weight: bold">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $stock)); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'unit.name')); ?></td>
                </tr>

                <?php $stockData = $header->getInventoryTransactionStockReport($startDate, $endDate, $warehouse->branch_id); ?>
                <?php $totalStockIn = 0; ?>
                <?php $totalStockOut = 0; ?>
                <?php foreach ($stockData as $stockRow): ?>
                    <?php $transactionNumber = $stockRow['transaction_number']; ?>
                    <?php $stockIn = $stockRow['stock_in']; ?>
                    <?php $stockOut = $stockRow['stock_out']; ?>
                    <?php $stock += $stockIn + $stockOut; ?>
                    <?php //$inventoryInValue = $stockRow['purchase_price'] * $stockIn; ?>
                    <?php //$inventoryOutValue = $stockRow['purchase_price'] * $stockOut; ?>
                    <?php $inventoryValue = $stockRow['purchase_price'] * $stock; ?>
                    <tr class="items2">
                        <td class="width1-1">
                            <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($stockRow['transaction_date']))); ?>
                        </td>
                        <td class="width1-2"><?php echo CHtml::encode($stockRow['transaction_type']); ?></td>
                        <td class="width1-3"><?php echo CHtml::link($transactionNumber, Yii::app()->createUrl("report/payableLedger/redirectTransaction", array("codeNumber" => $transactionNumber)), array('target' => '_blank')); ?></td>
                        <td class="width1-4" style="text-align: center"><?php echo Yii::app()->numberFormatter->format('#,##0', $stockIn); ?></td>
                        <td class="width1-5" style="text-align: center"><?php echo Yii::app()->numberFormatter->format('#,##0', $stockOut); ?></td>
                        <td class="width1-6" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $stock)); ?></td>
                        <td class="width1-7" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $inventoryValue)); ?></td>
                    </tr>
                    <?php $totalStockIn += $stockIn; ?>
                    <?php $totalStockOut += $stockOut; ?>
                <?php endforeach; ?>

                <tr>
                    <td colspan="3" style="text-align: right; font-weight: bold">Total</td>
                    <td style="text-align: center; font-weight: bold; border-top: 1px solid">
                        <?php echo Yii::app()->numberFormatter->format('#,##0', $totalStockIn); ?>
                    </td>
                    <td style="text-align: center; font-weight: bold; border-top: 1px solid">
                        <?php echo Yii::app()->numberFormatter->format('#,##0', $totalStockOut); ?>
                    </td>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="7">&nbsp;</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>