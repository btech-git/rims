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
                                <?php $saldo = $coa->getBeginningBalanceFinancialForecast($transactionDate); ?>
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saldo)); ?>
                            </td>
                        </tr>

                        <tr>
                            <td style="text-align: center; font-weight: bold; border-bottom: 1px solid">Tanggal</td>
                            <td style="text-align: center; font-weight: bold; border-bottom: 1px solid">Debit Rcvb</td>
                            <td style="text-align: center; font-weight: bold; border-bottom: 1px solid">Debit All</td>
                            <td style="text-align: center; font-weight: bold; border-bottom: 1px solid">Kredit Pay</td>
                            <td style="text-align: center; font-weight: bold; border-bottom: 1px solid">Kredit All</td>
                            <td style="text-align: center; font-weight: bold; border-bottom: 1px solid">Saldo</td>
                        </tr>

                        <?php $forecastData = $coa->getFinancialForecastApproval($transactionDate, $coa->id); ?>
                        <?php $debitReceivableAmount = $forecastData['total_receivable_debit']; ?>
                        <?php $debitJournalAmount = $forecastData['total_journal_debit']; ?>
                        <?php $creditPayableAmount = $forecastData['total_payable_credit']; ?>
                        <?php $creditJournalAmount = $forecastData['total_journal_credit']; ?>
                        <?php $saldo += $debitReceivableAmount + $debitJournalAmount - $creditPayableAmount - $creditJournalAmount; ?>
                        <tr>
                            <td style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($forecastData['transaction_date']))); ?>
                            </td>
                            <td style="text-align: right"><?php echo Yii::app()->numberFormatter->format('#,##0', $debitReceivableAmount); ?></td>
                            <td style="text-align: right"><?php echo Yii::app()->numberFormatter->format('#,##0', $debitJournalAmount); ?></td>
                            <td style="text-align: right"><?php echo Yii::app()->numberFormatter->format('#,##0', $creditPayableAmount); ?></td>
                            <td style="text-align: right"><?php echo Yii::app()->numberFormatter->format('#,##0', $creditJournalAmount); ?></td>
                            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saldo)); ?></td>
                        </tr>
                    </table>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>