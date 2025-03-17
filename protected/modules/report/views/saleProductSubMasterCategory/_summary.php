<div style="font-weight: bold; text-align: center">
    <?php $branch = Branch::model()->findByPk($branchId); ?>
    <div style="font-size: larger">Raperind Motor <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?></div>
    <div style="font-size: larger">Laporan Penjualan Sub Category</div>
    <div><?php echo $monthList[$month] . ' ' . $year; ?></div>
</div>

<br />

<div class="grid-view">
    <table class="report" style="width: 150%">
        <tr id="header1">
            <th>Tanggal</th>
            <?php foreach ($productSubMasterCategoryList as $productSubMasterCategoryItem): ?>
                <th><?php echo CHtml::encode(CHtml::value($productSubMasterCategoryItem, 'name')); ?></th>
            <?php endforeach; ?>
            <th>DPP</th>
            <th>Disc</th>
            <th>PPn</th>
            <th>Qty</th>
        </tr>
        <?php $dppSums = array(); ?>
        <?php $discountTotalSum = '0.00'; ?>
        <?php $ppnTotalSum = '0.00'; ?>
        <?php $totalPriceSum = '0.00'; ?>
        <?php $totalProductSum = '0.00'; ?>
        <?php for ($n = 1; $n <= $numberOfDays; $n++): ?>
            <?php $day = str_pad($n, 2, '0', STR_PAD_LEFT); ?>
            <tr>
                <td style="text-align: center"><?php echo $n; ?></td>
                <?php $dppProductSum = '0.00'; ?>
                <?php $dppSum = '0.00'; ?>
                <?php foreach ($productSubMasterCategoryList as $productSubMasterCategoryItem): ?>
                    <?php $key = $year . '-' . $month . '-' . $day . '|p|' . $productSubMasterCategoryItem->id; ?>
                    <?php $dpp = isset($saleReportAllData[$key]) ? $saleReportAllData[$key] : ''; ?>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dpp)); ?></td>
                    <?php $dppProductSum += $dpp; ?>
                    <?php $dppSum += $dpp; ?>
                    <?php if (!isset($dppSums['p' . $productSubMasterCategoryItem->id])): ?>
                        <?php $dppSums['p' . $productSubMasterCategoryItem->id] = '0.00'; ?>
                    <?php endif; ?>
                    <?php $dppSums['p' . $productSubMasterCategoryItem->id] += $dpp; ?>
                <?php endforeach; ?>
                <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dppProductSum)); ?></td>
                <?php $key = $year . '-' . $month . '-' . $day; ?>
                <?php $discountTotal = isset($saleReportSummaryAllData[$key]['total_discount']) ? $saleReportSummaryAllData[$key]['total_discount'] : ''; ?>
                <?php $ppnTotal = isset($saleReportSummaryAllData[$key]['ppn_total']) ? $saleReportSummaryAllData[$key]['ppn_total'] : ''; ?>
                <?php $totalPrice = isset($saleReportSummaryAllData[$key]['total_price']) ? $saleReportSummaryAllData[$key]['total_price'] : ''; ?>
                <?php $totalProduct = isset($saleReportSummaryAllData[$key]['total_product']) ? $saleReportSummaryAllData[$key]['total_product'] : ''; ?>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $discountTotal)); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $ppnTotal)); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalProduct)); ?></td>
                <?php $discountTotalSum += $discountTotal; ?>
                <?php $ppnTotalSum += $ppnTotal; ?>
                <?php $totalPriceSum += $totalPrice; ?>
                <?php $totalProductSum += $totalProduct; ?>
            </tr>
        <?php endfor; ?>
        <tr>
            <td></td>
            <?php $dppProductSumTotal = '0.00'; ?>
            <?php foreach ($productSubMasterCategoryList as $productSubMasterCategoryItem): ?>
                <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dppSums['p' . $productSubMasterCategoryItem->id])); ?></td>
                <?php $dppProductSumTotal += $dppSums['p' . $productSubMasterCategoryItem->id]; ?>
            <?php endforeach; ?>
            <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dppProductSumTotal)); ?></td>
            <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $discountTotalSum)); ?></td>
            <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $ppnTotalSum)); ?></td>
            <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalProductSum)); ?></td>
        </tr>
    </table>
</div>