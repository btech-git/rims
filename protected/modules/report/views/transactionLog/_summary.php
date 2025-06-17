<?php Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 5% }
    .width1-2 { width: 5% }
    .width1-3 { width: 5% }
    .width1-4 { width: 5% }
    .width1-5 { width: 5% }

'); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Transaction Log</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">Transaction #</th>
            <th class="width1-2">Tanggal</th>
            <th class="width1-3">Log Date</th>
            <th class="width1-3">Log Time</th>
            <th class="width1-2">Username</th>
            <th class="width1-2">Transaction Type</th>
            <th class="width1-2">Action Type</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($transactionLogDataProvider->data as $transactionLogRow): ?>
            <?php list(, $controllerClass) = explode('/', CHtml::value($transactionLogRow, 'controller_class')); ?>
            <tr class="items1">
                <td class="width1-1"><?php echo CHtml::link(CHtml::value($transactionLogRow, 'transaction_number'), Yii::app()->createUrl("/report/transactionLog/summaryPayload", array('id' => $transactionLogRow->id)), array('target' => '_blank')); ?></td>
                <td class="width1-2">
                    <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime(CHtml::value($transactionLogRow, 'transaction_date')))); ?>
                </td>
                <td class="width1-2">
                    <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime(CHtml::value($transactionLogRow, 'log_date')))); ?>
                </td>
                <td class="width1-1"><?php echo CHtml::encode(CHtml::value($transactionLogRow, 'log_time')); ?></td>
                <td class="width1-1"><?php echo CHtml::encode(CHtml::value($transactionLogRow, 'username')); ?></td>
                <td class="width1-1"><?php echo CHtml::encode(ucfirst($controllerClass)); ?></td>
                <td class="width1-1"><?php echo CHtml::encode(CHtml::value($transactionLogRow, 'action_type')); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div>
    <div class="right">
        <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
            'pages' => $transactionLogDataProvider->pagination,
        )); ?>
    </div>
    <div class="clear"></div>
</div>
