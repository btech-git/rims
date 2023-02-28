<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 15% }
    .width1-2 { width: 10% }
    .width1-3 { width: 5% }
    .width1-4 { width: 10% }
    .width1-5 { width: 5% }
    .width1-6 { width: 10% }
    .width1-7 { width: 10% }
    .width1-8 { width: 10% }
    .width1-9 { width: 10% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">
        <?php $branch = Branch::model()->findByPk($branchId); ?>
        <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?>
    </div>
    <div style="font-size: larger">Laporan Mechanic Performance</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1">Name</th>
        <th class="width1-2">ID Card #</th>
        <th class="width1-3">Service Qty</th>
        <th class="width1-4">Service Price</th>
        <th class="width1-5">Product Qty</th>
        <th class="width1-6">Product Price</th>
        <th class="width1-7">Total</th>
        <th class="width1-8">Service Status</th>
        <th class="width1-9">Transaction Status</th>
    </tr>
    <?php foreach ($mechanicPerformanceSummary->dataProvider->data as $header): ?>
        <tr class="items1">
            <?php $startMechanic = Employee::model()->findByPk($header->employee_id_assign_mechanic); ?>
            <td class="width1-1"><?php echo CHtml::encode(CHtml::value($startMechanic, 'name')); ?></td>
            <td class="width1-2"><?php echo CHtml::encode(CHtml::value($startMechanic, 'id_card')); ?></td>
            <td class="width1-3" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'total_service')); ?></td>
            <td class="width1-4" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'total_service_price'))); ?></td>
            <td class="width1-5" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'total_product')); ?></td>
            <td class="width1-6" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'total_product_price'))); ?></td>
            <td class="width1-7" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'subtotal'))); ?></td>
            <td class="width1-8"><?php echo CHtml::encode(CHtml::value($header, 'service_status')); ?></td>
            <td class="width1-9"><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
        </tr>
    <?php endforeach; ?>
</table>