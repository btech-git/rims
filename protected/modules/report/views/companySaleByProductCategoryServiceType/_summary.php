<div class="grid-view">
    <?php foreach ($companyList as $companyItem): ?>
        <div><?php echo CHtml::encode(CHtml::value($companyItem, 'name')); ?></div>
        <table class="report" style="table-layout: fixed; width: 2000px">
            <thead>
                <tr id="header1">
                    <th style="width: 80px"></th>
                    <?php foreach ($productMasterCategoryList as $productMasterCategoryItem): ?>
                        <th style="width: 120px; overflow: hidden"><?php echo CHtml::encode(CHtml::value($productMasterCategoryItem, 'name')); ?></th>
                    <?php endforeach; ?>
                    <?php foreach ($serviceCategoryList as $serviceCategoryItem): ?>
                        <th style="width: 120px; overflow: hidden"><?php echo CHtml::encode(CHtml::value($serviceCategoryItem, 'name')); ?></th>
                    <?php endforeach; ?>
                    <th style="width: 120px">DPP Product</th>
                    <th style="width: 120px">DPP Service</th>
                    <th style="width: 120px">DPP Total</th>
                    <th style="width: 120px">Disc</th>
                    <th style="width: 120px">PPn</th>
                    <th style="width: 120px">PPh</th>
                    <th style="width: 120px">Total</th>
                    <th style="width: 120px">Qty Product</th>
                    <th style="width: 120px">Qty Service</th>
                </tr>
            </thead>
            <tbody>
                <?php $productAmountSubTotals = array(); ?>
                <?php $serviceAmountSubTotals = array(); ?>

                <?php $productAmountSumSubTotal = '0.00'; ?>
                <?php $serviceAmountSumSubTotal = '0.00'; ?>
                <?php $amountSubTotal = '0.00'; ?>

                <?php $totalDiscountSubTotal = '0.00'; ?>
                <?php $ppnTotalSubTotal = '0.00'; ?>
                <?php $pphTotalSubTotal = '0.00'; ?>
                <?php $totalPriceSubTotal = '0.00'; ?>
                <?php $totalProductSubTotal = '0.00'; ?>
                <?php $totalServiceSubTotal = '0.00'; ?>
                <?php foreach ($branchList as $branchItem): ?>
                    <?php if ($branchItem->company_id === $companyItem->id): ?>
                        <tr>
                            <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($branchItem, 'code')); ?></td>

                            <?php $productAmountSum = '0.00'; ?>
                            <?php foreach ($productMasterCategoryList as $productMasterCategoryItem): ?>
                                <?php $productAmount = '0.00'; ?>
                                <?php if (isset($saleReportData[$companyItem->id][$branchItem->id]['product'][$productMasterCategoryItem->id])): ?>
                                    <?php $productAmount = $saleReportData[$companyItem->id][$branchItem->id]['product'][$productMasterCategoryItem->id]; ?>
                                <?php endif; ?>
                                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $productAmount)); ?></td>
                                <?php $productAmountSum += $productAmount; ?>
                                <?php if (!isset($productAmountSubTotals[$productMasterCategoryItem->id])): ?>
                                    <?php $productAmountSubTotals[$productMasterCategoryItem->id] = '0.00'; ?>
                                <?php endif; ?>
                                <?php $productAmountSubTotals[$productMasterCategoryItem->id] += $productAmount; ?>
                            <?php endforeach; ?>

                            <?php $serviceAmountSum = '0.00'; ?>
                            <?php foreach ($serviceCategoryList as $serviceCategoryItem): ?>
                                <?php $serviceAmount = '0.00'; ?>
                                <?php if (isset($saleReportData[$companyItem->id][$branchItem->id]['service'][$serviceCategoryItem->id])): ?>
                                    <?php $serviceAmount = $saleReportData[$companyItem->id][$branchItem->id]['service'][$serviceCategoryItem->id]; ?>
                                <?php endif; ?>
                                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $serviceAmount)); ?></td>
                                <?php $serviceAmountSum += $serviceAmount; ?>
                                <?php if (!isset($serviceAmountSubTotals[$serviceCategoryItem->id])): ?>
                                    <?php $serviceAmountSubTotals[$serviceCategoryItem->id] = '0.00'; ?>
                                <?php endif; ?>
                                <?php $serviceAmountSubTotals[$serviceCategoryItem->id] += $serviceAmount; ?>
                            <?php endforeach; ?>

                            <?php $amountSum = $productAmountSum + $serviceAmountSum; ?>
                            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $productAmountSum)); ?></td>
                            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $serviceAmountSum)); ?></td>
                            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $amountSum)); ?></td>
                            <?php $productAmountSumSubTotal += $productAmountSum; ?>
                            <?php $serviceAmountSumSubTotal += $serviceAmountSum; ?>
                            <?php $amountSubTotal += $amountSum; ?>

                            <?php $totalDiscount = '0.00'; ?>
                            <?php if (isset($saleReportData[$companyItem->id][$branchItem->id]['total_discount'])): ?>
                                <?php $totalDiscount = $saleReportData[$companyItem->id][$branchItem->id]['total_discount']; ?>
                            <?php endif; ?>
                            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalDiscount)); ?></td>
                            <?php $totalDiscountSubTotal += $totalDiscount; ?>

                            <?php $ppnTotal = '0.00'; ?>
                            <?php if (isset($saleReportData[$companyItem->id][$branchItem->id]['ppn_total'])): ?>
                                <?php $ppnTotal = $saleReportData[$companyItem->id][$branchItem->id]['ppn_total']; ?>
                            <?php endif; ?>
                            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $ppnTotal)); ?></td>
                            <?php $ppnTotalSubTotal += $ppnTotal; ?>

                            <?php $pphTotal = '0.00'; ?>
                            <?php if (isset($saleReportData[$companyItem->id][$branchItem->id]['pph_total'])): ?>
                                <?php $pphTotal = $saleReportData[$companyItem->id][$branchItem->id]['pph_total']; ?>
                            <?php endif; ?>
                            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $pphTotal)); ?></td>
                            <?php $pphTotalSubTotal += $pphTotal; ?>

                            <?php $totalPrice = '0.00'; ?>
                            <?php if (isset($saleReportData[$companyItem->id][$branchItem->id]['total_price'])): ?>
                                <?php $totalPrice = $saleReportData[$companyItem->id][$branchItem->id]['total_price']; ?>
                            <?php endif; ?>
                            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalPrice)); ?></td>
                            <?php $totalPriceSubTotal += $totalPrice; ?>

                            <?php $totalProduct = '0.00'; ?>
                            <?php if (isset($saleReportData[$companyItem->id][$branchItem->id]['total_product'])): ?>
                                <?php $totalProduct = $saleReportData[$companyItem->id][$branchItem->id]['total_product']; ?>
                            <?php endif; ?>
                            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalProduct)); ?></td>
                            <?php $totalProductSubTotal += $totalProduct; ?>

                            <?php $totalService = '0.00'; ?>
                            <?php if (isset($saleReportData[$companyItem->id][$branchItem->id]['total_service'])): ?>
                                <?php $totalService = $saleReportData[$companyItem->id][$branchItem->id]['total_service']; ?>
                            <?php endif; ?>
                            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalService)); ?></td>
                            <?php $totalServiceSubTotal += $totalService; ?>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td style="text-align: right">Total</td>
                    <?php foreach ($productMasterCategoryList as $productMasterCategoryItem): ?>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $productAmountSubTotals[$productMasterCategoryItem->id])); ?>
                        </td>
                    <?php endforeach; ?>
                    <?php foreach ($serviceCategoryList as $serviceCategoryItem): ?>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $serviceAmountSubTotals[$serviceCategoryItem->id])); ?>
                        </td>
                    <?php endforeach; ?>

                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $productAmountSumSubTotal)); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $serviceAmountSumSubTotal)); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $amountSubTotal)); ?></td>

                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalDiscountSubTotal)); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $ppnTotalSubTotal)); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $pphTotalSubTotal)); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalPriceSubTotal)); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalProductSubTotal)); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalServiceSubTotal)); ?></td>
                </tr>
            </tfoot>
        </table>
    <?php endforeach; ?>
</div>