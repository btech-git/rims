<?php $dateNumList = range(1, 31); ?>

<div style="font-weight: bold; text-align: center">
    <?php $branch = Branch::model()->findByPk($branchId); ?>
    <div style="font-size: larger">Raperind Motor <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?></div>
    <div style="font-size: larger">Laporan Penjualan Tahunan Oli</div>
    <div><?php echo 'Periode tahun: ' . CHtml::encode($year); ?></div>
</div>

<br />

<?php $startDate = $year . '-01-01'; ?>
<?php $endDate = $year . '-12-31'; ?>

<table style="width: 110%">
    <thead>
        <tr>
            <th style="width: 3%">No.</th>
            <th style="width: 5%">ID</th>
            <th style="width: 10%">Code</th>
            <th style="width: 10%">Name</th>
            <th style="width: 10%">SAE</th>
            <th style="width: 10%">Brand</th>
            <th style="width: 10%">Category</th>
            <th style="width: 5%">Satuan</th>
            <?php for ($month = 1; $month <= 12; $month++): ?>
                <th style="width: 256px"><?php echo CHtml::encode($monthList[$month]); ?></th>
            <?php endfor; ?>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php $groupTotalSums = array(); ?>
        <?php $autoNumber = 1; ?>
        <?php foreach ($invoiceOilInfo as $invoiceOilSaleInfo): ?>
            <?php $totalSum = 0; ?>
            <?php $product = Product::model()->findByPk($invoiceOilSaleInfo['product_id']); ?>
            <?php $multiplier = $unitConversion !== null && $unitConversion->unit_from_id == $product->unit_id ? $unitConversion->multiplier : 1; ?>
            <tr>
                <td style="text-align: center"><?php echo $autoNumber; ?></td>
                <td><?php echo $invoiceOilSaleInfo['product_id']; ?></td>
                <td><?php echo $invoiceOilSaleInfo['product_code']; ?></td>
                <td><?php echo $invoiceOilSaleInfo['product_name']; ?></td>
                <td><?php echo $invoiceOilSaleInfo['oil_name']; ?></td>
                <td>
                    <?php echo $invoiceOilSaleInfo['brand_name']; ?> -
                    <?php echo $invoiceOilSaleInfo['sub_brand_name']; ?> -
                    <?php echo $invoiceOilSaleInfo['sub_brand_series_name']; ?>
                </td>
                <td>
                    <?php echo $invoiceOilSaleInfo['master_category_name']; ?> -
                    <?php echo $invoiceOilSaleInfo['sub_category_name']; ?> -
                    <?php echo $invoiceOilSaleInfo['sub_master_category_name']; ?>
                </td>
                <td>
                    <?php if (empty($convertToLitre)): ?>
                        <?php echo $invoiceOilSaleInfo['unit_name']; ?>
                    <?php else: ?>
                        <?php echo 'Liter'; ?>
                    <?php endif; ?>
                </td>
                <?php for ($month = 1; $month <= 12; $month++): ?>
                    <?php $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year); ?>
                    <?php $yearMonth = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT); ?>
                    <?php $startDate = $yearMonth . '-01'; ?>
                    <?php $endDate = $yearMonth . '-' . $daysInMonth; ?>
                    <?php $originalQuantity = isset($invoiceOilSaleInfo['totals'][$month]) ? $invoiceOilSaleInfo['totals'][$month] : ''; ?>
                    <?php $total = $multiplier * $originalQuantity; ?>
                    <td style="text-align: right">
                        <?php echo CHtml::link($total, array(
                            '/report/yearlyOilSaleTransaction/transactionInfo', 
                            'productId' => $invoiceOilSaleInfo['product_id'], 
                            'startDate' => $startDate, 
                            'endDate' => $endDate,
                            'branchId' => $branchId,
                        ), array('target' => '_blank')); ?>
                    </td>
                    <?php $totalSum += $total; ?>
                    <?php if (!isset($groupTotalSums[$month])): ?>
                        <?php $groupTotalSums[$month] = 0; ?>
                    <?php endif; ?>
                    <?php $groupTotalSums[$month] += $total; ?>
                <?php endfor; ?>
                <td style="text-align: right">
                    <?php echo CHtml::link($totalSum, array(
                        '/report/yearlyOilSaleTransaction/transactionInfo', 
                        'productId' => $invoiceOilSaleInfo['product_id'], 
                        'startDate' => $startDate, 
                        'endDate' => $endDate,
                        'branchId' => $branchId,
                    ), array('target' => '_blank')); ?>
                </td>
            </tr>
            <?php $autoNumber++; ?>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td style="text-align: right" colspan="7">Total</td>
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
    
