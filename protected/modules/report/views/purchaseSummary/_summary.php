<?php Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 10% }
    .width1-3 { width: 15% }
    .width1-4 { width: 15% }
'); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger"><?php echo Yii::app()->name; ?></div>
    <div style="font-size: larger">Laporan Pembelian per Pemasok</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead>
        <tr id="header1">
            <th class="width1-1">Code</th>
            <th class="width1-2">Company</th>
            <th class="width1-3">Name</th>
            <th class="width1-4">Total Purchase</th>
        </tr>
    </thead>
    
    <tbody>
        <?php $totalPurchase = 0.00; ?>
        <?php foreach ($purchaseSummary->dataProvider->data as $header): ?>
            <?php $grandTotal = $header->getTotalPurchase($startDate, $endDate); ?>
            <tr class="items1">
                <td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'code')); ?></td>
                <td class="width1-2"><?php echo CHtml::encode($header->company); ?></td>
                <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'name')); ?></td>
                <td class="width1-4" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', ($grandTotal))); ?></td>
            </tr>
            <?php $totalPurchase += $grandTotal; ?>
        <?php endforeach; ?>
    </tbody>
    
    <tfoot>
        <tr id="header1">
            <td colspan="3" style="text-align: right">TOTAL</td>
            <td class="width1-4" style="text-align: right"> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPurchase)); ?></td>
        </tr>  
    </tfoot>
</table>