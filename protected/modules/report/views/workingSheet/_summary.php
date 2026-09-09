<?php $dateNumList = range(1, 31); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Raperind Motor</div>
    <div style="font-size: larger">Kertas Kerja</div>
    <div><?php echo 'Periode tahun: ' . CHtml::encode($year); ?></div>
</div>

<br />
    
<div class="table_wrapper">
    <table class="responsive">
        <thead>
            <tr>
                <th style="width: 10px">Kode</th>
                <th style="width: 300px">Nama Akun</th>
                <th style="width: 150px">Tipe</th>
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
            <?php foreach ($coas as $coa): ?>
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
                        <td><?php echo CHtml::encode(CHtml::value($coa, 'normal_balance')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($coa, 'coaSubCategory.cashflow_position')); ?></td>
                        <td style="text-align: right; <?php echo $beginningBalance < '0.00' ? 'color: red' : ''; ?>"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $beginningBalance)); ?></td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $positiveDebitTotal)); ?></td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $positiveCreditTotal)); ?></td>
                        <td style="text-align: right; <?php echo $endingBalance < '0.00' ? 'color: red' : ''; ?>"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $endingBalance)); ?></td>
                        <td style="text-align: right; <?php echo $balanceDifference < '0.00' ? 'color: red' : ''; ?>"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $balanceDifference)); ?></td>
                        <td style="text-align: right; <?php echo $profitLossBalance < '0.00' ? 'color: red' : ''; ?>"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $profitLossBalance)); ?></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>