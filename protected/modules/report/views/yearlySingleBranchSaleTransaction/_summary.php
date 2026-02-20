<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 5% }
    .width1-2 { width: 5% }
    .width1-3 { width: 5% }
    .width1-4 { width: 5% }
    .width1-5 { width: 5% }
    .width1-6 { width: 5% }
    .width1-7 { width: 5% }
    .width1-8 { width: 5% }
    .width1-9 { width: 5% }
    .width1-10 { width: 5% }
    .width1-11 { width: 5% }
    .width1-12 { width: 5% }
    .width1-13 { width: 5% }
    .width1-14 { width: 5% }
    .width1-15 { width: 5% }
');
?>

<div style="font-weight: bold; text-align: center">
    <?php $branch = Branch::model()->findByPk($branchId); ?>
    <div style="font-size: larger">Penjualan Tahunan Cabang <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?></div>
    <div><?php echo CHtml::encode($year); ?></div>
</div>

<br />

<table class="report">
    <thead>
        <tr id="header1">
            <th class="width1-1">Bulan</th>
            <th class="width1-2">Customer Total</th>
            <th class="width1-3">Baru</th>
            <th class="width1-4">Repeat</th>
            <th class="width1-5">Retail</th>
            <th class="width1-6">Contract Service Unit</th>
            <th class="width1-7">Total Invoice (Rp)</th>
            <th class="width1-8">Service (Rp)</th>
            <th class="width1-9">Parts (Rp)</th>
            <th class="width1-7">Invoice per Unit</th>
            <th class="width1-7">Service per Unit</th>
            <th class="width1-7">Parts per Unit</th>
            <th class="width1-10">Total Ban</th>
            <th class="width1-11">Total Oli</th>
            <th class="width1-12">Total Aksesoris</th>
            <th class="width1-13">Average Ban</th>
            <th class="width1-14">Average Oli</th>
            <th class="width1-15">Average Aksesoris</th>
        </tr>
    </thead>
    <tbody>
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
        <?php $averageTireSum = '0.00'; ?>
        <?php $averageOilSum = '0.00'; ?>
        <?php $averageAccessoriesSum = '0.00'; ?>
        <?php for ($i = 1; $i <= 12; $i++): ?>
            <?php if (isset($yearlySingleBranchSaleReportData[$i]) && isset($yearlySingleBranchSaleProductReportData[$i])): ?>
                <?php $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $i, $year); ?>
                <?php $yearMonth = $year . '-' . str_pad($i, 2, '0', STR_PAD_LEFT); ?>
                <?php $startDate = $yearMonth . '-01'; ?>
                <?php $endDate = $yearMonth . '-' . $daysInMonth; ?>

                <?php $dataItem = $yearlySingleBranchSaleReportData[$i]; ?>
                <?php $detailItem = $yearlySingleBranchSaleProductReportData[$i]; ?>
                <?php $totalInvoicePerCustomer = round($dataItem['grand_total'] / $dataItem['customer_quantity'], 2); ?>
                <?php $totalServicePerCustomer = round($dataItem['total_service'] / $dataItem['customer_quantity'], 2); ?> 
                <?php $totalPartsPerCustomer = round($dataItem['total_product'] / $dataItem['customer_quantity'], 2); ?>
                <?php $averageTire = $detailItem['tire_quantity'] > 0 ? $detailItem['tire_price'] / $detailItem['tire_quantity'] : '0.00'; ?>
                <?php $averageOil = $detailItem['oil_quantity'] > 0 ? $detailItem['oil_price'] / $detailItem['oil_quantity'] : '0.00'; ?>
                <?php $averageAccessories = $detailItem['accessories_quantity'] > 0 ? $detailItem['accessories_price'] / $detailItem['accessories_quantity'] : '0.00'; ?>
                <tr class="items1">
                    <td><?php echo CHtml::encode(strftime("%B", mktime(0, 0, 0, $i))); ?></td>
                    <td style="text-align: center">
                        <?php echo CHtml::link(CHtml::encode($dataItem['customer_quantity']), array(
                            '/report/branchSaleTransactionInfo/headerInfo', 
                            'showDetails' => 0, 
                            'branchId' => $branchId, 
                            'startDate' => $startDate, 
                            'endDate' => $endDate
                        ), array('target' => '_blank')); ?>
                    </td>
                    <td style="text-align: center"><?php echo CHtml::encode($dataItem['customer_new_quantity']); ?></td>
                    <td style="text-align: center"><?php echo CHtml::encode($dataItem['customer_repeat_quantity']); ?></td>
                    <td style="text-align: center"><?php echo CHtml::encode($dataItem['customer_retail_quantity']); ?></td>
                    <td style="text-align: center"><?php echo CHtml::encode($dataItem['customer_company_quantity']); ?></td>
                    <td style="text-align: right">
                        <?php echo CHtml::link(CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['grand_total'])), array(
                            '/report/branchSaleTransactionInfo/headerInfo', 
                            'showDetails' => 1, 
                            'branchId' => $branchId, 
                            'startDate' => $startDate, 
                            'endDate' => $endDate
                        ), array('target' => '_blank')); ?>
                    </td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['total_service'])); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['total_product'])); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalInvoicePerCustomer)); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalServicePerCustomer)); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalPartsPerCustomer)); ?></td>
                    <td style="text-align: center">
                        <?php echo CHtml::link(CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detailItem['tire_quantity'])), array(
                            '/report/branchSaleTransactionInfo/detailInfo', 
                            'branchId' => $branchId, 
                            'startDate' => $startDate, 
                            'endDate' => $endDate, 
                            'productSubCategoryIdsString' => implode(',', array(442, 444)),
                        ), array('target' => '_blank')); ?>
                    </td>
                    <td style="text-align: center">
                    <?php $oilQuantity = isset($yearlySingleBranchSaleOilQuantityReportData[$dataItem['month']]) ? $yearlySingleBranchSaleOilQuantityReportData[$dataItem['month']] : 0; ?>
                        <?php echo CHtml::link(CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $oilQuantity)), array(
                            '/report/branchSaleTransactionInfo/detailInfo', 
                            'branchId' => $branchId, 
                            'startDate' => $startDate, 
                            'endDate' => $endDate, 
                            'productSubCategoryIdsString' => implode(',', array(540)),
                        ), array('target' => '_blank')); ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo CHtml::link(CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detailItem['accessories_quantity'])), array(
                            '/report/branchSaleTransactionInfo/detailInfo', 
                            'branchId' => $branchId, 
                            'startDate' => $startDate, 
                            'endDate' => $endDate, 
                            'productSubCategoryIdsString' => implode(',', range(636, 649)),
                        ), array('target' => '_blank')); ?>
                    </td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $averageTire)); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $averageOil)); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $averageAccessories)); ?></td>
                </tr>
                <?php $customerQuantitySum += $dataItem['customer_quantity']; ?>
                <?php $customerNewQuantitySum += $dataItem['customer_new_quantity']; ?>
                <?php $customerRepeatQuantitySum += $dataItem['customer_repeat_quantity']; ?>
                <?php $customerRetailQuantitySum += $dataItem['customer_retail_quantity']; ?>
                <?php $customerCompanyQuantitySum += $dataItem['customer_company_quantity']; ?>
                <?php $grandTotalSum += $dataItem['grand_total']; ?>
                <?php $totalServiceSum += $dataItem['total_service']; ?>
                <?php $totalProductSum += $dataItem['total_product']; ?>
                <?php $tireQuantitySum += $detailItem['tire_quantity']; ?>
                <?php $oilQuantitySum += $oilQuantity; ?>
                <?php $accessoriesQuantitySum += $detailItem['accessories_quantity']; ?>
                <?php $averageTireSum += $averageTire; ?>
                <?php $averageOilSum += $averageOil; ?>
                <?php $averageAccessoriesSum += $averageAccessories; ?>
            <?php else: ?>
                <tr class="items1">
                    <td><?php echo CHtml::encode(strftime("%B", mktime(0, 0, 0, $i))); ?></td>
                    <td colspan="17">&nbsp;</td>
                </tr>
            <?php endif; ?>
        <?php endfor; ?>
    </tbody>
    <tfoot>
        <tr>
            <td>TOTAL</td>
            <td style="text-align: center"><?php echo CHtml::encode($customerQuantitySum); ?></td>
            <td style="text-align: center"><?php echo CHtml::encode($customerNewQuantitySum); ?></td>
            <td style="text-align: center"><?php echo CHtml::encode($customerRepeatQuantitySum); ?></td>
            <td style="text-align: center"><?php echo CHtml::encode($customerRetailQuantitySum); ?></td>
            <td style="text-align: center"><?php echo CHtml::encode($customerCompanyQuantitySum); ?></td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $grandTotalSum)); ?></td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalServiceSum)); ?></td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalProductSum)); ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $tireQuantitySum)); ?></td>
            <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $oilQuantitySum)); ?></td>
            <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $accessoriesQuantitySum)); ?></td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $averageTireSum)); ?></td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $averageOilSum)); ?></td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $averageAccessoriesSum)); ?></td>
        </tr>
    </tfoot>
</table>