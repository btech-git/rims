<style> 
 .table_wrapper{
    display: block;
    overflow-x: auto;
    white-space: nowrap;
}
</style>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Penjualan Semua Cabang Harian</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))); ?> - <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<div class="table_wrapper">
    <table class="responsive">
        <thead>
            <tr id="header1">
                <th class="width1-13">No</th>
                <th class="width1-1">Branch</th>
                <th class="width1-2">Vehicle Total</th>
                <th class="width1-3">Vehicle Baru</th>
                <th class="width1-4">Vehicle Repeat</th>
                <th class="width1-2">Customer Total</th>
                <th class="width1-3">Customer Baru</th>
                <th class="width1-4">Customer Repeat</th>
                <th class="width1-5">Retail</th>
                <th class="width1-6">Contract Service Unit</th>
                <th class="width1-7">Total Invoice (Rp)</th>
                <th class="width1-8">Service (Rp)</th>
                <th class="width1-9">Parts (Rp)</th>
                <th class="width1-10">Total Ban</th>
                <th class="width1-11">Total Oli</th>
                <th class="width1-12">Total Aksesoris</th>
            </tr>
        </thead>
        <tbody>
            <?php $vehicleQuantitySum = 0; ?>
            <?php $vehicleNewQuantitySum = 0; ?>
            <?php $vehicleRepeatQuantitySum = 0; ?>
            <?php $customerQuantitySum = 0; ?>
            <?php $customerNewQuantitySum = 0; ?>
            <?php $customerRepeatQuantitySum = 0; ?>
            <?php $customerRetailQuantitySum = 0; ?>
            <?php $customerCompanyQuantitySum = 0; ?>
            <?php $grandTotalSum = '0.00'; ?>
            <?php $totalServiceSum = '0.00'; ?>
            <?php $totalProductSum = '0.00'; ?>
            <?php $tireQuantitySum = 0; ?>
            <?php $oilQuantitySum = 0; ?>
            <?php $accessoriesQuantitySum = 0; ?>
            <?php foreach ($dailyMultipleBranchSaleReport as $i => $dataItem): ?>
                <?php if (isset($dailyMultipleBranchSaleProductReportData[$dataItem['branch_id']]) ? $dailyMultipleBranchSaleProductReportData[$dataItem['branch_id']] : ''): ?>
                    <?php $detailItem = $dailyMultipleBranchSaleProductReportData[$dataItem['branch_id']]; ?>
                    <tr class="items1">
                        <td style="text-align: center"><?php echo CHtml::encode($i + 1); ?></td>
                        <td><?php echo CHtml::encode($dataItem['branch_name']); ?></td>
                        <td style="text-align: center">
                            <?php echo CHtml::link(CHtml::encode($dataItem['vehicle_quantity']), array(
                                '/report/branchSaleTransactionInfo/headerInfo', 
                                'showDetails' => 0, 
                                'branchId' => $dataItem['branch_id'], 
                                'startDate' => $startDate, 
                                'endDate' => $endDate
                            ), array('target' => '_blank')); ?>
                        </td>
                        <td style="text-align: center"><?php echo CHtml::encode($dataItem['vehicle_new_quantity']); ?></td>
                        <td style="text-align: center"><?php echo CHtml::encode($dataItem['vehicle_repeat_quantity']); ?></td>
                        <td style="text-align: center">
                            <?php echo CHtml::link(CHtml::encode($dataItem['customer_quantity']), array(
                                '/report/branchSaleTransactionInfo/headerInfo', 
                                'showDetails' => 0, 
                                'branchId' => $dataItem['branch_id'], 
                                'startDate' => $startDate, 
                                'endDate' => $endDate
                            ), array('target' => '_blank')); ?>
                        </td>
                        <td style="text-align: center"><?php echo CHtml::encode($dataItem['customer_new_quantity']); ?></td>
                        <td style="text-align: center"><?php echo CHtml::encode($dataItem['customer_repeat_quantity']); ?></td>
                        <td style="text-align: center"><?php echo CHtml::encode($dataItem['customer_retail_quantity']); ?></td>
                        <td style="text-align: center"><?php echo CHtml::encode($dataItem['customer_company_quantity']); ?></td>
                        <td style="text-align: right">
                            <?php echo CHtml::link(CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['sub_total'])), array(
                                '/report/branchSaleTransactionInfo/headerInfo', 
                                'showDetails' => 1, 
                                'branchId' => $dataItem['branch_id'], 
                                'startDate' => $startDate, 
                                'endDate' => $endDate
                            ), array('target' => '_blank')); ?>
                        </td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['total_service'])); ?></td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['total_product'])); ?></td>
                        <td style="text-align: center">
                            <?php echo CHtml::link(CHtml::encode($detailItem['tire_quantity']), array(
                                '/report/branchSaleTransactionInfo/detailInfo', 
                                'branchId' => $dataItem['branch_id'], 
                                'startDate' => $startDate, 
                                'endDate' => $endDate, 
                                'productSubCategoryIdsString' => implode(',', array(442, 444)),
                            ), array('target' => '_blank')); ?>
                        </td>
                        <td style="text-align: center">
                            <?php echo CHtml::link(CHtml::encode($detailItem['oil_quantity']), array(
                                '/report/branchSaleTransactionInfo/detailInfo', 
                                'branchId' => $dataItem['branch_id'], 
                                'startDate' => $startDate, 
                                'endDate' => $endDate, 
                                'productSubCategoryIdsString' => implode(',', array(540)),
                            ), array('target' => '_blank')); ?>
                        </td>
                        <td style="text-align: center">
                            <?php echo CHtml::link(CHtml::encode($detailItem['accessories_quantity']), array(
                                '/report/branchSaleTransactionInfo/detailInfo', 
                                'branchId' => $dataItem['branch_id'], 
                                'startDate' => $startDate, 
                                'endDate' => $endDate, 
                                'productSubCategoryIdsString' => implode(',', range(636, 649)),
                            ), array('target' => '_blank')); ?>
                        </td>
                    </tr>
                    <?php $vehicleQuantitySum += $dataItem['vehicle_quantity']; ?>
                    <?php $vehicleNewQuantitySum += $dataItem['vehicle_new_quantity']; ?>
                    <?php $vehicleRepeatQuantitySum += $dataItem['vehicle_repeat_quantity']; ?>
                    <?php $customerQuantitySum += $dataItem['customer_quantity']; ?>
                    <?php $customerNewQuantitySum += $dataItem['customer_new_quantity']; ?>
                    <?php $customerRepeatQuantitySum += $dataItem['customer_repeat_quantity']; ?>
                    <?php $customerRetailQuantitySum += $dataItem['customer_retail_quantity']; ?>
                    <?php $customerCompanyQuantitySum += $dataItem['customer_company_quantity']; ?>
                    <?php $grandTotalSum += $dataItem['sub_total']; ?>
                    <?php $totalServiceSum += $dataItem['total_service']; ?>
                    <?php $totalProductSum += $dataItem['total_product']; ?>
                    <?php $tireQuantitySum += $detailItem['tire_quantity']; ?>
                    <?php $oilQuantitySum += $detailItem['oil_quantity']; ?>
                    <?php $accessoriesQuantitySum += $detailItem['accessories_quantity']; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">TOTAL</td>
                <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $vehicleQuantitySum)); ?></td>
                <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $vehicleNewQuantitySum)); ?></td>
                <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $vehicleRepeatQuantitySum)); ?></td>
                <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $customerQuantitySum)); ?></td>
                <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $customerNewQuantitySum)); ?></td>
                <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $customerRepeatQuantitySum)); ?></td>
                <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $customerRetailQuantitySum)); ?></td>
                <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $customerCompanyQuantitySum)); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $grandTotalSum)); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalServiceSum)); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalProductSum)); ?></td>
                <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $tireQuantitySum)); ?></td>
                <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $oilQuantitySum)); ?></td>
                <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $accessoriesQuantitySum)); ?></td>
            </tr>
        </tfoot>
    </table>
</div>