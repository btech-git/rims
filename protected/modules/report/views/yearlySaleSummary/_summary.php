<?php Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 10% }
    .width1-3 { width: 10% }

'); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Laporan Penjualan Tahunan</div>
    <div><?php echo CHtml::encode($year); ?></div>
</div>

<br />

<?php $monthList = array(
    1 => 'Jan',
    2 => 'Feb',
    3 => 'Mar',
    4 => 'Apr',
    5 => 'May',
    6 => 'Jun',
    7 => 'Jul',
    8 => 'Aug',
    9 => 'Sep',
    10 => 'Oct',
    11 => 'Nov',
    12 => 'Dec',
); ?>
<?php $branches = Branch::model()->findAll(); ?>

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">Bulan</th>
            <?php foreach ($branches as $branch): ?>
                <th class="width1-2"><?php echo CHtml::encode(CHtml::value($branch, 'code')); ?></th>
            <?php endforeach; ?>
            <th class="width1-3">Total</th>
        </tr>
    </thead>
    <tbody>
        <?php $amountTotals = array(); ?>
        <?php for ($month = 1; $month <= 12; $month++): ?>
                <tr class="items1">
                    <td style="text-align: left"><?php echo CHtml::encode($monthList[$month]); ?></td>
                    <?php $amountSum = '0.00'; ?>
                    <?php foreach ($branches as $branch): ?>
                        <?php $amount = isset($yearlySaleSummaryData[$month][$branch->id]) ? $yearlySaleSummaryData[$month][$branch->id] : '0.00'; ?>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $amount)); ?></td>
                        <?php $amountSum += $amount; ?>
                        <?php if (!isset($amountTotals[$branch->id])): ?>
                            <?php $amountTotals[$branch->id] = '0.00'; ?>
                        <?php endif; ?>
                        <?php $amountTotals[$branch->id] += $amount; ?>
                    <?php endforeach; ?>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $amountSum)); ?></td>
                </tr>
        <?php endfor; ?>
    </tbody>
    <tfoot>
        <tr>
            <td>Total</td>
            <?php $grandTotal = '0.00'; ?>
            <?php foreach ($branches as $branch): ?>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $amountTotals[$branch->id])); ?></td>
                <?php $grandTotal += $amountTotals[$branch->id]; ?>
            <?php endforeach; ?>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $grandTotal)); ?></td>
        </tr>
    </tfoot>
</table>