<h2>Penjualan All</h2>

<div class="grid-view">
    <table class="report" style="table-layout: fixed; width: 2000px">
        <tr id="header1">
            <th style="width: 80px">Tanggal</th>
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
        <?php $dppSums = array(); ?>
        <?php $discountTotalSum = '0.00'; ?>
        <?php $ppnTotalSum = '0.00'; ?>
        <?php $pphTotalSum = '0.00'; ?>
        <?php $totalPriceSum = '0.00'; ?>
        <?php $totalProductSum = '0.00'; ?>
        <?php $totalServiceSum = '0.00'; ?>
        <?php for ($n = 1; $n <= 31; $n++): ?>
            <?php $day = str_pad($n, 2, '0', STR_PAD_LEFT); ?>
            <tr>
                <td style="text-align: center"><?php echo $n; ?></td>
                <?php $dppProductSum = '0.00'; ?>
                <?php $dppServiceSum = '0.00'; ?>
                <?php $dppSum = '0.00'; ?>
                <?php foreach ($productMasterCategoryList as $productMasterCategoryItem): ?>
                    <?php $key = $year . '-' . $month . '-' . $day . '|p|' . $productMasterCategoryItem->id; ?>
                    <?php $dpp = isset($saleReportAllData[$key]) ? $saleReportAllData[$key] : ''; ?>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dpp)); ?></td>
                    <?php $dppProductSum += $dpp; ?>
                    <?php $dppSum += $dpp; ?>
                    <?php if (!isset($dppSums['p' . $productMasterCategoryItem->id])): ?>
                        <?php $dppSums['p' . $productMasterCategoryItem->id] = '0.00'; ?>
                    <?php endif; ?>
                    <?php $dppSums['p' . $productMasterCategoryItem->id] += $dpp; ?>
                <?php endforeach; ?>
                <?php foreach ($serviceCategoryList as $serviceCategoryItem): ?>
                    <?php $key = $year . '-' . $month . '-' . $day . '|s|' . $serviceCategoryItem->id; ?>
                    <?php $dpp = isset($saleReportAllData[$key]) ? $saleReportAllData[$key] : ''; ?>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dpp)); ?></td>
                    <?php $dppServiceSum += $dpp; ?>
                    <?php $dppSum += $dpp; ?>
                    <?php if (!isset($dppSums['s' . $serviceCategoryItem->id])): ?>
                        <?php $dppSums['s' . $serviceCategoryItem->id] = '0.00'; ?>
                    <?php endif; ?>
                    <?php $dppSums['s' . $serviceCategoryItem->id] += $dpp; ?>
                <?php endforeach; ?>
                <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dppProductSum)); ?></td>
                <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dppServiceSum)); ?></td>
                <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dppSum)); ?></td>
                <?php $key = $year . '-' . $month . '-' . $day; ?>
                <?php $discountTotal = isset($saleReportSummaryAllData[$key]['total_discount']) ? $saleReportSummaryAllData[$key]['total_discount'] : ''; ?>
                <?php $ppnTotal = isset($saleReportSummaryAllData[$key]['ppn_total']) ? $saleReportSummaryAllData[$key]['ppn_total'] : ''; ?>
                <?php $pphTotal = isset($saleReportSummaryAllData[$key]['pph_total']) ? $saleReportSummaryAllData[$key]['pph_total'] : ''; ?>
                <?php $totalPrice = isset($saleReportSummaryAllData[$key]['total_price']) ? $saleReportSummaryAllData[$key]['total_price'] : ''; ?>
                <?php $totalProduct = isset($saleReportSummaryAllData[$key]['total_product']) ? $saleReportSummaryAllData[$key]['total_product'] : ''; ?>
                <?php $totalService = isset($saleReportSummaryAllData[$key]['total_service']) ? $saleReportSummaryAllData[$key]['total_service'] : ''; ?>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $discountTotal)); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $ppnTotal)); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $pphTotal)); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalPrice)); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalProduct)); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalService)); ?></td>
                <?php $discountTotalSum += $discountTotal; ?>
                <?php $ppnTotalSum += $ppnTotal; ?>
                <?php $pphTotalSum += $pphTotal; ?>
                <?php $totalPriceSum += $totalPrice; ?>
                <?php $totalProductSum += $totalProduct; ?>
                <?php $totalServiceSum += $totalService; ?>
            </tr>
        <?php endfor; ?>
        <tr>
            <td></td>
            <?php $dppProductSumTotal = '0.00'; ?>
            <?php $dppServiceSumTotal = '0.00'; ?>
            <?php $dppSumTotal = '0.00'; ?>
            <?php foreach ($productMasterCategoryList as $productMasterCategoryItem): ?>
                <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dppSums['p' . $productMasterCategoryItem->id])); ?></td>
                <?php $dppProductSumTotal += $dppSums['p' . $productMasterCategoryItem->id]; ?>
                <?php $dppSumTotal += $dppSums['p' . $productMasterCategoryItem->id]; ?>
            <?php endforeach; ?>
            <?php foreach ($serviceCategoryList as $serviceCategoryItem): ?>
                <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dppSums['s' . $serviceCategoryItem->id])); ?></td>
                <?php $dppServiceSumTotal += $dppSums['s' . $serviceCategoryItem->id]; ?>
                <?php $dppSumTotal += $dppSums['s' . $serviceCategoryItem->id]; ?>
            <?php endforeach; ?>
            <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dppProductSumTotal)); ?></td>
            <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dppServiceSumTotal)); ?></td>
            <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dppSumTotal)); ?></td>
            <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $discountTotalSum)); ?></td>
            <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $ppnTotalSum)); ?></td>
            <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $pphTotalSum)); ?></td>
            <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalPriceSum)); ?></td>
            <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalProductSum)); ?></td>
            <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalServiceSum)); ?></td>
        </tr>
    </table>
</div>