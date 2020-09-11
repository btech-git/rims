<div id="maincontent">
    <div class="clearfix page-action">
        <div class="form">
            <?php echo CHtml::beginForm(array(''), 'get'); ?>

            <p class="note">Fields with <span class="required">*</span> are required.</p>

            <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
            <?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>

            <div class="row">
                <div class="medium-12 columns">
                    <div class="row">
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <label class="prefix">Tanggal</label>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                            'name' => 'TransactionDate',
                                            'value' => $transactionDate,
                                            // additional javascript options for the date picker plugin
                                            'options' => array(
                                                'dateFormat' => 'yy-mm-dd',
                                                'changeMonth' => true,
                                                'changeYear' => true,
                                            ),
                                            'htmlOptions' => array(
                                                'readonly' => true,
                                            ),
                                        )); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- END COLUMN 6-->
                        <div class="medium-6 columns">
<!--                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <label class="prefix"></label>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php //echo CHtml::dropDownList('BranchId', $branchId, CHtml::listData(Branch::model()->findAll(), 'id', 'name'), array('empty' => '-- All Branch --')); ?>
                                    </div>
                                </div>
                            </div>-->
                        </div>

                        <div>
                            <?php echo CHtml::resetButton('Clear'); ?>
                            <?php echo CHtml::submitButton('Show', array('onclick' => '$("#CurrentSort").val(""); return true;')); ?>
                        </div>

                    </div>
                </div>
            </div>
            
            <hr />
            
            <div class="row">
                <?php foreach ($coaBankDataProvider->data as $coaBank): ?>
                    <p><h2><?php echo CHtml::encode(CHtml::value($coaBank, 'name')); ?></h2></p>
                    <table>
                        <thead>
                            <tr>
                                <td>Transaction</td>
                                <td>Debit</td>
                                <td>Credit</td>
                                <td>Saldo</td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align: right">Saldo Awal</td>
                                <td style="text-align: right">
                                    <?php $beginningBalance = $coaBank->getReportBeginningBalanceDebit($transactionDate, null) - $coaBank->getReportBeginningBalanceCredit($transactionDate, null); ?>
                                    <?php echo CHtml::encode(number_format($beginningBalance, 0)); ?>
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $forecastData = $coaBank->getReportForecastData($transactionDate); ?>
                            <?php foreach ($forecastData as $forecastItem): ?>
                            <tr>
                                <td><?php echo CHtml::encode($forecastItem['transaction_subject']); ?></td>
                                <td style="text-align: right">
                                    <?php $totalDebit = $forecastItem['debet_kredit'] == 'D'? $forecastItem['total'] : 0; ?>
                                    <?php echo number_format($totalDebit, 0); ?>
                                </td>
                                <td style="text-align: right">
                                    <?php $totalCredit = $forecastItem['debet_kredit'] == 'K'? $forecastItem['total'] : 0; ?>
                                    <?php echo number_format($totalCredit, 0); ?>
                                </td>
                                <td style="text-align: right">
                                    <?php $balance = $beginningBalance + $totalCredit - $totalDebit; ?>
                                    <?php echo number_format($balance, 0); ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endforeach; ?>
            </div>

            <div class="row">
                <p><h2>Hutang Supplier</h2></p>
                <table>
                    <thead>
                        <tr>
                            <td>Supplier</td>
                            <td>Amount</td>
                            <td>Jatuh Tempo</td>
                            <td>Hari</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($payableTransactionDataProvider->data as $payableTransaction): ?>
                        <tr>
                            <td><?php echo CHtml::encode(CHtml::value($payableTransaction, 'supplier.name')); ?></td>
                            <td style="text-align: right"><?php echo number_format(CHtml::encode(CHtml::value($payableTransaction, 'payment_left')), 0); ?></td>
                            <td><?php echo CHtml::link(Yii::app()->dateFormatter->format("d MMM yyyy", CHtml::value($payableTransaction, 'estimate_payment_date')), array('javascript:;'), array(
                                'onclick' => 'window.open("' . CController::createUrl('/accounting/financialForecast/updateDueDate', array('id' => $payableTransaction->id)) . '", "_blank", "top=100, left=425, width=500, height=500"); return false;'
                                )); ?></td>
                            <td><?php echo CHtml::encode(date('l', strtotime(CHtml::value($payableTransaction, 'estimate_payment_date')))); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="row">
                    <p><h2>Piutang Customer</h2></p>
                    <table>
                        <thead>
                            <tr>
                                <td>Customer</td>
                                <td>Amount</td>
                                <td>Jatuh Tempo</td>
                                <td>Hari</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($receivableTransactionDataProvider->data as $receivableTransaction): ?>
                            <tr>
                                <td><?php echo CHtml::encode(CHtml::value($receivableTransaction, 'customer.name')); ?></td>
                                <td style="text-align: right"><?php echo number_format(CHtml::encode(CHtml::value($receivableTransaction, 'payment_left')), 0); ?></td>
                                <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", CHtml::value($receivableTransaction, 'due_date'))); ?></td>
                            <td><?php echo CHtml::encode(date('l', strtotime(CHtml::value($receivableTransaction, 'due_date')))); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
            </div>

            <?php echo CHtml::endForm(); ?>
        </div>
    </div>
</div>