<div class="relative">
    <div style="font-weight: bold; text-align: center">
        <?php $branch = Branch::model()->findByPk($branchId); ?>
        <div style="font-size: larger">Raperind Motor <?php echo CHtml::encode(($branch === null) ? '' : $branch->name); ?></div>
        <div style="font-size: large">Neraca (Standar)</div>
        <div><?php echo ' Periode: &nbsp;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' - ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
    </div>

    <br />
    
    <table>
        <tbody>
            <?php foreach ($balanceSheetReportData as $coaCode => $balanceSheetReportItem): ?>
                <?php $balance = isset($balanceSheetReportItem['balance']) ? $balanceSheetReportItem['balance'] : '' ?>
                <tr>
                    <td style="padding-left: <?php echo 32 * $balanceSheetReportItem['level']; ?>px"><?php echo CHtml::encode($coaCode); ?> - <?php echo CHtml::encode($balanceSheetReportItem['name']); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode($balance); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>