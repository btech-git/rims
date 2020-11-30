<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 10% }
    .width1-3 { width: 10% }
    .width1-4 { width: 10% }
    .width1-5 { width: 10% }
    .width1-6 { width: 10% }
    .width1-7 { width: 10% }
    .width1-8 { width: 10% }
    .width1-9 { width: 10% }
    .width1-10 { width: 10% }

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
    <div style="font-size: larger">Laporan Penjualan Retail</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1">Penjualan #</th>
        <th class="width1-2">Tanggal</th>
        <th class="width1-3">Customer</th>
        <th class="width1-4">Vehicle</th>
        <th class="width1-5">Grand Total</th>
        <th class="width1-6">Admin</th>
        <th class="width1-7">Branch</th>
        <th class="width1-8">Product</th>
        <th class="width1-9">Quantity</th>
        <th class="width1-10">Price</th>
        <th class="width1-11">Disc</th>
        <th class="width1-12">Total</th>
        <th class="width1-13">Memo</th>
    </tr>
    <?php foreach ($saleRetailSummary->dataProvider->data as $header): ?>
        <?php foreach ($header->registrationProducts as $detail): ?>
            <tr class="items1">
                <td class="width1-1"><?php echo CHtml::encode($header->transaction_number); ?></td>
                <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->transaction_date))); ?></td>
                <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'vehicle.plate_number')); ?></td>
                <td class="width1-5"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'grand_total'))); ?></td>
                <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'user.username')); ?></td>
                <td class="width1-7"><?php echo CHtml::encode(CHtml::value($header, 'branch.name')); ?></td>
                <td class="width1-8"><?php echo CHtml::encode(CHtml::value($detail, 'product.name')); ?></td>
                <td class="width1-9"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))); ?></td>
                <td class="width1-10"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'sale_price'))); ?></td>
                <td class="width1-11"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'discount'))); ?></td>
                <td class="width1-12"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'total_price'))); ?></td>
                <td class="width1-13"><?php echo CHtml::encode(CHtml::value($detail, 'note')); ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endforeach; ?>
</table>