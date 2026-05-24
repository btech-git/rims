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
            <?php $balances = array(); ?>
            <?php $coaParentCodes = array(); ?>
            <?php $previousLevel = 0; ?>
            <?php $currentLevel = 0; ?>
            <?php foreach ($balanceSheetReportData as $coaCode => $balanceSheetReportItem): ?>
                <?php $currentLevel = $balanceSheetReportItem['level']; ?>
            
                <?php $coaParentCodes[$currentLevel] = $balanceSheetReportItem['parent_code']; ?>
            
                <?php if ($coaCode === '303.00.001'): ?>
                    <?php $balance = $netProfit; ?>
                <?php else: ?>
                    <?php $balance = isset($balanceSheetReportItem['balance']) ? $balanceSheetReportItem['balance'] : ''; ?>
                <?php endif; ?>
                <?php $balances[$currentLevel]['amounts'][] = empty($balance) ? '0.00' : $balance; ?>
            
                <?php while ($previousLevel > $currentLevel): ?>
                    <?php $amountSum = array_sum($balances[$previousLevel]['amounts']); ?>
            
                    <?php $balances[$previousLevel]['amounts'] = array(); ?>
                    <?php $balances[$previousLevel - 1]['amounts'][] = $amountSum; ?>
            
                    <tr>
                        <td style="font-weight: bold; background-color: bisque; padding-left: <?php echo 32 * ($previousLevel - 1); ?>px">Total <?php echo CHtml::encode($balanceSheetReportData[$coaParentCodes[$previousLevel]]['name']); ?></td>
                        <td style="font-weight: bold; background-color: bisque; color: <?php echo $amountSum < 0 ? 'red': 'black'; ?>; text-align: right"><?php echo CHtml::encode($amountSum === '' ? '' : Yii::app()->numberFormatter->format('#,##0.00', $amountSum)); ?></td>
                    </tr>
                    
                    <?php $previousLevel--; ?>
                <?php endwhile; ?>
                    
                <tr>
                    <td style="padding-left: <?php echo 32 * $balanceSheetReportItem['level']; ?>px"><?php echo CHtml::encode($coaCode); ?> - <?php echo CHtml::encode($balanceSheetReportItem['name']); ?></td>
                    <td style="text-align: right; color: <?php echo $balance < 0 ? 'red': 'black'; ?>;"><?php echo CHtml::encode($balance === '' ? '' : Yii::app()->numberFormatter->format('#,##0.00', $balance)); ?></td>
                </tr>
                    
                <?php $previousLevel = $currentLevel; ?>
            <?php endforeach; ?>
            <?php for ($i = $currentLevel - 1; $i > 0; $i--): ?>
                <?php while ($previousLevel > $i): ?>
                    <?php $amountSum = array_sum($balances[$previousLevel]['amounts']); ?>
            
                    <?php $balances[$previousLevel]['amounts'] = array(); ?>
                    <?php $balances[$previousLevel - 1]['amounts'][] = $amountSum; ?>
            
                    <tr>
                        <td style="font-weight: bold; background-color: bisque; padding-left: <?php echo 32 * ($previousLevel - 1); ?>px">Total <?php echo CHtml::encode($balanceSheetReportData[$coaParentCodes[$previousLevel]]['name']); ?></td>
                        <td style="font-weight: bold; background-color: bisque; color: <?php echo $amountSum < 0 ? 'red': 'black'; ?>; text-align: right"><?php echo CHtml::encode($amountSum === '' ? '' : Yii::app()->numberFormatter->format('#,##0.00', $amountSum)); ?></td>
                    </tr>
                    
                    <?php $previousLevel--; ?>
                <?php endwhile; ?>
            <?php endfor; ?>
        </tbody>
    </table>
</div>