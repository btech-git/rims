<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');
?>

<div class="clear"></div>

<div class="tab reportTab">
    <div class="tabHead"></div>

    <div class="tabBody">
        <div id="detail_div">
            <div>
                <div class="relative">
                    <div style="font-weight: bold; text-align: center">
                        <div style="font-size: larger">Detail Transactions</div>
                        <div>
                            <?php echo ' Tanggal: &nbsp;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($transactionDate))); ?>
                        </div>
                    </div>

                    <br />

                    <table style="width: 80%; margin: 0 auto; border-spacing: 0pt">
                        <tr>
                            <td style="font-size: larger; font-weight: bold; text-transform: uppercase">
                                Bank:
                            </td>

                            <td style="font-size: larger; font-weight: bold; text-transform: uppercase">
                                <?php echo CHtml::encode(CHtml::value($coa, 'code')); ?>
                            </td>

                            <td style="font-size: larger; font-weight: bold; text-transform: uppercase" colspan="4"> 
                                <?php echo CHtml::encode(CHtml::value($coa, 'name')); ?>
                            </td>
                        </tr>

                        <tr>
                            <td style="text-align: right; font-weight: bold; text-transform: uppercase" colspan="4">
                                Saldo Awal 
                            </td>

                            <td style="text-align: right; font-weight: bold">
                                <?php if (empty($coa)): ?>
                                    <?php echo '0'; ?>
                                <?php else: ?>
                                    <?php //$saldo = $coa->getBeginningBalanceFinancialForecast($transactionDate); ?>
                                    <?php //echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saldo)); ?>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <tr>
                            <td style="text-align: center; font-weight: bold; border-bottom: 1px solid">Transaksi #</td>
                            <td style="text-align: center; font-weight: bold; border-bottom: 1px solid">Tanggal Estimasi</td>
                            <td style="text-align: center; font-weight: bold; border-bottom: 1px solid">Debit</td>
                            <td style="text-align: center; font-weight: bold; border-bottom: 1px solid">Kredit</td>
                            <td style="text-align: center; font-weight: bold; border-bottom: 1px solid">Saldo</td>
                        </tr>

                        <?php $forecastData = $coa->getFinancialForecastDetails($transactionDate); ?>
                        <?php $sumDebit = '0.00'; ?> 
                        <?php $sumCredit = '0.00'; ?>
                        <?php foreach ($forecastData as $forecastRow): ?>
                            <?php $debitAmount = $forecastRow['journal_debit']; ?>
                            <?php $creditAmount = $forecastRow['journal_credit']; ?>
                            <?php //$saldo += $debitAmount - $creditAmount; ?>
                            <tr>
                                <td>
                                    <?php $transactionNumber = $forecastRow['transaction_number']; ?>
                                    <?php echo CHtml::link($transactionNumber, array('javascript:;'), array(
                                        'onclick' => 'window.open("' . CController::createUrl('/report/financialForecast/redirectTransaction', array(
                                            "codeNumber" => $transactionNumber
                                        )) . '", "_blank", "top=100, left=225, width=900, height=650"); return false;'
                                    )); ?> 
                                </td>
                                <td style="text-align: center">
                                    <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($forecastRow['transaction_date']))); ?>
                                </td>
                                <td style="text-align: right"><?php echo Yii::app()->numberFormatter->format('#,##0', $debitAmount); ?></td>
                                <td style="text-align: right"><?php echo Yii::app()->numberFormatter->format('#,##0', $creditAmount); ?></td>
                                <td style="text-align: right"><?php //echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saldo)); ?></td>
                            </tr>
                            <?php $sumDebit += $debitAmount; ?>
                            <?php $sumCredit += $creditAmount; ?>
                        <?php endforeach; ?>
                            <tr>
                                <td style="text-align: right" colspan="2">Total</td>
                                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $sumDebit)); ?></td>
                                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $sumCredit)); ?></td>
                                <td></td>
                            </tr>
                    </table>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>