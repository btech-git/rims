<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">
        <?php //$branch = Branch::model()->findByPk($branchId); ?>
        Raperind Motor <?php //echo CHtml::encode(CHtml::value($branch, 'name')); ?>
    </div>
    <div style="font-size: larger">Body Repair Transaction Monthly</div>
    <div><?php echo CHtml::encode(strftime("%B",mktime(0,0,0,$month))); ?> <?php echo CHtml::encode($year); ?></div>
</div>

<br />

<div class="table_wrapper">
    <fieldset>
        <table class="responsive">
            <thead>
                <tr>
                    <th style="text-align: center; width: 10%">Tanggal</th>
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
                <?php for ($i = 1; $i <= $numberOfDays; $i++): ?>
                    <?php $transactionDate = $year . '-' . $month . '-' . str_pad($i, 2, '0', STR_PAD_LEFT); ?>
                    <?php $registrationTransactionCount = isset($bodyRepairTransactionInfoData[$transactionDate]['transaction_count']) ? $bodyRepairTransactionInfoData[$transactionDate]['transaction_count'] : 0; ?>
                    <?php $workOrderCount = isset($bodyRepairTransactionInfoData[$transactionDate]['work_order_count']) ? $bodyRepairTransactionInfoData[$transactionDate]['work_order_count'] : 0; ?>
                    <?php $workOrderExpensePaintingCount = isset($bodyRepairTransactionInfoData[$transactionDate]['work_order_expense_painting_count']) ? $bodyRepairTransactionInfoData[$transactionDate]['work_order_expense_painting_count'] : 0; ?>
                    <?php $workOrderExpenseOtherCount = isset($bodyRepairTransactionInfoData[$transactionDate]['work_order_expense_other_count']) ? $bodyRepairTransactionInfoData[$transactionDate]['work_order_expense_other_count'] : 0; ?>
                    <?php $paymentOutTransactionCountData = isset($bodyRepairTransactionInfoData[$transactionDate]['payment_out_count']) ? $bodyRepairTransactionInfoData[$transactionDate]['payment_out_count'] : 0; ?>
                    <?php $invoiceTransactionCount = isset($bodyRepairTransactionInfoData[$transactionDate]['invoice_count']) ? $bodyRepairTransactionInfoData[$transactionDate]['invoice_count'] : 0; ?>
                    <?php $paymentInTransactionCountData = isset($bodyRepairTransactionInfoData[$transactionDate]['payment_in_count']) ? $bodyRepairTransactionInfoData[$transactionDate]['payment_in_count'] : 0; ?>
                    <tr>
                        <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($transactionDate))); ?></td>
                        <td style="text-align: center">
                            <?php echo CHtml::link(CHtml::encode($registrationTransactionCount), array(
                                'registrationTransactionInfo', 
                                'transactionDate' => $transactionDate, 
                            ), array('target' => '_blank')); ?>
                        </td>
                        <td style="text-align: center">
                            <?php echo CHtml::link(CHtml::encode($workOrderCount), array(
                                'workOrderInfo', 
                                'transactionDate' => $transactionDate, 
                            ), array('target' => '_blank')); ?>
                        </td>
                        <td style="text-align: center">
                            <?php echo CHtml::link(CHtml::encode($workOrderExpensePaintingCount), array(
                                'workOrderExpensePaintingInfo', 
                                'transactionDate' => $transactionDate, 
                            ), array('target' => '_blank')); ?>
                        </td>
                        <td style="text-align: center">
                            <?php echo CHtml::link(CHtml::encode($workOrderExpenseOtherCount), array(
                                'workOrderExpenseOtherInfo', 
                                'transactionDate' => $transactionDate, 
                            ), array('target' => '_blank')); ?>
                        </td>
                        <td style="text-align: center">
                            <?php echo CHtml::link(CHtml::encode($paymentOutTransactionCountData), array(
                                'paymentOutInfo', 
                                'transactionDate' => $transactionDate, 
                            ), array('target' => '_blank')); ?>
                        </td>
                        <td style="text-align: center">
                            <?php echo CHtml::link(CHtml::encode($invoiceTransactionCount), array(
                                'invoiceServiceInfo', 
                                'transactionDate' => $transactionDate, 
                            ), array('target' => '_blank')); ?>
                        </td>
                        <td style="text-align: center">
                            <?php echo CHtml::link(CHtml::encode($paymentInTransactionCountData), array(
                                'workOrderExpenseInfo', 
                                'transactionDate' => $transactionDate, 
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
                            'registrationTransactionMonthlyInfo', 
                            'month' => $month,
                            'year' => $year,
                        ), array('target' => '_blank')); ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo CHtml::link(CHtml::encode($workOrderCountSum), array(
                            'workOrderExpenseMonthlyInfo', 
                            'month' => $month,
                            'year' => $year,
                        ), array('target' => '_blank')); ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo CHtml::link(CHtml::encode($workOrderExpensePaintingCountSum), array(
                            'registrationServiceMonthlyInfo', 
                            'month' => $month,
                            'year' => $year,
                        ), array('target' => '_blank')); ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo CHtml::link(CHtml::encode($workOrderExpenseOtherCountSum), array(
                            'invoiceVehicleMonthlyInfo', 
                            'month' => $month,
                            'year' => $year,
                        ), array('target' => '_blank')); ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo CHtml::link(CHtml::encode($paymentOutTransactionCountSum), array(
                            'workOrderExpenseMonthlyInfo', 
                            'month' => $month,
                            'year' => $year,
                        ), array('target' => '_blank')); ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo CHtml::link(CHtml::encode($invoiceTransactionCountSum), array(
                            'invoiceServiceMonthlyInfo', 
                            'month' => $month,
                            'year' => $year,
                        ), array('target' => '_blank')); ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo CHtml::link(CHtml::encode($paymentInTransactionCountSum), array(
                            'workOrderExpenseMonthlyInfo', 
                            'month' => $month,
                            'year' => $year,
                        ), array('target' => '_blank')); ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </fieldset>
</div>