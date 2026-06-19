<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">
        <?php //$branch = Branch::model()->findByPk($branchId); ?>
        Raperind Motor <?php //echo CHtml::encode(CHtml::value($branch, 'name')); ?>
    </div>
    <div style="font-size: larger">Body Repair Transaction Yearly</div>
    <div><?php echo CHtml::encode($year); ?></div>
</div>

<br />

<div class="table_wrapper">
    <fieldset>
        <table class="responsive">
            <thead>
                <tr>
                    <th style="text-align: center; width: 10%">Bulan</th>
                    <th style="text-align: center; width: 10%">Registration</th>
                    <th style="text-align: center; width: 10%">WO</th>
                    <th style="text-align: center; width: 10%">Sub Pekerjaan Cat</th>
                    <th style="text-align: center; width: 10%">Sub Pekerjaan Lain</th>
                    <th style="text-align: center; width: 10%">Payment Sub Pekerjaan</th>
                    <th style="text-align: center; width: 10%">Invoice</th>
                    <th style="text-align: center; width: 10%">Payment In</th>
                </tr>
            </thead>

            <tbody>
                <?php $registrationTransactionCountSum = 0; ?>
                <?php $workOrderCountSum = 0; ?>
                <?php $workOrderExpensePaintingCountSum = 0; ?>
                <?php $workOrderExpenseOtherCountSum = 0; ?>
                <?php $paymentOutTransactionCountSum = 0; ?>
                <?php $invoiceTransactionCountSum = 0; ?>
                <?php $paymentInTransactionCountSum = 0; ?>
                <?php for ($i = 1; $i <= 12; $i++): ?>
                    <?php $registrationTransactionCount = isset($bodyRepairTransactionInfoData[$i]['transaction_count']) ? $bodyRepairTransactionInfoData[$i]['transaction_count'] : 0; ?>
                    <?php $workOrderCount = isset($bodyRepairTransactionInfoData[$i]['work_order_count']) ? $bodyRepairTransactionInfoData[$i]['work_order_count'] : 0; ?>
                    <?php $workOrderExpensePaintingCount = isset($bodyRepairTransactionInfoData[$i]['work_order_expense_painting_count']) ? $bodyRepairTransactionInfoData[$i]['work_order_expense_painting_count'] : 0; ?>
                    <?php $workOrderExpenseOtherCount = isset($bodyRepairTransactionInfoData[$i]['work_order_expense_other_count']) ? $bodyRepairTransactionInfoData[$i]['work_order_expense_other_count'] : 0; ?>
                    <?php $paymentOutTransactionCountData = isset($bodyRepairTransactionInfoData[$i]['payment_out_count']) ? $bodyRepairTransactionInfoData[$i]['payment_out_count'] : 0; ?>
                    <?php $invoiceTransactionCount = isset($bodyRepairTransactionInfoData[$i]['invoice_count']) ? $bodyRepairTransactionInfoData[$i]['invoice_count'] : 0; ?>
                    <?php $paymentInTransactionCountData = isset($bodyRepairTransactionInfoData[$i]['payment_in_count']) ? $bodyRepairTransactionInfoData[$i]['payment_in_count'] : 0; ?>
                    <tr>
                        <td><?php echo CHtml::encode($monthList[$i]); ?></td>
                        <td style="text-align: center">
                            <?php echo CHtml::link(CHtml::encode($registrationTransactionCount), array(
                                'registrationTransactionMonthlyInfo', 
                                'year' => $year,
                                'month' => $i,
                            ), array('target' => '_blank')); ?>
                        </td>
                        <td style="text-align: center">
                            <?php echo CHtml::link(CHtml::encode($workOrderCount), array(
                                'workOrderMonthlyInfo', 
                                'year' => $year,
                                'month' => $i,
                            ), array('target' => '_blank')); ?>
                        </td>
                        <td style="text-align: center">
                            <?php echo CHtml::link(CHtml::encode($workOrderExpensePaintingCount), array(
                                'workOrderExpensePaintingMonthlyInfo', 
                                'year' => $year,
                                'month' => $i,
                            ), array('target' => '_blank')); ?>
                        </td>
                        <td style="text-align: center">
                            <?php echo CHtml::link(CHtml::encode($workOrderExpenseOtherCount), array(
                                'workOrderExpenseOtherMonthlyInfo', 
                                'year' => $year,
                                'month' => $i,
                            ), array('target' => '_blank')); ?>
                        </td>
                        <td style="text-align: center">
                            <?php echo CHtml::link(CHtml::encode($paymentOutTransactionCountData), array(
                                'paymentOutMonthlyInfo', 
                                'year' => $year,
                                'month' => $i,
                            ), array('target' => '_blank')); ?>
                        </td>
                        <td style="text-align: center">
                            <?php echo CHtml::link(CHtml::encode($invoiceTransactionCount), array(
                                'invoiceTransactionMonthlyInfo', 
                                'year' => $year,
                                'month' => $i,
                            ), array('target' => '_blank')); ?>
                        </td>
                        <td style="text-align: center">
                            <?php echo CHtml::link(CHtml::encode($paymentInTransactionCountData), array(
                                'paymentInMonthlyInfo', 
                                'year' => $year,
                                'month' => $i,
                            ), array('target' => '_blank')); ?>
                        </td>
                    </tr>
                    <?php $registrationTransactionCountSum += $registrationTransactionCount; ?>
                    <?php $workOrderCountSum += $workOrderCount; ?>
                    <?php $workOrderExpensePaintingCountSum += $workOrderExpensePaintingCount; ?>
                    <?php $workOrderExpenseOtherCountSum += $workOrderExpenseOtherCount; ?>
                    <?php $paymentOutTransactionCountSum += $paymentOutTransactionCountData; ?>
                    <?php $invoiceTransactionCountSum += $invoiceTransactionCount; ?>
                    <?php $paymentInTransactionCountSum += $paymentInTransactionCountData; ?>
                <?php endfor; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td>TOTAL</td>
                    <td style="text-align: center">
                        <?php echo CHtml::link(CHtml::encode($registrationTransactionCountSum), array(
                            'registrationTransactionYearlyInfo', 
                            'year' => $year,
                        ), array('target' => '_blank')); ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo CHtml::link(CHtml::encode($workOrderCountSum), array(
                            'workOrderYearlyInfo', 
                            'year' => $year,
                        ), array('target' => '_blank')); ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo CHtml::link(CHtml::encode($workOrderExpensePaintingCountSum), array(
                            'workOrderExpensePaintingYearlyInfo', 
                            'year' => $year,
                        ), array('target' => '_blank')); ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo CHtml::link(CHtml::encode($workOrderExpenseOtherCountSum), array(
                            'workOrderExpenseOtherYearlyInfo', 
                            'year' => $year,
                        ), array('target' => '_blank')); ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo CHtml::link(CHtml::encode($paymentOutTransactionCountSum), array(
                            'paymentOutYearlyInfo', 
                            'year' => $year,
                        ), array('target' => '_blank')); ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo CHtml::link(CHtml::encode($invoiceTransactionCountSum), array(
                            'invoiceTransactionYearlyInfo', 
                            'year' => $year,
                        ), array('target' => '_blank')); ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo CHtml::link(CHtml::encode($paymentInTransactionCountSum), array(
                            'paymentInYearlyInfo', 
                            'year' => $year,
                        ), array('target' => '_blank')); ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </fieldset>
</div>