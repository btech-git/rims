<?php foreach ($balanceSheetInfo[$elementNumber] as $categoryInfo): ?>
    <tr>
        <td colspan="<?php echo count($yearMonthList) + 1; ?>" style="font-weight: bold"><?php echo $categoryInfo['code']; ?> - <?php echo $categoryInfo['name']; ?></td>
    </tr>
    <?php $categoryTotalSums = array(); ?>
    <?php foreach ($yearMonthList as $yearMonth => $yearMonthFormatted): ?>
        <?php $categoryTotalSums[$yearMonth] = '0.00'; ?>
    <?php endforeach; ?>
    <?php foreach ($categoryInfo['sub_categories'] as $subCategoryInfo): ?>
        <tr>
            <td colspan="<?php echo count($yearMonthList) + 1; ?>" style="padding-left: 25px; font-weight: bold;"><?php echo $subCategoryInfo['code']; ?> - <?php echo $subCategoryInfo['name']; ?></td>
        </tr>
        <?php $subCategoryTotalSums = array(); ?>
        <?php foreach ($yearMonthList as $yearMonth => $yearMonthFormatted): ?>
            <?php $subCategoryTotalSums[$yearMonth] = '0.00'; ?>
        <?php endforeach; ?>
        <?php foreach ($subCategoryInfo['accounts'] as $accountInfo): ?>
            <tr>
                <td style="padding-left: 50px;"><?php echo $accountInfo['code']; ?> - <?php echo $accountInfo['name']; ?></td>
                <?php foreach ($yearMonthList as $yearMonth => $yearMonthFormatted): ?>
                    <?php $balance = isset($accountInfo['totals'][$yearMonth]) ? $accountInfo['totals'][$yearMonth] : ''; ?>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $balance)); ?>
                    </td>
                    <?php $subCategoryTotalSums[$yearMonth] += $balance; ?>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td style="text-align: right; font-weight: bold; font-size: 14px;">Total <?php echo $subCategoryInfo['name']; ?></td>
            <?php foreach ($yearMonthList as $yearMonth => $yearMonthFormatted): ?>
                <td style="text-align: right; font-weight: bold; font-size: 14px;">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $subCategoryTotalSums[$yearMonth])); ?>
                </td>
            <?php endforeach; ?>
        </tr>
        <?php foreach ($yearMonthList as $yearMonth => $yearMonthFormatted): ?>
            <?php $categoryTotalSums[$yearMonth] += $subCategoryTotalSums[$yearMonth]; ?>
        <?php endforeach; ?>
    <?php endforeach; ?>
    <tr>
        <td style="text-align: right; font-weight: bold; font-size: 16px;">Total <?php echo $categoryInfo['name']; ?></td>
        <?php foreach ($yearMonthList as $yearMonth => $yearMonthFormatted): ?>
            <td style="text-align: right; font-weight: bold; font-size: 16px;">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $categoryTotalSums[$yearMonth])); ?>
            </td>
        <?php endforeach; ?>
    </tr>
    <?php foreach ($yearMonthList as $yearMonth => $yearMonthFormatted): ?>
        <?php $accountingElementTotal->setTotalByElementNumber($elementNumber, $accountingElementTotal->getTotalByElementNumber($elementNumber) + $subCategoryTotalSums[$yearMonth]); ?>
    <?php endforeach; ?>
<?php endforeach; ?>
<tr>
    <td style="text-align: right; font-weight: bold; font-size: 18px;">Total <?php echo $elementNames[$elementNumber]; ?></td>
    <?php foreach ($yearMonthList as $yearMonth => $yearMonthFormatted): ?>
        <td style="text-align: right; font-weight: bold; font-size: 18px;">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $accountingElementTotal->getTotalByElementNumber($elementNumber))); ?>
        </td>
    <?php endforeach; ?>
</tr>