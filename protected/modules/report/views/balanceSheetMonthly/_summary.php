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
    <table class="report" style="table-layout: fixed; width: 2000px">
        <thead>
            <tr>
                <th style="width: 384px"></th>
                <th style="width: 192px">Saldo Awal</th>
                <?php foreach ($yearMonthList as $yearMonth => $yearMonthFormatted): ?>
                    <th style="width: 192px"><?php echo $yearMonthFormatted; ?> - Debit</th>
                    <th style="width: 192px"><?php echo $yearMonthFormatted; ?> - Credit</th>
                    <th style="width: 192px"><?php echo $yearMonthFormatted; ?> - Saldo</th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php $elementNames = array('1' => 'Aktiva', '2' => 'Kewajiban', '3' => 'Ekuitas'); ?>
            <?php $elementsTotalSums = array(); ?>
            <?php foreach ($yearMonthList as $yearMonth => $yearMonthFormatted): ?>
                <?php $elementsTotalSums['1'][$yearMonth] = '0.00'; ?>
                <?php $elementsTotalSums['2'][$yearMonth] = '0.00'; ?>
                <?php $elementsTotalSums['3'][$yearMonth] = '0.00'; ?>
            <?php endforeach; ?>
            <?php foreach ($balanceSheetInfo as $elementNumber => $balanceSheetElementInfo): ?>
                <?php if ($elementNumber === '3*'): ?>
                    <tr>
                        <td style="text-align: right; font-weight: bold; font-size: 20px;">Total Kewajiban & Ekuitas</td>
                        <td></td>
                        <?php foreach ($yearMonthList as $yearMonth => $yearMonthFormatted): ?>
                            <td></td>
                            <td></td>
                            <td style="text-align: right; font-weight: bold; font-size: 20px;">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $elementsTotalSums['2'][$yearMonth] + $elementsTotalSums['3'][$yearMonth])); ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php else: ?>
                    <?php foreach ($balanceSheetElementInfo as $categoryInfo): ?>
                        <tr>
                            <td colspan="<?php echo count($yearMonthList) * 3 + 2; ?>" style="font-weight: bold">
                                <?php echo $categoryInfo['code']; ?> - <?php echo $categoryInfo['name']; ?>
                            </td>
                        </tr>
                        <?php $categoryTotalSums = array(); ?>
                        <?php foreach ($yearMonthList as $yearMonth => $yearMonthFormatted): ?>
                            <?php $categoryTotalSums[$yearMonth] = '0.00'; ?>
                        <?php endforeach; ?>
                        <?php foreach ($categoryInfo['sub_categories'] as $subCategoryInfo): ?>
                            <tr>
                                <td colspan="<?php echo count($yearMonthList) * 3 + 2; ?>" style="padding-left: 25px; font-weight: bold;">
                                    <?php echo $subCategoryInfo['code']; ?> - <?php echo $subCategoryInfo['name']; ?>
                                </td>
                            </tr>
                            <?php $subCategoryTotalSums = array(); ?>
                            <?php foreach ($yearMonthList as $yearMonth => $yearMonthFormatted): ?>
                                <?php $subCategoryTotalSums[$yearMonth] = '0.00'; ?>
                            <?php endforeach; ?>
                            <?php foreach ($subCategoryInfo['accounts'] as $coaId => $accountInfo): ?>
                                <?php //$nonZeroValueExists = false; ?>
                                <?php //foreach ($yearMonthList as $yearMonth => $yearMonthFormatted): ?>
                                    <?php //$value = isset($accountInfo['totals'][$yearMonth]) ? $accountInfo['totals'][$yearMonth] : '0.00'; ?>
                                    <?php //if ($value > 0): ?>
                                        <?php //$nonZeroValueExists = true; ?>
                                        <?php //break; ?>
                                    <?php //endif; ?>
                                <?php //endforeach; ?>
                                <?php //if ($nonZeroValueExists): ?>
                                    <tr>
                                        <?php $beginningBalance = isset($beginningBalanceInfo[$coaId]) ? $beginningBalanceInfo[$coaId] : '0.00'; ?>
                                        <?php $currentBalance = $beginningBalance; ?>
                                        <td style="padding-left: 50px;"><?php echo $accountInfo['code']; ?> - <?php echo $accountInfo['name']; ?></td>
                                        <td style="text-align: right">
                                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $beginningBalance)); ?>
                                        </td>
                                        <?php foreach ($yearMonthList as $yearMonth => $yearMonthFormatted): ?>
                                            <?php $debit = isset($accountInfo['debits'][$yearMonth]) ? $accountInfo['debits'][$yearMonth] : ''; ?>
                                            <td style="text-align: right">
                                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $debit)); ?>
                                            </td>
                                            <?php $credit = isset($accountInfo['credits'][$yearMonth]) ? $accountInfo['credits'][$yearMonth] : ''; ?>
                                            <td style="text-align: right">
                                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $credit)); ?>
                                            </td>
                                            <?php $balance = isset($accountInfo['totals'][$yearMonth]) ? $accountInfo['totals'][$yearMonth] : ''; ?>
                                            <?php $currentBalance += $balance; ?>
                                            <td style="text-align: right">
                                                <?php echo CHtml::link(CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $currentBalance)), Yii::app()->createUrl("report/balanceSheetMonthly/jurnalTransaction", array(
                                                    "CoaId" => $coaId, 
                                                    "YearMonth" => $yearMonth, 
                                                    "BranchId" => $branchId
                                                )), array('target' => '_blank')); ?>
                                            </td>
                                            <?php $subCategoryTotalSums[$yearMonth] += $currentBalance; ?>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php //endif; ?>
                            <?php endforeach; ?>
                            <tr>
                                <td style="text-align: right; font-weight: bold; font-size: 14px;">Total <?php echo $subCategoryInfo['name']; ?></td>
                                <td></td>
                                <?php foreach ($yearMonthList as $yearMonth => $yearMonthFormatted): ?>
                                    <td></td>
                                    <td></td>
                                    <td style="text-align: right; font-weight: bold; font-size: 14px;">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $subCategoryTotalSums[$yearMonth])); ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                            <?php foreach ($yearMonthList as $yearMonth => $yearMonthFormatted): ?>
                                <?php $categoryTotalSums[$yearMonth] += $subCategoryTotalSums[$yearMonth]; ?>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                        <tr>
                            <td style="text-align: right; font-weight: bold; font-size: 16px;">Total <?php echo $categoryInfo['name']; ?></td>
                            <td></td>
                            <?php foreach ($yearMonthList as $yearMonth => $yearMonthFormatted): ?>
                                <td></td>
                                <td></td>
                                <td style="text-align: right; font-weight: bold; font-size: 16px;">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $categoryTotalSums[$yearMonth])); ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                        <?php foreach ($yearMonthList as $yearMonth => $yearMonthFormatted): ?>
                            <?php $elementsTotalSums[$elementNumber][$yearMonth] += $categoryTotalSums[$yearMonth]; ?>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                    <tr>
                        <td style="text-align: right; font-weight: bold; font-size: 18px;">Total <?php echo $elementNames[$elementNumber]; ?></td>
                        <td></td>
                        <?php foreach ($yearMonthList as $yearMonth => $yearMonthFormatted): ?>
                            <td></td>
                            <td></td>
                            <td style="text-align: right; font-weight: bold; font-size: 18px;">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $elementsTotalSums[$elementNumber][$yearMonth])); ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>