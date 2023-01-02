<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 15% }
    .width1-2 { width: 10% }
    .width1-3 { width: 18% }
    .width1-4 { width: 10% }
    .width1-5 { width: 15% }
    .width1-6 { width: 10% }
    .width1-7 { width: 7% }
    .width1-8 { width: 15% }

    .width2-1 { width: 40% }
    .width2-2 { width: 5% }
    .width2-3 { width: 15% }
    .width2-4 { width: 15% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">
        <?php $branch = Branch::model()->findByPk($branchId); ?>
        <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?>
    </div>
    <div style="font-size: larger">Laporan Penjualan Retail Service</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1">Penjualan #</th>
        <th class="width1-2">Tanggal</th>
        <th class="width1-3">Customer</th>
        <th class="width1-4">Vehicle</th>
        <th class="width1-5">Service</th>
        <th class="width1-6">Price</th>
        <th class="width1-7">Disc (%)</th>
        <th class="width1-8">Total</th>
    </tr>
    <?php $totalSale = 0.00; ?>
    <?php foreach ($saleRetailSummary->dataProvider->data as $header): ?>
        <?php $totalAmount = CHtml::value($header, 'total_price'); ?>
        <tr class="items1">
            <td class="width1-1"><?php echo CHtml::link(CHtml::encode($header->registrationTransaction->transaction_number), array("/frontDesk/registrationTransaction/view", "id"=>$header->id), array("target" => "_blank")); ?></td>
            <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->registrationTransaction->transaction_date))); ?></td>
            <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'registrationTransaction.customer.name')); ?></td>
            <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'registrationTransaction.vehicle.plate_number')); ?></td>
            <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'service.name')); ?></td>
            <td class="width1-6" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'price'))); ?></td>
            <td class="width1-7"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'discount'))); ?></td>
            <td class="width1-8" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalAmount)); ?></td>
        </tr>
        <?php $totalSale += $totalAmount; ?>
    <?php endforeach; ?>
    <tr>
        <td colspan="7" style="text-align: right; font-weight: bold">Total Sales</td>
        <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalSale)); ?></td>
    </tr>
</table>