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
        <?php //$branch = Branch::model()->findByPk($branchId); ?>
        <div style="font-size: larger">RAPERIND MOTOR<?php //echo CHtml::encode(($branch === null) ? '' : $branch->name); ?></div>
        <div style="font-size: larger">Kartu Stok per Category</div>
        <div>
            <?php //$endDate = date('Y-m-d'); ?>
            <?php echo ' Tanggal: ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' - ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?>
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
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Stok</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Nilai</th>
            </tr>
        </thead>
        
        <tbody>
            <?php foreach ($stockCardCategorySummary->dataProvider->data as $header): ?>
                <?php $beginningValue = $header->getBeginningValueReport($startDate, $branchId); ?>
                    <tr class="items1">
                        <td><?php echo CHtml::encode(CHtml::value($header, 'id')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($header, 'code')); ?></td>
                        <td colspan="2"><?php echo CHtml::encode(CHtml::value($header, 'name')); ?></td>
                    </tr>

                    <?php $stock = $header->getBeginningStockReport($startDate, $branchId); ?>
                    <?php $stockData = $header->getInventoryStockReport($startDate, $endDate, $branchId); ?>
                    <?php $totalStockIn = 0; ?>
                    <?php $totalStockOut = 0; ?>
                    <?php foreach ($stockData as $stockRow): ?>
                        <?php $stockIn = $stockRow['stock_in']; ?>
                        <?php $stockOut = $stockRow['stock_out']; ?>
                        <?php $stock += $stockIn + $stockOut; ?>
                        <?php /*$inventoryInValue = $stockRow['purchase_price'] * $stockIn; ?>
                        <?php $inventoryOutValue = $stockRow['purchase_price'] * $stockOut; ?>
                        <?php $inventoryValue = $stockRow['purchase_price'] * $stock;*/ ?>
                        <tr class="items2">
                            <td><?php echo CHtml::encode($stockRow['code']); ?></td>
                            <td><?php echo CHtml::encode($stockRow['name']); ?></td>
                            <td><?php echo CHtml::encode($stockRow['description']); ?></td>
                            <td style="text-align: center"><?php echo Yii::app()->numberFormatter->format('#,##0', $stockIn); ?></td>
                            <td style="text-align: right"><?php //echo Yii::app()->numberFormatter->format('#,##0.00', $inventoryInValue); ?></td>
                            <td style="text-align: center"><?php echo Yii::app()->numberFormatter->format('#,##0', $stockOut); ?></td>
                            <td style="text-align: right"><?php //echo Yii::app()->numberFormatter->format('#,##0.00', $inventoryOutValue); ?></td>
                            <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $stock)); ?></td>
                            <td style="text-align: right"><?php //echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $inventoryValue)); ?></td>
                        </tr>
                        <?php $totalStockIn += $stockIn; ?>
                        <?php $totalStockOut += $stockOut; ?>
                    <?php endforeach; ?>

                    <tr>
                        <td colspan="4" style="text-align: right; font-weight: bold">Total</td>
                        <td style="text-align: right; font-weight: bold; border-top: 1px solid">
                            <?php echo Yii::app()->numberFormatter->format('#,##0', $totalStockIn); ?>
                        </td>
                        <td>&nbsp;</td>
                        <td style="text-align: right; font-weight: bold; border-top: 1px solid">
                            <?php echo Yii::app()->numberFormatter->format('#,##0', $totalStockOut); ?>
                        </td>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="10">&nbsp;</td>
                    </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>