<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 15% }
    .width1-2 { width: 30% }
    .width1-3 { width: 20% }
    .width1-4 { width: 20% }
    .width1-5 { width: 15% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Penjualan Retail Jasa Summary</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1">Code</th>
        <th class="width1-2">Name</th>
        <th class="width1-3">Category</th>
        <th class="width1-4">Type</th>
        <th class="width1-5">Total</th>
    </tr>
    <?php $totalSale = 0.00; ?>
        <?php foreach ($saleRetailServiceReport as $saleRetailServiceItem): ?>
        <?php $grandTotal = $saleRetailServiceItem['total']; ?>
            <tr class="items1">
                <td class="width1-1"><?php echo CHtml::encode($saleRetailServiceItem['code']); ?></td>
                <td class="width1-2"><?php echo CHtml::encode($saleRetailServiceItem['name']); ?></td>
                <td class="width1-3"><?php echo CHtml::encode($saleRetailServiceItem['category']); ?></td>
                <td class="width1-4"><?php echo CHtml::encode($saleRetailServiceItem['type']); ?></td>
                <td class="width1-5" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotal)); ?></td>
            </tr>
            <?php $totalSale += $grandTotal; ?>
    <?php endforeach; ?>
    <tr>
        <td colspan="4" style="text-align: right; font-weight: bold">Total Sales</td>
        <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalSale)); ?></td>
    </tr>
</table>