<div class="table_wrapper">
    <fieldset>
        <legend>Transaksi Bank Masuk</legend>
        <table class="responsive">
            <thead>
                <tr>
                    <th style="text-align: center; width: 5%"></th>
                    <?php $amountTotals = array(); ?>
                    <?php foreach ($yearMonthList as $yearMonth): ?>
                        <th style="text-align: center; width: 10%"><?php echo CHtml::encode($yearMonthNames[$yearMonth]); ?></th>
                        <?php $amountTotals[$yearMonth] = '0.00'; ?>
                    <?php endforeach; ?>
                    <th style="text-align: center; font-weight: bold">Total</th>
                </tr>
            </thead>

            <tbody>
                <?php $grandTotal = '0.00'; ?>
                <?php foreach ($paymentInMonthlyList as $coaId => $paymentInMonthlyRow): ?>
                    <?php $amountTotal = '0.00'; ?>
                    <tr>
                        <td><?php echo CHtml::encode($paymentInMonthlyRow['name']); ?></td>
                        <?php foreach ($yearMonthList as $yearMonth): ?>
                            <?php $amount = isset($paymentInMonthlyRow['amounts'][$yearMonth]) ? $paymentInMonthlyRow['amounts'][$yearMonth] : '0.00'; ?>
                            <td style="text-align: right;">
                                <?php echo CHtml::link(CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $amount)), array(
                                    '/report/paymentByBankMonthToMonth/transactionInfo', 
                                    'coaId' => $coaId, 
                                    'debitCredit' => 'D',
                                    'year' => date("Y", strtotime($yearMonth)), 
                                    'month' => date("m", strtotime($yearMonth)), 
                                    'branchId' => $branchId,
                                    'inOut' => 'In',
                                ), array('target' => '_blank')); ?>
                                <?php $amountTotals[$yearMonth] += $amount; ?>
                            </td>
                            <?php $amountTotal += $amount; ?>
                        <?php endforeach; ?>
                        <td style="text-align: right; font-weight: bold;">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $amountTotal)); ?>
                        </td>
                    </tr>
                <?php $grandTotal += $amountTotal; ?>
                <?php endforeach; ?>
            </tbody>

            <tfoot>
                <tr>
                    <td style="text-align: right">Total Monthly</td>
                    <?php foreach ($yearMonthList as $yearMonth): ?>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $amountTotals[$yearMonth])); ?>
                        </td>
                    <?php endforeach; ?>
                    <td style="text-align: right; font-weight: bold">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotal)); ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </fieldset>
</div>