<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 5% }
    .width1-2 { width: 5% }
    .width1-3 { width: 5% }
    .width1-4 { width: 5% }
    .width1-5 { width: 5% }
    .width1-6 { width: 5% }
    .width1-7 { width: 5% }
    .width1-8 { width: 5% }
    .width1-9 { width: 5% }
    .width1-10 { width: 5% }
    .width1-11 { width: 5% }
    .width1-12 { width: 5% }
    .width1-13 { width: 5% }
    .width1-14 { width: 5% }
    .width1-15 { width: 5% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Laporan Saldo COA Tahunan</div>
    <div><?php echo CHtml::encode($year); ?></div>
</div>

<br />

<table class="report">
    <thead>
        <tr id="header1">
            <th class="width1-1">COA</th>
            <?php for ($i = 1; $i <= 12; $i++): ?>
                <th class="width1-2"><?php echo $i; ?></th>
            <?php endfor; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($monthlyRunningBalanceReportData as $dataItem): ?>
            <tr class="items1">
                <td><?php echo CHtml::encode($dataItem['name']); ?></td>
                <?php for ($i = 1; $i <= 12; $i++): ?>
                    <?php $balance = isset($dataItem[$i]) ? $dataItem[$i] : '0.00'; ?>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $balance)); ?></td>
                <?php endfor; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>