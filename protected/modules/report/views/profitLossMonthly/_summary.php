<?php list($startYearNow, $startMonthNow) = explode('-', $startYearMonth); ?>
<?php list($endYearNow, $endMonthNow) = explode('-', $endYearMonth); ?>
<?php $currentStartYear = intval($startYearNow); ?>
<?php $currentStartMonth = intval($startMonthNow); ?>
<?php $currentEndYear = intval($endYearNow); ?>
<?php $currentEndMonth = intval($endMonthNow); ?>
<?php $yearMonthList = array(); ?>
<?php $currentYear = $currentStartYear; ?>
<?php $currentMonth = $currentStartMonth; ?>
<?php while ($currentYear < $currentEndYear || $currentYear === $currentEndYear && $currentMonth <= $currentEndMonth): ?>
    <?php $month = str_pad($currentMonth, 2, '0', STR_PAD_LEFT); ?>
    <?php $yearMonthList[$currentYear . '-' . $month] = date('M', mktime(null, null, null, $currentMonth, 1)) . ' ' . date('y', mktime(null, null, null, $currentMonth, 1, $currentYear)); ?>
    <?php $currentMonth++; ?>
    <?php if ($currentMonth === 13): ?>
        <?php $currentMonth = 1; ?>
        <?php $currentYear++; ?>
    <?php endif; ?>
<?php endwhile; ?>

<?php if (count($yearMonthList) <= 12 && count($yearMonthList) >= 1): ?>
    <table style="width: 100%">
        <thead>
            <tr>
                <th style="width: 768px"></th>
                <?php foreach ($yearMonthList as $yearMonth => $yearMonthFormatted): ?>
                    <th style="width: 256px"><?php echo $yearMonthFormatted; ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php $elementNames = array('4' => 'Pendapatan', '5' => 'Harga Pokok Penjualan', '6' => 'Beban', '7' => 'Pendapatan Lain-lain', '8' => 'Beban Lain-lain'); ?>
            <?php $elementsTotalSums = array(); ?>
            <?php foreach ($yearMonthList as $yearMonth => $yearMonthFormatted): ?>
                <?php $elementsTotalSums['4'][$yearMonth] = '0.00'; ?>
                <?php $elementsTotalSums['5'][$yearMonth] = '0.00'; ?>
                <?php $elementsTotalSums['6'][$yearMonth] = '0.00'; ?>
                <?php $elementsTotalSums['7'][$yearMonth] = '0.00'; ?>
                <?php $elementsTotalSums['8'][$yearMonth] = '0.00'; ?>
            <?php endforeach; ?>
            <?php foreach ($profitLossInfo as $elementNumber => $profitLossElementInfo): ?>
                <?php if ($elementNumber === '5*'): ?>
                    <tr>
                        <td style="text-align: right; font-weight: bold; font-size: 20px;">Profit / Loss Bruto</td>
                        <?php foreach ($yearMonthList as $yearMonth => $yearMonthFormatted): ?>
                            <td style="text-align: right; font-weight: bold; font-size: 20px;">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $elementsTotalSums['4'][$yearMonth] - $elementsTotalSums['5'][$yearMonth])); ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php elseif ($elementNumber === '8*'): ?>
                    <tr>
                        <td style="text-align: right; font-weight: bold; font-size: 20px;">Profit / Loss Net</td>
                        <?php foreach ($yearMonthList as $yearMonth => $yearMonthFormatted): ?>
                            <td style="text-align: right; font-weight: bold; font-size: 20px;">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $elementsTotalSums['4'][$yearMonth] - $elementsTotalSums['5'][$yearMonth] - $elementsTotalSums['6'][$yearMonth] + $elementsTotalSums['7'][$yearMonth] - $elementsTotalSums['8'][$yearMonth])); ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php else: ?>
                    <?php foreach ($profitLossElementInfo as $categoryInfo): ?>
                        <tr>
                            <td colspan="<?php echo count($yearMonthList) + 1; ?>" style="font-weight: bold">
                                <?php echo $categoryInfo['code']; ?> - <?php echo $categoryInfo['name']; ?>
                            </td>
                        </tr>
                        <?php $categoryTotalSums = array(); ?>
                        <?php foreach ($yearMonthList as $yearMonth => $yearMonthFormatted): ?>
                            <?php $categoryTotalSums[$yearMonth] = '0.00'; ?>
                        <?php endforeach; ?>
                        <?php foreach ($categoryInfo['sub_categories'] as $subCategoryInfo): ?>
                            <tr>
                                <td colspan="<?php echo count($yearMonthList) + 1; ?>" style="padding-left: 25px; font-weight: bold;">
                                    <?php echo $subCategoryInfo['code']; ?> - <?php echo $subCategoryInfo['name']; ?>
                                </td>
                            </tr>
                            <?php $subCategoryTotalSums = array(); ?>
                            <?php foreach ($yearMonthList as $yearMonth => $yearMonthFormatted): ?>
                                <?php $subCategoryTotalSums[$yearMonth] = '0.00'; ?>
                            <?php endforeach; ?>
                            <?php foreach ($subCategoryInfo['accounts'] as $coaId => $accountInfo): ?>
                                <?php $nonZeroValueExists = false; ?>
                                <?php foreach ($yearMonthList as $yearMonth => $yearMonthFormatted): ?>
                                    <?php $value = isset($accountInfo['totals'][$yearMonth]) ? $accountInfo['totals'][$yearMonth] : '0.00'; ?>
                                    <?php if ($value > 0): ?>
                                        <?php $nonZeroValueExists = true; ?>
                                        <?php break; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <?php if ($nonZeroValueExists): ?>
                                    <tr>
                                        <td style="padding-left: 50px;">
                                            <?php echo $accountInfo['code']; ?> - <?php echo $accountInfo['name']; ?>
                                        </td>
                                        <?php foreach ($yearMonthList as $yearMonth => $yearMonthFormatted): ?>
                                            <?php $balance = isset($accountInfo['totals'][$yearMonth]) ? $accountInfo['totals'][$yearMonth] : 0; ?>
                                            <td style="text-align: right">
                                                <?php echo CHtml::link(CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $balance)), Yii::app()->createUrl("report/profitLossMonthly/jurnalTransaction", array(
                                                    "CoaId" => $coaId, 
                                                    "YearMonth" => $yearMonth, 
                                                    "BranchId" => $branchId
                                                )), array('target' => '_blank')); ?>
                                            </td>
                                            <?php $subCategoryTotalSums[$yearMonth] += $balance; ?>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endif; ?>
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
                            <?php $elementsTotalSums[$elementNumber][$yearMonth] += $categoryTotalSums[$yearMonth]; ?>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
<!--                    <tr>
                        <td style="text-align: right; font-weight: bold; font-size: 18px;">Total <?php /*echo $elementNames[$elementNumber]; ?></td>
                        <?php foreach ($yearMonthList as $yearMonth => $yearMonthFormatted): ?>
                            <td style="text-align: right; font-weight: bold; font-size: 18px;">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $elementsTotalSums[$elementNumber][$yearMonth])); ?>
                            </td>
                        <?php endforeach;*/ ?>
                    </tr>-->
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>