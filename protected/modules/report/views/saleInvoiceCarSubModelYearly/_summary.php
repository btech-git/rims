<?php $dateNumList = range(1, 31); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger"><?php echo Yii::app()->name; ?></div>
    <div style="font-size: larger">Laporan Penjualan Tahunan Kendaraan </div>
    <div><?php echo 'Periode tahun: ' . CHtml::encode($year); ?></div>
</div>

<br />

<table style="width: 110%">
    <thead>
        <tr>
            <th style="width: 20%" colspan="3"></th>
            <?php for ($month = 1; $month <= 12; $month++): ?>
                <th style="width: 256px"><?php echo CHtml::encode($monthList[$month]); ?></th>
            <?php endfor; ?>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php $groupTotalSums = array(); ?>
        <?php foreach ($invoiceVehicleInfo as $invoiceVehicleCarSubModelInfo): ?>
            <tr>
                <td style="text-align: right"><?php echo $invoiceVehicleCarSubModelInfo['car_make_name']; ?></td>
                <td style="text-align: right"><?php echo $invoiceVehicleCarSubModelInfo['car_model_name']; ?></td>
                <td style="text-align: right"><?php echo $invoiceVehicleCarSubModelInfo['car_sub_model_name']; ?></td>
                <?php $totalSum = 0; ?>
                <?php for ($month = 1; $month <= 12; $month++): ?>
                    <?php $total = isset($invoiceVehicleCarSubModelInfo['totals'][$month]) ? $invoiceVehicleCarSubModelInfo['totals'][$month] : ''; ?>
                    <td style="text-align: right">
                        <?php echo CHtml::encode($total); ?>
                    </td>
                    <?php $totalSum += $total; ?>
                    <?php if (!isset($groupTotalSums[$month])): ?>
                        <?php $groupTotalSums[$month] = 0; ?>
                    <?php endif; ?>
                    <?php $groupTotalSums[$month] += $total; ?>
                <?php endfor; ?>
                <td style="text-align: right"><?php echo CHtml::encode($totalSum); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td style="text-align: right" colspan="3">Total</td>
            <?php $grandTotal = 0; ?>
            <?php for ($month = 1; $month <= 12; $month++): ?>
                <?php if (!isset($groupTotalSums[$month])): ?>
                    <?php $groupTotalSums[$month] = 0; ?>
                <?php endif; ?>
                <td style="text-align: right"><?php echo CHtml::encode($groupTotalSums[$month]); ?></td>
                <?php $grandTotal += $groupTotalSums[$month]; ?>
            <?php endfor; ?>
            <td style="text-align: right"><?php echo CHtml::encode($grandTotal); ?></td>
        </tr>
    </tfoot>
</table>
    
