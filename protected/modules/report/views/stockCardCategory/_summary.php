<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 10% }
    .width1-3 { width: 18% }
    .width1-4 { width: 10% }
    .width1-5 { width: 10% }
    .width1-6 { width: 10% }
    .width1-7 { width: 10% }
    .width1-7 { width: 15% }

    .width2-1 { width: 40% }
    .width2-2 { width: 5% }
    .width2-3 { width: 15% }
');
?>

<div class="relative">
    <div style="font-weight: bold; text-align: center">
        <div style="font-size: larger">RAPERIND MOTOR<?php //echo CHtml::encode(($branch === null) ? '' : $branch->name); ?></div>
        <div style="font-size: larger">Laporan Posisi Stok</div>
        <div>
            <?php echo ' Periode: ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?>
        </div>
    </div>

    <br />

    <table style="width: 95%; margin: 0 auto; border-spacing: 0pt">
        <thead style="position: sticky; top: 0">
            <tr>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Code</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Name</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Ket</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Awal</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Masuk</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Keluar</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Akhir</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Nilai</th>
            </tr>
        </thead>
        
        <tbody>
            <?php foreach ($stockCardCategorySummary->dataProvider->data as $header): ?>
                <tr class="items1">
                    <td style="text-align: center; font-weight: bold"><?php echo CHtml::encode(CHtml::value($header, 'id')); ?></td>
                    <td style="text-align: center; font-weight: bold"><?php echo CHtml::encode(CHtml::value($header, 'code')); ?></td>
                    <td colspan="6" style="text-align: center; font-weight: bold"><?php echo CHtml::encode(CHtml::value($header, 'name')); ?></td>
                </tr>

                <?php $totalStock = '0.00'; ?>
                <?php $totalValue = '0.00'; ?>
                <?php $stockData = $header->getInventoryStockReport($endDate, $branchId); ?>
                <?php foreach ($stockData as $stockRow): ?>
                    <?php $product = Product::model()->findByPk($stockRow['id']); ?>
                    <?php $stockBegin = $product->getBeginningStockCardReport($branchId); ?>
                    <?php $stockIn = $stockRow['stock_in']; ?>
                    <?php $stockOut = $stockRow['stock_out']; ?>
                    <?php $stokEnd = $stockBegin + $stockIn + $stockOut; ?>
                    <?php $inventoryValue = $product->getAverageCogs() * $stokEnd; ?>
                    <tr class="items2">
                        <td><?php echo CHtml::encode($stockRow['id']); ?></td>
                        <td><?php echo CHtml::encode($stockRow['name']); ?></td>
                        <td><?php echo CHtml::encode($stockRow['manufacturer_code']); ?></td>
                        <td style="text-align: center"><?php echo Yii::app()->numberFormatter->format('#,##0', $stockBegin); ?></td>
                        <td style="text-align: center"><?php echo Yii::app()->numberFormatter->format('#,##0', $stockIn); ?></td>
                        <td style="text-align: center"><?php echo Yii::app()->numberFormatter->format('#,##0', $stockOut); ?></td>
                        <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $stokEnd)); ?></td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $inventoryValue)); ?></td>
                    </tr>
                    <?php $totalStock += $stokEnd; ?>
                    <?php $totalValue += $inventoryValue; ?>
                <?php endforeach; ?>
                <tr>
                    <td colspan="6" style="font-weight: bold; text-align: right">TOTAL</td>
                    <td style="font-weight: bold; text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalStock)); ?></td>
                    <td style="font-weight: bold; text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalValue)); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>