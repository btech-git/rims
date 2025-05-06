<?php Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 5% }
    .width1-2 { width: 5% }
    .width1-3 { width: 5% }
    .width1-4 { width: 5% }
    .width1-5 { width: 10% }
    .width1-6 { width: 10% }
    .width1-7 { width: 10% }
    .width1-8 { width: 10% }
    .width1-9 { width: 10% }
    .width1-10 { width: 10% }

'); ?>

<div style="font-weight: bold; text-align: center">
    <?php $branch = Branch::model()->findByPk($branchId); ?>
    <div style="font-size: larger">Laporan Penjualan Ppn  Recap Tahun</div>
    <div><?php echo CHtml::encode($year); ?> - <?php echo empty($branchId) ? 'All' : CHtml::encode(CHtml::value($branch, 'name')); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">Bulan</th>
            <th class="width1-2"># INV</th>
            <th class="width1-3"># FP</th>
            <th class="width1-4"># Bupot</th>
            <th class="width1-5">Parts (Rp)</th>
            <th class="width1-6">Jasa (Rp)</th>
            <th class="width1-7">Total DPP</th>
            <th class="width1-8">Total PPn</th>
            <th class="width1-9">Total PPh</th>
            <th class="width1-10">Total Invoice</th>
        </tr>
    </thead>
    <tbody>
        <?php $sumSubTotal = '0.00'; ?>
        <?php $sumTotalTax = '0.00'; ?>
        <?php $sumTotalTaxIncome = '0.00'; ?>
        <?php $sumGrandTotal = '0.00'; ?>
        <?php for ($month = 1; $month <= 12; $month++): ?>
            <?php $quantityInvoice = isset($yearlySaleQuantityInvoiceData[$month]) ? $yearlySaleQuantityInvoiceData[$month] : '0.00'; ?>
            <?php $totalParts = isset($yearlySalePartsPriceData[$month]) ? $yearlySalePartsPriceData[$month] : '0.00'; ?>
            <?php $totalService = isset($yearlySaleServicePriceData[$month]) ? $yearlySaleServicePriceData[$month] : '0.00'; ?>
            <?php $subTotal = isset($yearlySaleSubTotalData[$month]) ? $yearlySaleSubTotalData[$month] : '0.00'; ?>
            <?php $totalTax = isset($yearlySaleTotalTaxData[$month]) ? $yearlySaleTotalTaxData[$month] : '0.00'; ?>
            <?php $totalTaxIncome = isset($yearlySaleTotalTaxIncomeData[$month]) ? $yearlySaleTotalTaxIncomeData[$month] : '0.00'; ?>
            <?php $totalPrice = isset($yearlySaleTotalPriceData[$month]) ? $yearlySaleTotalPriceData[$month] : '0.00'; ?>
            <tr class="items1">
                <td style="text-align: left"><?php echo CHtml::encode($monthList[$month]); ?></td>
                <td style="text-align: right">
                    <?php echo CHtml::link(Yii::app()->numberFormatter->format('#,##0', $quantityInvoice), array("detail", "month" => $month, "year" => $year, "branchId" => $branchId), array("target" => "_blank")); ?>
                </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalParts)); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalService)); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $subTotal)); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalTax)); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalTaxIncome)); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPrice)); ?></td>
            </tr>
            <?php $sumSubTotal += $subTotal; ?>
            <?php $sumTotalTax += $totalTax; ?>
            <?php $sumTotalTaxIncome += $totalTaxIncome; ?>
            <?php $sumGrandTotal += $totalPrice; ?>
        <?php endfor; ?>
    </tbody>
    <tfoot>
        <tr>
            <td style="text-align: right" colspan="6">TOTAL</td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $sumSubTotal)); ?></td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $sumTotalTax)); ?></td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $sumTotalTaxIncome)); ?></td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $sumGrandTotal)); ?></td>
        </tr>
    </tfoot>
</table>