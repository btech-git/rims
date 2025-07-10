<?php $dateNumList = range(1, 31); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger"><?php echo Yii::app()->name; ?></div>
    <div style="font-size: larger">Laporan Penjualan Bulanan Kendaraan </div>
    <div><?php echo CHtml::encode(strftime("%B",mktime(0,0,0,$month))); ?> <?php echo CHtml::encode($year); ?></div>
</div>

<br />

<table style="width: 110%">
    <thead>
        <tr>
            <th style="width: 3%">No.</th>
            <th style="width: 10%">Car Make</th>
            <th style="width: 10%">Car Model</th>
            <th style="width: 10%">Car Type</th>
            <?php foreach ($dateNumList as $dateNum): ?>
                <th style="width: 256px"><?php echo $dateNum; ?></th>
            <?php endforeach; ?>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php $groupTotalSums = array(); ?>
        <?php $autoNumber = 1; ?>
        <?php foreach ($invoiceVehicleInfo as $i => $invoiceVehicleCarSubModelInfo): ?>
            <tr>
                <td style="text-align: center"><?php echo $autoNumber; ?></td>
                <td><?php echo $invoiceVehicleCarSubModelInfo['car_make_name']; ?></td>
                <td><?php echo $invoiceVehicleCarSubModelInfo['car_model_name']; ?></td>
                <td><?php echo $invoiceVehicleCarSubModelInfo['car_sub_model_name']; ?></td>
                <?php $totalSum = 0; ?>
                <?php foreach ($dateNumList as $dateNum): ?>
                    <?php $transactionDate = $year . '-' . $month . '-' . str_pad($dateNum, 2, '0', STR_PAD_LEFT); ?>
                    <?php $total = isset($invoiceVehicleCarSubModelInfo['totals'][$transactionDate]) ? $invoiceVehicleCarSubModelInfo['totals'][$transactionDate] : ''; ?>
                    <td style="text-align: right">
                        <?php echo CHtml::encode($total); ?>
                    </td>
                    <?php $totalSum += $total; ?>
                    <?php if (!isset($groupTotalSums[$dateNum])): ?>
                        <?php $groupTotalSums[$dateNum] = 0; ?>
                    <?php endif; ?>
                    <?php $groupTotalSums[$dateNum] += $total; ?>
                <?php endforeach; ?>
                <td style="text-align: right"><?php echo CHtml::encode($totalSum); ?></td>
            </tr>
            <?php $autoNumber++; ?>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td style="text-align: right" colspan="4">Total</td>
            <?php $grandTotal = 0; ?>
            <?php foreach ($dateNumList as $dateNum): ?>
                <?php if (!isset($groupTotalSums[$dateNum])): ?>
                    <?php $groupTotalSums[$dateNum] = 0; ?>
                <?php endif; ?>
                <td style="text-align: right"><?php echo CHtml::encode($groupTotalSums[$dateNum]); ?></td>
                <?php $grandTotal += $groupTotalSums[$dateNum]; ?>
            <?php endforeach; ?>
            <td style="text-align: right"><?php echo CHtml::encode($grandTotal); ?></td>
        </tr>
    </tfoot>
</table>
    
