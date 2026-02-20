<?php Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 15% }
    .width1-2 { width: 15% }
    .width1-3 { width: 15% }
    .width1-4 { width: 15% }
    .width1-5 { width: 5% }

'); ?>

<table class="report">
    <thead>
        <tr id="header1">
            <th class="width1-5"></th>
            <th class="width1-5"></th>
            <th class="width1-1">Transaction #</th>
            <th class="width1-2">Log Date</th>
            <th class="width1-3">Log Time</th>
            <th class="width1-4">Username</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($transactionLogs as $transactionLog): ?>
            <tr class="items1">
                <td class="width1-5"><?php echo CHtml::radioButton('TransactionData1', $transactionLog->transaction_number === $transactionNumber, array('value' => $transactionLog->id)); ?></td>
                <td class="width1-5"><?php echo CHtml::radioButton('TransactionData2', false, array('value' => $transactionLog->id)); ?></td>
                <td class="width1-1">
                    <?php echo CHtml::encode(CHtml::value($transactionLog, 'transaction_number')); ?>
                </td>
                <td class="width1-2">
                    <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime(CHtml::value($transactionLog, 'log_date')))); ?>
                </td>
                <td class="width1-3"><?php echo CHtml::encode(CHtml::value($transactionLog, 'log_time')); ?></td>
                <td class="width1-4"><?php echo CHtml::encode(CHtml::value($transactionLog, 'username')); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>