<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 20% }
    .width1-3 { width: 10% }
    .width1-4 { width: 10% }
    .width1-5 { width: 10% }
    .width1-6 { width: 10% }
    .width1-7 { width: 10% }
    .width1-8 { width: 15% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Laporan Aset Tetap</div>
    <div><?php echo 'Per Tanggal ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1">Kode Aktiva</th>
        <th class="width1-2">Nama Aktiva</th>
        <th class="width1-3">Harga Perolehan</th>
        <th class="width1-4">Penyesuaian Tahun ini </th>
        <th class="width1-5">Akumulasi Depr</th>
        <th class="width1-6">Book Value</th>
        <th class="width1-7">Depr Tahun ini</th>
        <th class="width1-8">Tanggal Pembelian</th>
    </tr>
    <tr id="header2">
        <td colspan="8">&nbsp;</td>
    </tr>
    <?php foreach ($assetCategories as $header): ?>
    
        <tr class="items1">
            <td style="font-weight: bold" colspan="8"><?php echo CHtml::encode(CHtml::value($header, 'description')); ?></td>
        </tr>
        
        <?php $totalPurchaseValue = 0.00; ?>
        <?php $totalAccumulatedValue = 0.00; ?>
        <?php $totalCurrentValue = 0.00; ?>
        <?php $totalAdjustedValue = 0.00; ?>
        <?php $totalYearlyValue = 0.00; ?>
        
        <?php foreach ($header->assetPurchases as $i => $detail): ?>
            <?php $purchaseValue = CHtml::value($detail, 'purchase_value'); ?>
            <?php $accumulatedValue = CHtml::value($detail, 'accumulated_depreciation_value'); ?>
            <?php $currentValue = CHtml::value($detail, 'current_value'); ?>
            <?php $adjustedValue = CHtml::value($detail, 'monthlyDepreciationAmount'); ?>
            <?php $yearlyValue = 0.00; ?>

            <tr>
                <td class="width1-1"><?php echo CHtml::encode(CHtml::value($detail, 'assetCategory.code')); ?></td>
                <td class="width1-2"><?php echo CHtml::encode(CHtml::value($detail, 'description')); ?></td>
                <td class="width1-3" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $purchaseValue)); ?></td>
                <td class="width1-4" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', 0)); ?></td>
                <td class="width1-5" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $accumulatedValue)); ?></td>
                <td class="width1-6" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $currentValue)); ?></td>
                <td class="width1-7" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $adjustedValue)); ?></td>
                <td class="width1-8"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($detail->transaction_date))); ?></td>
            </tr>
            
            <?php $totalPurchaseValue += $purchaseValue; ?>
            <?php $totalAccumulatedValue += $accumulatedValue; ?>
            <?php $totalCurrentValue += $currentValue; ?>
            <?php $totalAdjustedValue += $adjustedValue; ?>
            <?php $totalYearlyValue += 0.00; ?>

        <?php endforeach; ?>
        <tr>
            <td style="text-align: right; font-weight: bold" colspan="2">TOTAL: </td>
            <td style="text-align: right; border-top: 1px solid; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPurchaseValue)); ?></td>
            <td style="text-align: right; border-top: 1px solid; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalAdjustedValue)); ?></td>
            <td style="text-align: right; border-top: 1px solid; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalAccumulatedValue)); ?></td>
            <td style="text-align: right; border-top: 1px solid; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalCurrentValue)); ?></td>
            <td style="text-align: right; border-top: 1px solid; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalYearlyValue)); ?></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="8">&nbsp;</td>
        </tr>
    <?php endforeach; ?>
</table>