<?php Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 10% }
    .width1-3 { width: 10% }

'); ?>

<fieldset>
    <legend>Penjualan Total Kendaraan</legend>
    <table class="report">
        <thead style="position: sticky; top: 0">
            <tr id="header1">
                <th class="width1-1">Bulan</th>
                <?php foreach ($branches as $branch): ?>
                    <th class="width1-2"><?php echo CHtml::encode(CHtml::value($branch, 'code')); ?></th>
                <?php endforeach; ?>
                <th class="width1-3">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $quantityTotals = array(); ?>
            <?php for ($month = 1; $month <= 12; $month++): ?>
                    <tr class="items1">
                        <td style="text-align: left"><?php echo CHtml::encode($monthList[$month]); ?></td>
                        <?php $quantitySum = '0.00'; ?>
                        <?php foreach ($branches as $branch): ?>
                            <?php $quantity = isset($yearlyVehicleSaleSummaryData[$month][$branch->id]) ? $yearlyVehicleSaleSummaryData[$month][$branch->id] : '0.00'; ?>
                            <td style="text-align: right">
                                <?php echo CHtml::link(Yii::app()->numberFormatter->format('#,##0', $quantity), array(
                                    'transactionVehicleInfo', 
                                    'year' => $year, 
                                    'month' => $month, 
                                    'branchId' => $branch->id,
                                ), array('target' => '_blank')); ?>
                            </td>
                            <?php $quantitySum += $quantity; ?>
                            <?php if (!isset($quantityTotals[$branch->id])): ?>
                                <?php $quantityTotals[$branch->id] = '0.00'; ?>
                            <?php endif; ?>
                            <?php $quantityTotals[$branch->id] += $quantity; ?>
                        <?php endforeach; ?>
                        <td style="text-align: right">
                            <?php echo CHtml::link(Yii::app()->numberFormatter->format('#,##0', $quantitySum), array(
                                'transactionVehicleInfo', 
                                'year' => $year, 
                                'month' => $month, 
                                'branchId' => null,
                            ), array('target' => '_blank')); ?>
                        </td>
                    </tr>
            <?php endfor; ?>
        </tbody>
        <tfoot>
            <tr>
                <td>Total</td>
                <?php $grandTotal = '0.00'; ?>
                <?php foreach ($branches as $branch): ?>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $quantityTotals[$branch->id])); ?></td>
                    <?php $grandTotal += $quantityTotals[$branch->id]; ?>
                <?php endforeach; ?>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotal)); ?></td>
            </tr>
        </tfoot>
    </table>
</fieldset>