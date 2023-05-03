<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 25% }
    .width1-2 { width: 20% }
    .width1-3 { width: 25% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Penjualan per Pelanggan</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead>
        <tr id="header1">
            <th class="width1-1">Customer</th>
            <th class="width1-2">Type</th>
            <th class="width1-3">Total Sales</th>
        </tr>
    </thead>
    
    <tbody>
        <?php $totalSale = 0.00; ?>
        <?php foreach ($saleRetailCustomerSummary->dataProvider->data as $header): ?>
            <?php $grandTotal = $header->getTotalSales($startDate, $endDate); ?>
            <tr class="items1">
                <td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'id')); ?> - <?php echo CHtml::encode(CHtml::value($header, 'name')); ?></td>
                <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'customer_type')); ?></td>
                <td class="width1-3" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotal)); ?></td>
            </tr>
            <?php $totalSale += $grandTotal; ?>
        <?php endforeach; ?>
    </tbody>
    
    <tfoot>
        <tr>
            <td style="text-align: right" colspan="2">Total</td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalSale)); ?></td>
        </tr>
    </tfoot>
</table>