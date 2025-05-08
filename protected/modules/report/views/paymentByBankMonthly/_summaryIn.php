<div class="table_wrapper">
    <fieldset>
        <legend>Transaksi Bank Masuk</legend>
        <table>
            <thead>
                <tr>
                    <th style="text-align: center"></th>
                    <?php $paymentDailyTotals = array(); ?>
                    <?php foreach ($selectedCoas as $coa): ?>
                        <th style="text-align: center"><?php echo CHtml::encode(CHtml::value($coa, 'name')); ?></th>
                        <?php $paymentDailyTotals[$coa->id] = '0.00'; ?>
                    <?php endforeach; ?>
                    <?php $dailyTotal = '0.00'; ?>
                    <th style="text-align: center; font-weight: bold">Total</th>
                </tr>
            </thead>

            <tbody>
                <?php $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year); ?>
                <?php $yearMonth = str_pad($year, 2, '0', STR_PAD_LEFT) . '-' . str_pad($month, 2, '0', STR_PAD_LEFT); ?>
                <?php for ($day = 1; $day <= $daysInMonth; $day++): ?>
                    <?php $date = $yearMonth . '-' . str_pad($day, 2, '0', STR_PAD_LEFT); ?>
                    <?php if (isset($paymentInList[$date])): ?>
                        <?php $paymentInItem = $paymentInList[$date]; ?>
                        <?php $totalPerDate = '0.00'; ?>
                        <tr>
                            <td><?php echo CHtml::encode($date); ?></td>
                            <?php foreach ($selectedCoas as $coa): ?>
                                <?php $paymentInRetail = $paymentInItem[$coa->id]; ?>
                                <td style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $paymentInRetail)); ?>
                                    <?php $paymentDailyTotals[$coa->id] += $paymentInRetail; ?>
                                </td>
                                <?php $totalPerDate += $paymentInRetail; ?>
                            <?php endforeach; ?>
                            <td style="text-align: right; font-weight: bold">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPerDate)); ?>
                            </td>
                        </tr>
                        <?php $dailyTotal += $totalPerDate; ?>
                    <?php else: ?>
                        <tr>
                            <td><?php echo CHtml::encode($date); ?></td>
                            <?php foreach ($selectedCoas as $coa): ?>
                                <td style="text-align: right">0</td>
                            <?php endforeach; ?>
                            <td style="text-align: right; font-weight: bold">0</td>
                        </tr>
                    <?php endif; ?>
                <?php endfor; ?>
            </tbody>

            <tfoot>
                <tr>
                    <td style="text-align: right">Total Monthly</td>
                    <?php foreach ($selectedCoas as $coa): ?>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $paymentDailyTotals[$coa->id])); ?>
                        </td>
                    <?php endforeach; ?>
                    <td style="text-align: right; font-weight: bold">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $dailyTotal)); ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </fieldset>
</div>