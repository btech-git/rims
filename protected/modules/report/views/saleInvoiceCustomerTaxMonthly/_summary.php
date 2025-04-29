<?php Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 25% }
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

<fieldset>
    <legend>Penjualan Total</legend>
    <table class="report">
        <thead style="position: sticky; top: 0">
            <tr id="header1">
                <th class="width1-1">Customer</th>
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
            <?php foreach ($monthlySaleSummary as $monthlySaleSummaryItem): ?>
                <?php $subTotal = $monthlySaleSummaryItem['sub_total']; ?>
                <?php $totalTax = $monthlySaleSummaryItem['total_tax']; ?>
                <?php $totalTaxIncome = $monthlySaleSummaryItem['total_tax_income']; ?>
                <?php $totalPrice = $monthlySaleSummaryItem['total_price']; ?>
                <tr class="items1">
                    <td style="text-align: left"><?php echo CHtml::encode($monthlySaleSummaryItem['customer_name']); ?></td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $monthlySaleSummaryItem['quantity_invoice'])); ?>
                    </td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $monthlySaleSummaryItem['product_price'])); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $monthlySaleSummaryItem['service_price'])); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $subTotal)); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalTax)); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalTaxIncome)); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPrice)); ?>
                    </td>
                </tr>
                <?php $sumSubTotal += $subTotal; ?>
                <?php $sumTotalTax += $totalTax; ?>
                <?php $sumTotalTaxIncome += $totalTaxIncome; ?>
                <?php $sumGrandTotal += $totalPrice; ?>
            <?php endforeach; ?>
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
</fieldset>