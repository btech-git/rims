<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 15% }
    .width1-3 { width: 15% }
    .width1-4 { width: 10% }
    .width1-5 { width: 10% }
    .width1-6 { width: 15% }
    .width1-7 { width: 15% }

    .width2-1 { width: 40% }
    .width2-2 { width: 5% }
    .width2-3 { width: 15% }
');
?>

<div class="relative">
    <div style="font-weight: bold; text-align: center">
        <?php //$branch = Branch::model()->findByPk($branchId); ?>
        <div style="font-size: larger">RAPERIND MOTOR<?php //echo CHtml::encode(($branch === null) ? '' : $branch->name); ?></div>
        <div style="font-size: larger">Kartu Stok Persediaan</div>
        <div>
            <?php //$endDate = date('Y-m-d'); ?>
            <?php echo ' Tanggal: ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' - ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?>
        </div>
    </div>

    <br />

    <table style="width: 80%; margin: 0 auto; border-spacing: 0pt">
        <thead>
            <tr>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Tanggal</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Jenis Transaksi</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Transaksi #</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Keterangan</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Masuk</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Keluar</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Stok</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Gudang</th>
            </tr>
        </thead>
        
        <tbody>
            <?php foreach ($stockCardSummary->dataProvider->data as $header): ?>
                <tr class="items1">
                    <td><?php echo CHtml::encode(CHtml::value($header, 'name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'manufacturer_code')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'masterSubCategoryCode')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'brand.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'subBrand.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'subBrandSeries.name')); ?></td>
                    <td style="text-align: right; font-weight: bold">
                        <?php $saldo = $header->getBeginningStockReport($startDate); ?>
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saldo)); ?>
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
                    <?php $saldo += $stockIn + $stockOut; ?>
                    <tr class="items2">
                        <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($stockRow['transaction_date']))); ?></td>
                        <td><?php echo CHtml::encode($stockRow['transaction_type']); ?></td>
                        <td><?php echo CHtml::link($transactionNumber, Yii::app()->createUrl("report/payableLedger/redirectTransaction", array("codeNumber" => $transactionNumber)), array('target' => '_blank')); ?></td>
                        <td><?php echo CHtml::encode($stockRow['notes']); ?></td>
                        <td style="text-align: right"><?php echo Yii::app()->numberFormatter->format('#,##0', $stockIn); ?></td>
                        <td style="text-align: right"><?php echo Yii::app()->numberFormatter->format('#,##0', $stockOut); ?></td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saldo)); ?></td>
                        <td><?php echo CHtml::encode($stockRow['name']); ?></td>
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
                <tr>
                    <td colspan="8">&nbsp;</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>