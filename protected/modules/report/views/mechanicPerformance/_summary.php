<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 15% }
    .width1-2 { width: 10% }
    .width1-3 { width: 15% }
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
        <th class="width1-3">Service Name</th>
        <th class="width1-4">Type</th>
        <th class="width1-5">Duration</th>
        <th class="width1-6">Start Time</th>
        <th class="width1-7">Finish Time</th>
        <th class="width1-8">Total Time</th>
        <th class="width1-9">Status</th>
    </tr>
    <?php foreach ($mechanicPerformanceSummary->dataProvider->data as $header): ?>
        <tr class="items1">
            <?php $startMechanic = Employee::model()->findByPk($header->start_mechanic_id); ?>
            <td class="width1-1"><?php echo CHtml::encode(CHtml::value($startMechanic, 'name')); ?></td>
            <td class="width1-2"><?php echo CHtml::encode(CHtml::value($startMechanic, 'id_card')); ?></td>
            <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'service.name')); ?></td>
            <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'serviceType.name')); ?></td>
            <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'hour')); ?></td>
            <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'start')); ?></td>
            <td class="width1-7"><?php echo CHtml::encode(CHtml::value($header, 'end')); ?></td>
            <td class="width1-8"><?php echo CHtml::encode(gmdate("H:i:s", CHtml::value($header, 'total_time'))); ?></td>
            <td class="width1-9"><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
        </tr>
    <?php endforeach; ?>
</table>