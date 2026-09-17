<?php $dateNumList = range(1, 31); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Raperind Motor</div>
    <div style="font-size: larger">Cash Flow</div>
    <div><?php echo 'Periode tahun: ' . CHtml::encode($year); ?></div>
</div>

<br />
    
<div class="table_wrapper">
    <table class="responsive">
        <tbody>
            <?php $operationalSum = $cashFlowReportData['Laba Bersih'] + $cashFlowReportData['Operasional']; ?>
            <tr>
                <td colspan="2" style="font-weight: bold">AKTIVITAS OPERASIONAL</td>
            </tr>
            <tr>
                <td>Laba Bersih</td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $cashFlowReportData['Laba Bersih'])); ?></td>
            </tr>
            <tr>
                <td>Penyesuaian non-kas & perubahan modal kerja</td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $cashFlowReportData['Operasional'])); ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold">Kas Bersih dari aktivitas Operasional</td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $operationalSum)); ?></td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            
            <?php $investmentSum = $cashFlowReportData['Investasi']; ?>
            <tr>
                <td colspan="2" style="font-weight: bold">AKTIVITAS INVESTASI</td>
            </tr>
            <tr>
                <td>Perolehan Aset Tetap (capex)</td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $cashFlowReportData['Investasi'])); ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold">Kas Bersih dari aktivitas Investasi</td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $investmentSum)); ?></td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            
            <?php $financingSum = $cashFlowReportData['Pendanaan'] + $cashFlowReportData['Saldo Laba']; ?>
            <tr>
                <td colspan="2" style="font-weight: bold">AKTIVITAS PENDANAAN</td>
            </tr>
            <tr>
                <td>Perubahan Pinjaman KMK & pemegang saham</td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $cashFlowReportData['Pendanaan'])); ?></td>
            </tr>
            <tr>
                <td>Dividen dibayar</td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $cashFlowReportData['Saldo Laba'])); ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold">Kas Bersih dari aktivitas Pendanaan</td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $financingSum)); ?></td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            
            <?php $netCashSum = $operationalSum + $investmentSum + $financingSum; ?>
            <?php $endCashAmount = $netCashSum - $cashFlowReportData['Kas']['beginning_balance']; ?>
            <?php $cashAmountDifference = $endCashAmount - $cashFlowReportData['Kas']['ending_balance']; ?>
            <tr>
                <td style="font-weight: bold">KENAIKAN (PENURUNAN) KAS BERSIH</td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $netCashSum)); ?></td>
            </tr>
            <tr>
                <td>Kas & setara kas awal tahun</td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $cashFlowReportData['Kas']['beginning_balance'])); ?></td>
            </tr>
            <tr>
                <td>Kas & setara kas akhir (perhitungan)</td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $endCashAmount)); ?></td>
            </tr>
            <tr>
                <td>Kas & setara kas menurut Neraca</td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $cashFlowReportData['Kas']['ending_balance'])); ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold">CEK SILANG</td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $cashAmountDifference)); ?></td>
            </tr>
        </tbody>
    </table>
</div>