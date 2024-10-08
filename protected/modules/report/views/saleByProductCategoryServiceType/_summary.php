<div style="font-weight: bold; text-align: center">
    <?php $branch = Branch::model()->findByPk($branchId); ?>
    <div style="font-size: larger">Laporan Penjualan <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?></div>
    <div><?php echo $monthList[$month] . ' ' . $year; ?></div>
</div>

<br />

<h2>Penjualan Retail</h2>

<div class="grid-view">
    <table class="report" style="width: 150%">
        <tr id="header1">
            <th>Tanggal</th>
            <?php foreach ($productMasterCategoryList as $productMasterCategoryItem): ?>
                <th><?php echo CHtml::encode(CHtml::value($productMasterCategoryItem, 'name')); ?></th>
            <?php endforeach; ?>
            <?php foreach ($serviceCategoryList as $serviceCategoryItem): ?>
                <th><?php echo CHtml::encode(CHtml::value($serviceCategoryItem, 'name')); ?></th>
            <?php endforeach; ?>
            <th>DPP</th>
            <th>PPn</th>
            <th>PPh</th>
            <th>Total</th>
            <th>Qty Product</th>
            <th>Qty Service</th>
        </tr>
        <?php $dppSums = array(); ?>
        <?php $ppnTotalSum = '0.00'; ?>
        <?php $pphTotalSum = '0.00'; ?>
        <?php $totalPriceSum = '0.00'; ?>
        <?php $totalProductSum = '0.00'; ?>
        <?php $totalServiceSum = '0.00'; ?>
        <?php for ($n = 1; $n <= $numberOfDays; $n++): ?>
            <?php $day = str_pad($n, 2, '0', STR_PAD_LEFT); ?>
            <tr>
                <td style="text-align: center"><?php echo $n; ?></td>
                <?php $dppSum = '0.00'; ?>
                <?php foreach ($productMasterCategoryList as $productMasterCategoryItem): ?>
                    <?php $key = 'Individual|' . $year . '-' . $month . '-' . $day . '|p|' . $productMasterCategoryItem->id; ?>
                    <?php $dpp = isset($saleReportData[$key]) ? $saleReportData[$key] : ''; ?>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dpp)); ?></td>
                    <?php $dppSum += $dpp; ?>
                    <?php if (!isset($dppSums['p' . $productMasterCategoryItem->id])): ?>
                        <?php $dppSums['p' . $productMasterCategoryItem->id] = '0.00'; ?>
                    <?php endif; ?>
                    <?php $dppSums['p' . $productMasterCategoryItem->id] += $dpp; ?>
                <?php endforeach; ?>
                <?php foreach ($serviceCategoryList as $serviceCategoryItem): ?>
                    <?php $key = 'Individual|' . $year . '-' . $month . '-' . $day . '|s|' . $serviceCategoryItem->id; ?>
                    <?php $dpp = isset($saleReportData[$key]) ? $saleReportData[$key] : ''; ?>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dpp)); ?></td>
                    <?php $dppSum += $dpp; ?>
                    <?php if (!isset($dppSums['s' . $serviceCategoryItem->id])): ?>
                        <?php $dppSums['s' . $serviceCategoryItem->id] = '0.00'; ?>
                    <?php endif; ?>
                    <?php $dppSums['s' . $serviceCategoryItem->id] += $dpp; ?>
                <?php endforeach; ?>
                <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dppSum)); ?></td>
                <?php $key = 'Individual|' . $year . '-' . $month . '-' . $day; ?>
                <?php $ppnTotal = isset($saleReportSummaryData[$key]['ppn_total']) ? $saleReportSummaryData[$key]['ppn_total'] : ''; ?>
                <?php $pphTotal = isset($saleReportSummaryData[$key]['pph_total']) ? $saleReportSummaryData[$key]['pph_total'] : ''; ?>
                <?php $totalPrice = isset($saleReportSummaryData[$key]['total_price']) ? $saleReportSummaryData[$key]['total_price'] : ''; ?>
                <?php $totalProduct = isset($saleReportSummaryData[$key]['total_product']) ? $saleReportSummaryData[$key]['total_product'] : ''; ?>
                <?php $totalService = isset($saleReportSummaryData[$key]['total_service']) ? $saleReportSummaryData[$key]['total_service'] : ''; ?>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $ppnTotal)); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $pphTotal)); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalPrice)); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalProduct)); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalService)); ?></td>
                <?php $ppnTotalSum += $ppnTotal; ?>
                <?php $pphTotalSum += $pphTotal; ?>
                <?php $totalPriceSum += $totalPrice; ?>
                <?php $totalProductSum += $totalProduct; ?>
                <?php $totalServiceSum += $totalService; ?>
            </tr>
        <?php endfor; ?>
        <tr>
            <td></td>
            <?php $dppSumTotal = '0.00'; ?>
            <?php foreach ($productMasterCategoryList as $productMasterCategoryItem): ?>
                <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dppSums['p' . $productMasterCategoryItem->id])); ?></td>
                <?php $dppSumTotal += $dppSums['p' . $productMasterCategoryItem->id]; ?>
            <?php endforeach; ?>
            <?php foreach ($serviceCategoryList as $serviceCategoryItem): ?>
                <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dppSums['s' . $serviceCategoryItem->id])); ?></td>
                <?php $dppSumTotal += $dppSums['s' . $serviceCategoryItem->id]; ?>
            <?php endforeach; ?>
            <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dppSumTotal)); ?></td>
            <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $ppnTotalSum)); ?></td>
            <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $pphTotalSum)); ?></td>
            <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalPriceSum)); ?></td>
            <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalProductSum)); ?></td>
            <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalServiceSum)); ?></td>
        </tr>
    </table>
    
    <hr />
    
    <h2>Penjualan PT</h2>
    
    <table class="report" style="width: 150%">
        <tr id="header1">
            <th>Tanggal</th>
            <?php foreach ($productMasterCategoryList as $productMasterCategoryItem): ?>
                <th><?php echo CHtml::encode(CHtml::value($productMasterCategoryItem, 'name')); ?></th>
            <?php endforeach; ?>
            <?php foreach ($serviceCategoryList as $serviceCategoryItem): ?>
                <th><?php echo CHtml::encode(CHtml::value($serviceCategoryItem, 'name')); ?></th>
            <?php endforeach; ?>
            <th>DPP</th>
            <th>PPn</th>
            <th>PPh</th>
            <th>Total</th>
            <th>Qty Product</th>
            <th>Qty Service</th>
        </tr>
        <?php $dppSums = array(); ?>
        <?php $ppnTotalSum = '0.00'; ?>
        <?php $pphTotalSum = '0.00'; ?>
        <?php $totalPriceSum = '0.00'; ?>
        <?php $totalProductSum = '0.00'; ?>
        <?php $totalServiceSum = '0.00'; ?>
        <?php for ($n = 1; $n <= $numberOfDays; $n++): ?>
            <?php $day = str_pad($n, 2, '0', STR_PAD_LEFT); ?>
            <tr>
                <td style="text-align: center"><?php echo $n; ?></td>
                <?php $dppSum = '0.00'; ?>
                <?php foreach ($productMasterCategoryList as $productMasterCategoryItem): ?>
                    <?php $key = 'Company|' . $year . '-' . $month . '-' . $day . '|p|' . $productMasterCategoryItem->id; ?>
                    <?php $dpp = isset($saleReportData[$key]) ? $saleReportData[$key] : ''; ?>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dpp)); ?></td>
                    <?php $dppSum += $dpp; ?>
                    <?php if (!isset($dppSums['p' . $productMasterCategoryItem->id])): ?>
                        <?php $dppSums['p' . $productMasterCategoryItem->id] = '0.00'; ?>
                    <?php endif; ?>
                    <?php $dppSums['p' . $productMasterCategoryItem->id] += $dpp; ?>
                <?php endforeach; ?>
                <?php foreach ($serviceCategoryList as $serviceCategoryItem): ?>
                    <?php $key = 'Company|' . $year . '-' . $month . '-' . $day . '|s|' . $serviceCategoryItem->id; ?>
                    <?php $dpp = isset($saleReportData[$key]) ? $saleReportData[$key] : ''; ?>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dpp)); ?></td>
                    <?php $dppSum += $dpp; ?>
                    <?php if (!isset($dppSums['s' . $serviceCategoryItem->id])): ?>
                        <?php $dppSums['s' . $serviceCategoryItem->id] = '0.00'; ?>
                    <?php endif; ?>
                    <?php $dppSums['s' . $serviceCategoryItem->id] += $dpp; ?>
                <?php endforeach; ?>
                <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dppSum)); ?></td>
                <?php $key = 'Company|' . $year . '-' . $month . '-' . $day; ?>
                <?php $ppnTotal = isset($saleReportSummaryData[$key]['ppn_total']) ? $saleReportSummaryData[$key]['ppn_total'] : ''; ?>
                <?php $pphTotal = isset($saleReportSummaryData[$key]['pph_total']) ? $saleReportSummaryData[$key]['pph_total'] : ''; ?>
                <?php $totalPrice = isset($saleReportSummaryData[$key]['total_price']) ? $saleReportSummaryData[$key]['total_price'] : ''; ?>
                <?php $totalProduct = isset($saleReportSummaryData[$key]['total_product']) ? $saleReportSummaryData[$key]['total_product'] : ''; ?>
                <?php $totalService = isset($saleReportSummaryData[$key]['total_service']) ? $saleReportSummaryData[$key]['total_service'] : ''; ?>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $ppnTotal)); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $pphTotal)); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalPrice)); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalProduct)); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalService)); ?></td>
                <?php $ppnTotalSum += $ppnTotal; ?>
                <?php $pphTotalSum += $pphTotal; ?>
                <?php $totalPriceSum += $totalPrice; ?>
                <?php $totalProductSum += $totalProduct; ?>
                <?php $totalServiceSum += $totalService; ?>
            </tr>
        <?php endfor; ?>
        <tr>
            <td></td>
            <?php $dppSumTotal = '0.00'; ?>
            <?php foreach ($productMasterCategoryList as $productMasterCategoryItem): ?>
                <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dppSums['p' . $productMasterCategoryItem->id])); ?></td>
                <?php $dppSumTotal += $dppSums['p' . $productMasterCategoryItem->id]; ?>
            <?php endforeach; ?>
            <?php foreach ($serviceCategoryList as $serviceCategoryItem): ?>
                <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dppSums['s' . $serviceCategoryItem->id])); ?></td>
                <?php $dppSumTotal += $dppSums['s' . $serviceCategoryItem->id]; ?>
            <?php endforeach; ?>
            <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dppSumTotal)); ?></td>
            <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $ppnTotalSum)); ?></td>
            <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $pphTotalSum)); ?></td>
            <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalPriceSum)); ?></td>
            <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalProductSum)); ?></td>
            <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalServiceSum)); ?></td>
        </tr>
    </table>
</div>