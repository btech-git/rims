<?php Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 25% }
    .width1-2 { width: 15% }
    .width1-3 { width: 5% }
    .width1-4 { width: 15% }
    .width1-5 { width: 15% }
    .width1-6 { width: 15% }

'); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Transaction Log</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">Name</th>
            <th class="width1-2">Log Date</th>
            <th class="width1-3">Log Time</th>
            <th class="width1-4">Username</th>
            <th class="width1-5">Controller</th>
            <th class="width1-6">Action Name</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($masterLogDataProvider->data as $masterLogRow): ?>
            <tr class="items1">
                <td class="width1-1">
                    <?php echo CHtml::link(CHtml::value($masterLogRow, 'name'), Yii::app()->createUrl("/report/masterLog/summaryPayload", array('id' => $masterLogRow->id)), array('target' => '_blank')); ?>
                </td>
                <td class="width1-2">
                    <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime(CHtml::value($masterLogRow, 'log_date')))); ?>
                </td>
                <td class="width1-3"><?php echo CHtml::encode(CHtml::value($masterLogRow, 'log_time')); ?></td>
                <td class="width1-4"><?php echo CHtml::encode(CHtml::value($masterLogRow, 'username')); ?></td>
                <td class="width1-5"><?php echo CHtml::encode(CHtml::value($masterLogRow, 'controller_class')); ?></td>
                <td class="width1-6"><?php echo CHtml::encode(CHtml::value($masterLogRow, 'action_name')); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div>
    <div class="right">
        <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
            'pages' => $masterLogDataProvider->pagination,
        )); ?>
    </div>
    <div class="clear"></div>
</div>
