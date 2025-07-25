<?php $dateNumList = range(1, 31); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger"><?php echo Yii::app()->name; ?></div>
    <div style="font-size: larger">Laporan Penjualan Tahunan Kendaraan </div>
    <div><?php echo 'Periode tahun: ' . CHtml::encode($year); ?></div>
</div>

<br />

<?php $startDate = $year . '-01-01'; ?>
<?php $endDate = $year . '-12-31'; ?>

<table style="width: 110%">
    <thead>
        <tr>
            <th style="width: 3%">No.</th>
            <th style="width: 10%">Car Make</th>
            <th style="width: 10%">Car Model</th>
            <th style="width: 10%">Car Type</th>
            <?php for ($month = 1; $month <= 12; $month++): ?>
                <th style="width: 256px"><?php echo CHtml::encode($monthList[$month]); ?></th>
            <?php endfor; ?>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php $groupTotalSums = array(); ?>
        <?php $autoNumber = 1; ?>
        <?php foreach ($invoiceVehicleInfo as $invoiceVehicleCarSubModelInfo): ?>
            <tr>
                <td style="text-align: center"><?php echo $autoNumber; ?></td>
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
                <td style="text-align: right">
                    <?php echo CHtml::link($totalSum, array(
                        '/report/saleInvoiceCarSubModelMonthly/transactionInfo', 
                        'carSubModelId' => $invoiceVehicleCarSubModelInfo['car_sub_model_id'], 
                        'startDate' => $startDate, 
                        'endDate' => $endDate,
                    ), array('target' => '_blank')); ?>
                </td>
            </tr>
            <?php $autoNumber++; ?>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td style="text-align: right" colspan="4">Total</td>
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
    
