<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 7% }
    .width1-3 { width: 5% }
    .width1-4 { width: 10% }
    .width1-5 { width: 10% }
    .width1-6 { width: 10% }
    .width1-7 { width: 10% }
    .width1-8 { width: 10% }
    .width1-9 { width: 10% }
    .width1-10 { width: 10% }

    .width2-1 { width: 15% }
    .width2-2 { width: 15% }
    .width2-3 { width: 40% }
    .width2-4 { width: 15% }
    .width2-5 { width: 15% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Laporan Jurnal Penyesuaian</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">Penyesuaian #</th>
            <th class="width1-2">Tanggal</th>
            <th class="width1-3">Status</th>
            <th class="width1-4">Catatan</th>
            <th class="width1-5">Pembuat</th>
            <th class="width1-6">Tanggal Input</th>
            <th class="width1-7">Edit Oleh</th>
            <th class="width1-8">Tanggal</th>
            <th class="width1-9">Cancel Oleh</th>
            <th class="width1-10">Tanggal</th>
        </tr>
        <tr id="header2">
            <td colspan="10">
                <table>
                    <tr>
                        <th class="width2-1">Code</th>
                        <th class="width2-2">Name</th>
                        <th class="width2-3">Memo</th>
                        <th class="width2-4">Debit</th>
                        <th class="width2-5">Credit</th>
                    </tr>
                </table>
            </td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($journalAdjustmentSummary->dataProvider->data as $header): ?>
            <tr class="items1">
                <td class="width1-1">
                    <?php echo CHtml::link($header->transaction_number, Yii::app()->createUrl("accounting/journalAdjustment/view", array("id" => $header->id)), array('target' => '_blank')); ?>
                </td>
                <td class="width1-2">
                    <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date))) . ' ' . CHtml::encode($header->time); ?>
                </td>
                <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
                <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'note')); ?></td>
                <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'user.username')); ?></td>
                <td class="width1-6"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy H:m:s', strtotime($header->created_datetime))); ?></td>
                <td class="width1-7"><?php echo empty($header->user_id_updated) ? '' : CHtml::encode(CHtml::value($header, 'userIdUpdated.username')); ?></td>
                <td class="width1-8"><?php echo empty($header->updated_datetime) ? '' : CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy H:m:s', strtotime($header->updated_datetime))); ?></td>
                <td class="width1-9"><?php echo empty($header->user_id_cancelled) ? '' : CHtml::encode(CHtml::value($header, 'userIdCancelled.username')); ?></td>
                <td class="width1-10"><?php echo empty($header->cancelled_datetime) ? '' : CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy H:m:s', strtotime($header->cancelled_datetime))); ?></td>
            </tr>
            <tr class="items2">
                <td colspan="10">
                    <table>
                        <?php foreach($header->journalAdjustmentDetails as $detail): ?>
                            <tr>
                                <th class="width2-1"><?php echo CHtml::encode(CHtml::value($detail, 'coa.code')); ?></th>
                                <th class="width2-2"><?php echo CHtml::encode(CHtml::value($detail, 'coa.name')); ?></th>
                                <th class="width2-3"><?php echo CHtml::encode(CHtml::value($detail, 'memo')); ?></th>
                                <th class="width2-4"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'debit'))); ?></th>
                                <th class="width2-5"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'credit'))); ?></th>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>