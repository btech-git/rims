<?php $dateNumList = range(1, 31); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Raperind Motor</div>
    <div style="font-size: larger">Kertas Kerja</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
    <!--<div><?php //echo 'Periode tahun: ' . CHtml::encode($year); ?></div>-->
</div>

<br />
    
<div class="tab reportTab">
    <div class="tabBody">    
        <table class="report">
            <thead style="position: sticky; top: 0">
                <tr>
                    <th>Kode</th>
                    <th>Nama Akun</th>
                    <th>Category</th>
                    <th>Sub Category</th>
                    <th>Normal Balance</th>
                    <th>Pos Arus Kas</th>
                    <th>Saldo Awal</th>
                    <th>Debit</th>
                    <th>Kredit</th>
                    <th>Saldo Akhir</th>
                    <th>Pengaruh Kas</th>
                    <th>Kontribusi Laba</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($coas as $i => $coa): ?>
                    <?php $beginningBalance = '0.00'; ?>
                    <?php if ($coa->coaSubCategory->cashflow_position !== 'Laba Bersih'): ?>
                        <?php $beginningBalance = isset($workingSheetReportData[$coa->id]['beginning_balance']) ? $workingSheetReportData[$coa->id]['beginning_balance'] : '0.00'; ?>
                    <?php endif; ?>
                    <?php $debitTotal = isset($workingSheetReportData[$coa->id]['debit_total']) ? $workingSheetReportData[$coa->id]['debit_total'] : '0.00'; ?>
                    <?php $positiveDebitTotal = abs($debitTotal); ?>
                    <?php $creditTotal = isset($workingSheetReportData[$coa->id]['credit_total']) ? $workingSheetReportData[$coa->id]['credit_total'] : '0.00'; ?>
                    <?php $positiveCreditTotal = abs($creditTotal); ?>
                    <?php $endingBalance = $beginningBalance + $debitTotal + $creditTotal; ?>
                    <?php $balanceDifference = '0.00'; ?>
                    <?php if ($coa->coaSubCategory->cashflow_position !== 'Laba Bersih'): ?>
                        <?php $balanceDifference = $endingBalance - $beginningBalance; ?>
                    <?php endif; ?>
                    <?php $profitLossBalance = '0.00'; ?>
                    <?php if ($coa->coaSubCategory->cashflow_position === 'Laba Bersih'): ?>
                        <?php $profitLossBalance = $positiveCreditTotal - $positiveDebitTotal; ?>
                    <?php endif; ?>
                    <?php if ($beginningBalance != '0.00' || $debitTotal != '0.00' || $creditTotal != '0.00'): ?>
                        <tr>
                            <td><?php echo CHtml::encode(CHtml::value($coa, 'code')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($coa, 'name')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($coa, 'coaCategory.name')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($coa, 'coaSubCategory.name')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($coa, 'normal_balance')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($coa, 'coaSubCategory.cashflow_position')); ?></td>
                            <td style="text-align: right; <?php echo $beginningBalance < '0.00' ? 'color: red' : ''; ?>">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $beginningBalance)); ?>
                            </td>
                            <td style="text-align: right">
                                <?php echo CHtml::link(Yii::app()->numberFormatter->format('#,##0.00', $positiveDebitTotal), Yii::app()->createUrl("report/workingSheet/jurnalTransaction", array(
                                    "CoaCode" => $coa->code, 
                                    "StartDate" => $startDate, 
                                    "EndDate" => $endDate, 
                                )), array('target' => '_blank', 'style' => $positiveDebitTotal < '0.00' ? 'color:red' : 'color:blue')); ?>
                            </td>
                            <td style="text-align: right">
                                <?php echo CHtml::link(Yii::app()->numberFormatter->format('#,##0.00', $positiveCreditTotal), Yii::app()->createUrl("report/workingSheet/jurnalTransaction", array(
                                    "CoaCode" => $coa->code, 
                                    "StartDate" => $startDate, 
                                    "EndDate" => $endDate, 
                                )), array('target' => '_blank', 'style' => $positiveCreditTotal < '0.00' ? 'color:red' : 'color:blue')); ?>
                            </td>
                            <td style="text-align: right; <?php echo $endingBalance < '0.00' ? 'color: red' : ''; ?>">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $endingBalance)); ?>
                            </td>
                            <td style="text-align: right; <?php echo $balanceDifference < '0.00' ? 'color: red' : ''; ?>">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $balanceDifference)); ?>
                            </td>
                            <td style="text-align: right; <?php echo $profitLossBalance < '0.00' ? 'color: red' : ''; ?>">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $profitLossBalance)); ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>