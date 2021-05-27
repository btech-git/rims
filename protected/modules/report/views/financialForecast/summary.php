<?php
//Yii::app()->clientScript->registerScript('report', '
//	$("#EndDate").val("' . $endDate . '");
//');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');
?>

<div class="clear"></div>

<div class="tab reportTab">
    <div class="tabHead"></div>
    
    <div class="tabBody">
        <div id="detail_div">
            <div>
                <div class="myForm">
                    <?php echo CHtml::beginForm(array(''), 'get'); ?>
                    
                    <div class="row">
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Company</span>
                                    </div>
                                    
                                    <div class="small-8 columns">
                                        <?php echo CHtml::dropDownlist('CompanyId', $companyId, CHtml::listData(Company::model()->findAllbyAttributes(array('is_deleted' => 0)), 'id', 'name'), array('empty' => '-- Pilih Company --')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Periode:</span>
                                    </div>
                                    
                                    <div class="small-8 columns" id="company_bank">
                                        <?php echo CHtml::dropDownlist('NumberOfPeriod', $numberOfPeriod, array('1' => '1 Bulan', '3' => '3 Bulan', '6' => '6 Bulan')); ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="clear"></div>
                    <div class="row buttons">
                        <?php echo CHtml::submitButton('Tampilkan', array('onclick' => '$("#CurrentSort").val(""); return true;')); ?>
                        <?php echo CHtml::submitButton('Hapus', array('onclick' => 'resetForm($("#myform"));')); ?>
                        <?php //echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel')); ?>
                    </div>

                    <?php echo CHtml::endForm(); ?>
                    <div class="clear"></div>

                </div>

                <hr />

                <div class="relative">
                    <div style="font-weight: bold; text-align: center">
                        <?php //$branch = Branch::model()->findByPk($branchId); ?>
                        <div style="font-size: larger"><?php //echo CHtml::encode(($branch === null) ? '' : $branch->name); ?></div>
                        <div style="font-size: larger">Financial Forecast</div>
                        <div>
                            <?php $endDate = date('Y-m-d'); ?>
                            <?php echo ' Tanggal: &nbsp;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?>
                        </div>
                    </div>

                    <br />

                    <?php //if (!empty($coaId)): ?>
                    <table style="width: 80%; margin: 0 auto; border-spacing: 0pt">
                        <?php foreach ($companyBanks as $companyBank): ?>
                            <tr>
                                <?php $coa = Coa::model()->findByPk($companyBank->coa_id); ?>
                                <td style="font-size: larger; font-weight: bold; text-transform: uppercase">
                                    Bank:
                                </td>

                                <td style="font-size: larger; font-weight: bold; text-transform: uppercase">
                                    <?php echo CHtml::encode(CHtml::value($coa, 'code')); ?>
                                </td>

                                <td style="font-size: larger; font-weight: bold; text-transform: uppercase" colspan="3"> 
                                    <?php echo CHtml::encode(CHtml::value($coa, 'name')); ?>
                                </td>
                            </tr>

                            <tr>
                                <td style="text-align: right; font-weight: bold; text-transform: uppercase" colspan="3">
                                    Saldo Awal 
                                </td>

                                <td style="text-align: right; font-weight: bold">
                                    <?php if (empty($coa)): ?>
                                        <?php echo '0' ;?>
                                    <?php else: ?>
                                        <?php $saldo = $coa->getBalanceTotal($datePrevious, $endDate, null); ?>
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saldo)); ?>
                                    <?php endif; ?>
                                </td>
                            </tr>

                            <tr>
                                <td style="text-align: center; font-weight: bold; border-bottom: 1px solid">Tanggal Estimasi</td>
                                <td style="text-align: center; font-weight: bold; border-bottom: 1px solid">Debit</td>
                                <td style="text-align: center; font-weight: bold; border-bottom: 1px solid">Kredit</td>
                                <td style="text-align: center; font-weight: bold; border-bottom: 1px solid">Saldo</td>
                            </tr>

                            <?php $forecastData = $coa->getFinancialForecastReport($datePrevious); ?>
                            <?php foreach ($forecastData as $forecastRow): ?>
                                <?php $debitAmount = $forecastRow['total_debit']; ?>
                                <?php $creditAmount = $forecastRow['total_credit']; ?>
                                <?php $saldo += $debitAmount - $creditAmount; ?>
                                <tr>
                                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($forecastRow['payment_date_estimate']))); ?></td>
                                    <td style="text-align: right"><?php echo Yii::app()->numberFormatter->format('#,##0', $debitAmount); ?></td>
                                    <td style="text-align: right"><?php echo Yii::app()->numberFormatter->format('#,##0', $creditAmount); ?></td>
                                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saldo)); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </table>
                    <?php //endif; ?>
                </div>
                <div class="clear"></div>
            </div>
            
            <br/>

            <div class="row">
                <p><h2>Hutang Supplier</h2></p>
                <table>
                    <thead>
                        <tr>
                            <th>Supplier</th>
                            <th>Amount</th>
                            <th>Jatuh Tempo</th>
                            <th>Hari</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php foreach ($payableTransactionDataProvider->data as $payableTransaction): ?>
                        <tr>
                            <td><?php echo CHtml::encode(CHtml::value($payableTransaction, 'supplier.name')); ?></td>
                            <td style="text-align: right"><?php echo number_format(CHtml::encode(CHtml::value($payableTransaction, 'payment_left')), 0); ?></td>
                            <td>
                                <?php echo CHtml::link(Yii::app()->dateFormatter->format("d MMM yyyy", CHtml::value($payableTransaction, 'estimate_payment_date')), array('javascript:;'), array(
                                    'onclick' => 'window.open("' . CController::createUrl('/accounting/financialForecast/updateDueDate', array('id' => $payableTransaction->id)) . '", "_blank", "top=100, left=425, width=500, height=500"); return false;'
                                )); ?>
                            </td>
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
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Jatuh Tempo</th>
                            <th>Hari</th>
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
        </div>
    </div>
</div>