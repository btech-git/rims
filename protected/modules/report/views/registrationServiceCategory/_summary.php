<?php $dateNumList = range(1, 31); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger"><?php echo Yii::app()->name; ?></div>
    <div style="font-size: larger">Laporan Penyelesaian Pesanan per Pekerjaan </div>
    <div><?php echo 'Periode bulan: ' . CHtml::encode(Yii::app()->dateFormatter->format('MMMM yyyy', $yearMonth)); ?></div>
</div>

<br />

<table style="width: 100%">
    <thead>
        <tr>
            <th style="width: 768px"></th>
            <?php foreach ($dateNumList as $dateNum): ?>
                <th style="width: 256px"><?php echo $dateNum; ?></th>
            <?php endforeach; ?>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php $footerTotalSums = array(); ?>
        <?php foreach ($registrationServiceInfo as $elementNumber => $registrationServiceItem): ?>
            <tr>
                <td style="text-align: right"><?php echo $registrationServiceItem['code']; ?></td>
                <?php $totalSum = 0; ?>
                <?php foreach ($dateNumList as $dateNum): ?>
                    <?php $transactionDate = $yearMonth . '-' . str_pad($dateNum, 2, '0', STR_PAD_LEFT); ?>
                    <?php $total = isset($registrationServiceItem['totals'][$transactionDate]) ? $registrationServiceItem['totals'][$transactionDate] : ''; ?>
                    <td style="text-align: right">
                        <?php echo CHtml::encode($total); ?>
                    </td>
                    <?php $totalSum += $total; ?>
                    <?php if (!isset($footerTotalSums[$dateNum])): ?>
                        <?php $footerTotalSums[$dateNum] = 0; ?>
                    <?php endif; ?>
                    <?php $footerTotalSums[$dateNum] += $total; ?>
                <?php endforeach; ?>
                <td style="text-align: right"><?php echo CHtml::encode($totalSum); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td style="text-align: right">Total</td>
            <?php $grandTotal = 0; ?>
            <?php foreach ($dateNumList as $dateNum): ?>
                <?php if (!isset($footerTotalSums[$dateNum])): ?>
                    <?php $footerTotalSums[$dateNum] = 0; ?>
                <?php endif; ?>
                <td style="text-align: right"><?php echo CHtml::encode($footerTotalSums[$dateNum]); ?></td>
                <?php $grandTotal += $footerTotalSums[$dateNum]; ?>
            <?php endforeach; ?>
            <td style="text-align: right"><?php echo CHtml::encode($grandTotal); ?></td>
        </tr>
    </tfoot>
</table>
    
