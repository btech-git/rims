<?php
//Yii::app()->clientScript->registerScript('report', '
//	$("#EndDate").val("' . $dateNow . '");
//');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');
?>

<div class="clear"></div>

<div class="tab reportTab">
    <div class="tabHead"></div>
    
    <div class="tabBody">
        <div id="detail_div">
                <div class="myForm">
                    <?php echo CHtml::beginForm(array(''), 'get'); ?>
                    
<!--                    <div class="row">
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Company</span>
                                    </div>
                                    
                                    <div class="small-8 columns">
                                        <?php //echo CHtml::dropDownlist('CompanyId', $companyId, CHtml::listData(Company::model()->findAllbyAttributes(array('is_deleted' => 0)), 'id', 'name'), array('empty' => '-- Pilih Company --')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>-->
                    
                    <div class="row">
                        <div class="medium-12 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-2 columns">
                                        <span class="prefix">Periode:</span>
                                    </div>
                                    
                                    <div class="small-2 columns">
                                        <?php echo CHtml::dropDownList('MonthStart', $monthStart, array(
                                            '01' => 'Jan',
                                            '02' => 'Feb',
                                            '03' => 'Mar',
                                            '04' => 'Apr',
                                            '05' => 'May',
                                            '06' => 'Jun',
                                            '07' => 'Jul',
                                            '08' => 'Aug',
                                            '09' => 'Sep',
                                            '10' => 'Oct',
                                            '11' => 'Nov',
                                            '12' => 'Dec',
                                        )); ?>
                                    </div>

                                    <div class="small-2 columns">
                                        <?php echo CHtml::dropDownList('YearStart', $yearStart, $yearList); ?>
                                    </div>

                                    <div class="small-2 columns">
                                        <span class="prefix">Sampai</span>
                                    </div>

                                    <div class="small-2 columns">
                                        <?php echo CHtml::dropDownList('MonthEnd', $monthEnd, array(
                                            '01' => 'Jan',
                                            '02' => 'Feb',
                                            '03' => 'Mar',
                                            '04' => 'Apr',
                                            '05' => 'May',
                                            '06' => 'Jun',
                                            '07' => 'Jul',
                                            '08' => 'Aug',
                                            '09' => 'Sep',
                                            '10' => 'Oct',
                                            '11' => 'Nov',
                                            '12' => 'Dec',
                                        )); ?>
                                    </div>

                                    <div class="small-2 columns">
                                        <?php echo CHtml::dropDownList('YearEnd', $yearEnd, $yearList); ?>
                                    </div>
<!--                                    <div class="small-8 columns" id="company_bank">
                                        <?php //echo CHtml::dropDownlist('NumberOfPeriod', $numberOfPeriod, array('1' => '1 Bulan', '3' => '3 Bulan', '6' => '6 Bulan')); ?>
                                    </div>-->
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="clear"></div>
                    <div class="row buttons" style="text-align: center">
                        <?php echo CHtml::submitButton('Tampilkan', array('onclick' => '$("#CurrentSort").val(""); return true;')); ?>
                        <?php //echo CHtml::submitButton('Hapus', array('onclick' => 'resetForm($("#myform"));')); ?>
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
                            <?php //$dateNow = date('Y-m-d'); ?>
                            <?php echo ' Tanggal: &nbsp;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($dateNow))); ?>
                        </div>
                    </div>

                    <br />

                    <?php //if (!empty($coaId)): ?>
                    <?php $coas = array(); ?>
                    <?php foreach ($companyBanks as $companyBank): ?>
                        <?php $coas[] = Coa::model()->findByPk($companyBank->coa_id); ?>
                    <?php endforeach; ?>
                    <?php $coaIds = array(); ?>
                    <?php foreach ($coas as $coa): ?>
                        <?php $coaIds[] = $coa->id; ?>
                    <?php endforeach; ?>
                    <?php $forecastApprovalCriteria = new CDbCriteria(); ?>
                    <?php $forecastApprovalCriteria->addBetweenCondition('date_transaction', $datePrevious, $dateNow); ?>
                    <?php $forecastApprovalCriteria->addInCondition('coa_id', $coaIds); ?>
                    <?php $forecastApprovalList = FinancialForecastApproval::model()->findAll($forecastApprovalCriteria); ?>
                    <?php $forecastApprovalReference = array(); ?>
                    <?php foreach ($forecastApprovalList as $forecastApprovalItem): ?>
                        <?php $forecastApprovalReference[$forecastApprovalItem->coa_id][$forecastApprovalItem->date_transaction] = true; ?>
                    <?php endforeach; ?>
                    <table id="forecast-data" style="width: 80%; margin: 0 auto; border-spacing: 0pt">
                        <?php foreach ($coas as $coa): ?>
                            <tr class="forecast-header" style="background-color: gray">
                                <td style="font-size: larger; font-weight: bold; text-transform: uppercase">
                                    Bank:
                                </td>

                                <td style="font-size: larger; font-weight: bold; text-transform: uppercase">
                                    <?php echo CHtml::encode(CHtml::value($coa, 'code')); ?>
                                </td>

                                <td style="font-size: larger; font-weight: bold; text-transform: uppercase"> 
                                    <?php echo CHtml::encode(CHtml::value($coa, 'name')); ?>
                                </td>
                            </tr>
                            <tr class="forecast-body">
                                <td colspan="3">
                                    <table>
                                        <tr>
                                            <td style="text-align: right; font-weight: bold; text-transform: uppercase" colspan="5">
                                                Saldo Awal 
                                            </td>

                                            <td style="text-align: right; font-weight: bold">
                                                <?php if (empty($coa)): ?>
                                                    <?php echo '0' ;?>
                                                <?php else: ?>
                                                    <?php $saldo = $coa->getBalanceTotal($datePrevious, $dateNow, null); ?>
                                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saldo)); ?>
                                                <?php endif; ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td style="text-align: center; font-weight: bold; border-bottom: 1px solid">Tanggal</td>
                                            <td style="text-align: center; font-weight: bold; border-bottom: 1px solid">Debit Rcvb</td>
                                            <td style="text-align: center; font-weight: bold; border-bottom: 1px solid">Debit All</td>
                                            <td style="text-align: center; font-weight: bold; border-bottom: 1px solid">Kredit Pay</td>
                                            <td style="text-align: center; font-weight: bold; border-bottom: 1px solid">Kredit All</td>
                                            <td style="text-align: center; font-weight: bold; border-bottom: 1px solid">Saldo</td>
                                            <td style="text-align: center; font-weight: bold; border-bottom: 1px solid">Approval</td>
                                        </tr>

                                        <?php $forecastData = $coa->getFinancialForecastReport($datePrevious, $dateNow); ?>
                                        <?php foreach ($forecastData as $forecastRow): ?>
                                            <?php $debitReceivableAmount = $forecastRow['total_receivable_debit']; ?>
                                            <?php $debitJournalAmount = $forecastRow['total_journal_debit']; ?>
                                            <?php $creditPayableAmount = $forecastRow['total_payable_credit']; ?>
                                            <?php $creditJournalAmount = $forecastRow['total_journal_credit']; ?>
                                            <?php $saldo += $debitReceivableAmount + $debitJournalAmount - $creditPayableAmount - $creditJournalAmount; ?>
                                            <tr>
                                                <td style="text-align: right">
                                                    <?php echo CHtml::link(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($forecastRow['transaction_date'])), array('javascript:;'), array(
                                                        'onclick' => 'window.open("' . CController::createUrl('/report/financialForecast/transaction', array(
                                                            "transactionDate" => $forecastRow['transaction_date'], 
                                                            "coaId" => $coa->id, 
                                                        )) . '", "_blank", "top=100, left=225, width=900, height=650"); return false;'
                                                    )); ?>
                                                </td>
                                                <td style="text-align: right"><?php echo Yii::app()->numberFormatter->format('#,##0', $debitReceivableAmount); ?></td>
                                                <td style="text-align: right"><?php echo Yii::app()->numberFormatter->format('#,##0', $debitJournalAmount); ?></td>
                                                <td style="text-align: right"><?php echo Yii::app()->numberFormatter->format('#,##0', $creditPayableAmount); ?></td>
                                                <td style="text-align: right"><?php echo Yii::app()->numberFormatter->format('#,##0', $creditJournalAmount); ?></td>
                                                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saldo)); ?></td>
                                                <td style="text-align: center">
                                                    <?php if (!isset($forecastApprovalReference[$coa->id][$forecastRow['transaction_date']])): ?>
                                                        <?php echo CHtml::button('Approve', array(
                                                            'onclick' => '
                                                                $("#ForecastApprovalCoaId").val("'.$coa->id.'");
                                                                $("#ForecastApprovalTransactionDate").val("'.$forecastRow['transaction_date'].'");
                                                                $("#ForecastApprovalDebitReceivableAmount").val("'.$debitReceivableAmount.'");
                                                                $("#ForecastApprovalDebitJournalAmount").val("'.$debitJournalAmount.'");
                                                                $("#ForecastApprovalCreditPayableAmount").val("'.$creditPayableAmount.'");
                                                                $("#ForecastApprovalCreditJournalAmount").val("'.$creditJournalAmount.'");
                                                                $("#ForecastApprovalSaldo").val("'.$saldo.'");
                                                                $("#forecast-approval-dialog").dialog("open");
                                                            ',
                                                            'style' => 'background-color: green; color:white',
                                                        )); ?>
                                                    <?php else: ?>
                                                        <?php echo CHtml::button('View', array(
                                                            'onclick' => '
                                                                $("#ForecastApprovalCoaId").val("'.$coa->id.'");
                                                                $("#ForecastApprovalTransactionDate").val("'.$forecastRow['transaction_date'].'");
                                                                $("#ForecastApprovalDebitReceivableAmount").val("'.$debitReceivableAmount.'");
                                                                $("#ForecastApprovalDebitJournalAmount").val("'.$debitJournalAmount.'");
                                                                $("#ForecastApprovalCreditPayableAmount").val("'.$creditPayableAmount.'");
                                                                $("#ForecastApprovalCreditJournalAmount").val("'.$creditJournalAmount.'");
                                                                $("#ForecastApprovalSaldo").val("'.$saldo.'");
                                                                $("#forecast-view-dialog").dialog("open");
                                                            ',
                                                            'style' => 'background-color: blue; color:white',
                                                        )); ?>

                                                        <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                                                            'id' => 'forecast-view-dialog',
                                                            // additional javascript options for the dialog plugin
                                                            'options' => array(
                                                                'title' => 'Forecast Summary',
                                                                'autoOpen' => false,
                                                                'width' => 'auto',
                                                                'modal' => true,
                                                            ),
                                                        )); ?>

                                                        <div>
                                                            <table>
                                                                <thead>
                                                                    <tr>
                                                                        <th>Tanggal</th>
                                                                        <th>A/R</th>
                                                                        <th>Debit</th>
                                                                        <th>A/P</th>
                                                                        <th>Kredit</th>
                                                                        <th>Saldo</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <?php $forecastApproval = FinancialForecastApproval::model()->findByAttributes(array('coa_id' => $coa->id, 'date_transaction' => $forecastRow['transaction_date'])); ?>
                                                                        <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime(CHtml::value($forecastApproval, 'date_transaction')))); ?></td>
                                                                        <td><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($forecastApproval, 'debit_receivable'))); ?></td>
                                                                        <td><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($forecastApproval, 'debit_journal'))); ?></td>
                                                                        <td><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($forecastApproval, 'credit_payable'))); ?></td>
                                                                        <td><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($forecastApproval, 'credit_journal'))); ?></td>
                                                                        <td><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($forecastApproval, 'total_amount'))); ?></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                            <hr />

                                                            <div>
                                                                <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/' . CHtml::encode(CHtml::value($forecastApproval, 'id')), CHtml::encode(CHtml::value($forecastApproval, 'id'))); ?>
                                                            </div>
                                                        </div>

                                                        <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </table>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                    <?php //endif; ?>
                </div>
                <div class="clear"></div>
            
            <br/>

            <fieldset>
                <legend>Information</legend>
                <div class="row" style="height: 500px">
                    <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                        'tabs' => array(
                            'Hutang Supplier' => array(
                                'id' => 'info1',
                                'content' => $this->renderPartial('_viewPayable', array(
                                    'payableTransaction' => $payableTransaction,
                                    'payableTransactionDataProvider' => $payableTransactionDataProvider,
                                ), true)
                            ),
                            'Piutang Customer' => array(
                                'id' => 'info2',
                                'content' => $this->renderPartial('_viewReceivable', array(
                                    'receivableTransaction' => $receivableTransaction,
                                    'receivableTransactionDataProvider' => $receivableTransactionDataProvider,
                                ), true)
                            ),
                        ),
                        // additional javascript options for the tabs plugin
                        'options' => array(
                            'collapsible' => true,
                        ),
                        // set id for this widgets
                        'id' => 'view_tab',
                    )); ?>  
                </div>
            </fieldset>
        </div>
    </div>
</div>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'forecast-approval-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Forecast Approval',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => true,
    ),
)); ?>

<?php echo CHtml::beginForm('', 'post', array('enctype' => 'multipart/form-data')); ?>
<div>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>A/R</th>
                <th>Debit</th>
                <th>A/P</th>
                <th>Kredit</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <?php echo CHtml::hiddenField('ForecastApprovalCoaId', ''); ?>
                    <?php echo CHtml::textField('ForecastApprovalTransactionDate', '', array('readOnly' => true)); ?>
                </td>
                <td><?php echo CHtml::textField('ForecastApprovalDebitReceivableAmount', '', array('readOnly' => true)); ?></td>
                <td><?php echo CHtml::textField('ForecastApprovalDebitJournalAmount', '', array('readOnly' => true)); ?></td>
                <td><?php echo CHtml::textField('ForecastApprovalCreditPayableAmount', '', array('readOnly' => true)); ?></td>
                <td><?php echo CHtml::textField('ForecastApprovalCreditJournalAmount', '', array('readOnly' => true)); ?></td>
                <td><?php echo CHtml::textField('ForecastApprovalSaldo', '', array('readOnly' => true)); ?></td>
            </tr>
        </tbody>
    </table>
    
    <hr />
    
    <?php echo CHtml::fileField('ForecastApprovalUploadImage'); ?>
    <?php echo CHtml::submitButton('Approve', array('name' => 'Approve', 'confirm' => 'Are you sure you want to Approve?')); ?>
</div>
<?php echo CHtml::endForm(); ?>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<script>
    $(".forecast-header").click(function() {
        $(this).next(".forecast-body").toggle();
    });
</script>