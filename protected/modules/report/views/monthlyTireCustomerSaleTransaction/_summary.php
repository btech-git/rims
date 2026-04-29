<div style="text-align: right">
    <?php echo 'Displaying ' . count($monthlyTireCustomerSaleTransactionReportData) . ' result(s).'; ?>
</div>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Raperind Motor</div>
    <div style="font-size: larger">Penjualan Ban per Contract Service</div>
    <div><?php echo CHtml::encode(strftime("%B",mktime(0,0,0,$month))); ?> <?php echo CHtml::encode($year); ?></div>
</div>

<br />

<table>
    <thead style="position: sticky; top: 0">
        <tr>
            <th style="text-align: center">ID</th>
            <th style="text-align: center">Name</th>
            <?php foreach ($branches as $branch): ?>
                <th style="text-align: center"><?php echo CHtml::encode(CHtml::value($branch, 'code')); ?></th>
            <?php endforeach; ?>
            <th style="text-align: center">Total</th>
        </tr>
    </thead>
    
    <tbody>
        <?php $groupTotalSums = array(); ?>
        <?php foreach ($monthlyTireCustomerSaleTransactionReportData as $customerId => $dataItem): ?>
            <?php $totalQuantity = 0; ?>
            <?php $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year); ?>
            <?php $yearMonth = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT); ?>
            <?php $startDate = $yearMonth . '-01'; ?>
            <?php $endDate = $yearMonth . '-' . $daysInMonth; ?>
            <tr>
                <td><?php echo CHtml::encode($customerId); ?></td>
                <td><?php echo CHtml::encode($dataItem['customer_name']); ?></td>
                
                <?php foreach ($branches as $branch): ?>
                    <?php $saleQuantity = isset($dataItem[$branch->id]) ? $dataItem[$branch->id] : 0; ?>
                    <td style="text-align: center">
                        <?php echo CHtml::link($saleQuantity, array(
                            '/report/monthlyTireSaleTransaction/transactionInfo', 
//                            'productId' => $product->id, 
                            'startDate' => $startDate, 
                            'endDate' => $endDate,
                            'branchId' => $branch->id,
                        ), array('target' => '_blank')); ?>
                    </td>
                    <?php $totalQuantity += $saleQuantity; ?>
                    <?php if (!isset($groupTotalSums[$branch->id])): ?>
                        <?php $groupTotalSums[$branch->id] = 0; ?>
                    <?php endif; ?>
                    <?php $groupTotalSums[$branch->id] += $saleQuantity; ?>
                <?php endforeach; ?>
                <td style="text-align: center">
                    <?php echo CHtml::link($totalQuantity, array(
                        '/report/monthlyTireSaleTransaction/transactionInfo', 
//                        'productId' => $product->id, 
                        'startDate' => $startDate, 
                        'endDate' => $endDate,
                        'branchId' => null,
                    ), array('target' => '_blank')); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td style="text-align: right" colspan="2">Total</td>
            <?php $grandTotal = 0; ?>
            <?php foreach ($branches as $branch): ?>
                <?php if (!isset($groupTotalSums[$branch->id])): ?>
                    <?php $groupTotalSums[$branch->id] = 0; ?>
                <?php endif; ?>
                <td style="text-align: center"><?php echo CHtml::encode($groupTotalSums[$branch->id]); ?></td>
                <?php $grandTotal += $groupTotalSums[$branch->id]; ?>
            <?php endforeach; ?>
            <td style="text-align: center"><?php echo CHtml::encode($grandTotal); ?></td>
        </tr>
    </tfoot>
</table>