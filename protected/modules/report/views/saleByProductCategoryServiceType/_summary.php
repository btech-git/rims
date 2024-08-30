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
            <?php foreach ($serviceTypeList as $serviceTypeItem): ?>
                <th><?php echo CHtml::encode(CHtml::value($serviceTypeItem, 'name')); ?></th>
            <?php endforeach; ?>
            <th>Total</th>
        </tr>
        <?php $totalPriceSums = array(); ?>
        <?php for ($n = 1; $n <= $numberOfDays; $n++): ?>
            <?php $day = str_pad($n, 2, '0', STR_PAD_LEFT); ?>
            <tr>
                <td style="text-align: center"><?php echo $n; ?></td>
                <?php $totalPriceSum = '0.00'; ?>
                <?php foreach ($productMasterCategoryList as $productMasterCategoryItem): ?>
                    <?php $key = 'Individual|' . $year . '-' . $month . '-' . $day . '|p|' . $productMasterCategoryItem->id; ?>
                    <?php $totalPrice = isset($saleReportData[$key]) ? $saleReportData[$key] : ''; ?>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($totalPrice))); ?></td>
                    <?php $totalPriceSum += $totalPrice; ?>
                    <?php if (!isset($totalPriceSums[$productMasterCategoryItem->id])): ?>
                        <?php $totalPriceSums[$productMasterCategoryItem->id] = '0.00'; ?>
                    <?php endif; ?>
                    <?php $totalPriceSums[$productMasterCategoryItem->id] += $totalPrice; ?>
                <?php endforeach; ?>
                <?php foreach ($serviceTypeList as $serviceTypeItem): ?>
                    <?php $key = 'Individual|' . $year . '-' . $month . '-' . $day . '|s|' . $serviceTypeItem->id; ?>
                    <?php $totalPrice = isset($saleReportData[$key]) ? $saleReportData[$key] : ''; ?>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($totalPrice))); ?></td>
                    <?php $totalPriceSum += $totalPrice; ?>
                    <?php if (!isset($totalPriceSums[$serviceTypeItem->id])): ?>
                        <?php $totalPriceSums[$serviceTypeItem->id] = '0.00'; ?>
                    <?php endif; ?>
                    <?php $totalPriceSums[$serviceTypeItem->id] += $totalPrice; ?>
                <?php endforeach; ?>
                <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($totalPriceSum))); ?></td>
            </tr>
        <?php endfor; ?>
        <tr>
            <td></td>
            <?php $grandTotalPrice = '0.00'; ?>
            <?php foreach ($productMasterCategoryList as $productMasterCategoryItem): ?>
                <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($totalPriceSums[$productMasterCategoryItem->id]))); ?></td>
                <?php $grandTotalPrice += $totalPriceSums[$productMasterCategoryItem->id]; ?>
            <?php endforeach; ?>
            <?php foreach ($serviceTypeList as $serviceTypeItem): ?>
                <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($totalPriceSums[$serviceTypeItem->id]))); ?></td>
                <?php $grandTotalPrice += $totalPriceSums[$serviceTypeItem->id]; ?>
            <?php endforeach; ?>
            <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($grandTotalPrice))); ?></td>
        </tr>
    </table>
    <hr />
    <h2>Penjualan Wholesale</h2>
    <table class="report" style="width: 150%">
        <tr id="header1">
            <th>Tanggal</th>
            <?php foreach ($productMasterCategoryList as $productMasterCategoryItem): ?>
                <th><?php echo CHtml::encode(CHtml::value($productMasterCategoryItem, 'name')); ?></th>
            <?php endforeach; ?>
            <?php foreach ($serviceTypeList as $serviceTypeItem): ?>
                <th><?php echo CHtml::encode(CHtml::value($serviceTypeItem, 'name')); ?></th>
            <?php endforeach; ?>
            <th>Total</th>
        </tr>
        <?php $totalPriceSums = array(); ?>
        <?php for ($n = 1; $n <= $numberOfDays; $n++): ?>
            <?php $day = str_pad($n, 2, '0', STR_PAD_LEFT); ?>
            <tr>
                <td style="text-align: center"><?php echo $n; ?></td>
                <?php $totalPriceSum = '0.00'; ?>
                <?php foreach ($productMasterCategoryList as $productMasterCategoryItem): ?>
                    <?php $key = 'Company|' . $year . '-' . $month . '-' . $day . '|p|' . $productMasterCategoryItem->id; ?>
                    <?php $totalPrice = isset($saleReportData[$key]) ? $saleReportData[$key] : ''; ?>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($totalPrice))); ?></td>
                    <?php $totalPriceSum += $totalPrice; ?>
                    <?php if (!isset($totalPriceSums[$productMasterCategoryItem->id])): ?>
                        <?php $totalPriceSums[$productMasterCategoryItem->id] = '0.00'; ?>
                    <?php endif; ?>
                    <?php $totalPriceSums[$productMasterCategoryItem->id] += $totalPrice; ?>
                <?php endforeach; ?>
                <?php foreach ($serviceTypeList as $serviceTypeItem): ?>
                    <?php $key = 'Company|' . $year . '-' . $month . '-' . $day . '|s|' . $serviceTypeItem->id; ?>
                    <?php $totalPrice = isset($saleReportData[$key]) ? $saleReportData[$key] : ''; ?>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($totalPrice))); ?></td>
                    <?php $totalPriceSum += $totalPrice; ?>
                    <?php if (!isset($totalPriceSums[$serviceTypeItem->id])): ?>
                        <?php $totalPriceSums[$serviceTypeItem->id] = '0.00'; ?>
                    <?php endif; ?>
                    <?php $totalPriceSums[$serviceTypeItem->id] += $totalPrice; ?>
                <?php endforeach; ?>
                <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($totalPriceSum))); ?></td>
            </tr>
        <?php endfor; ?>
        <tr>
            <td></td>
            <?php $grandTotalPrice = '0.00' ?>
            <?php foreach ($productMasterCategoryList as $productMasterCategoryItem): ?>
                <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($totalPriceSums[$productMasterCategoryItem->id]))); ?></td>
                <?php $grandTotalPrice += $totalPriceSums[$productMasterCategoryItem->id]; ?>
            <?php endforeach; ?>
            <?php foreach ($serviceTypeList as $serviceTypeItem): ?>
                <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($totalPriceSums[$serviceTypeItem->id]))); ?></td>
                <?php $grandTotalPrice += $totalPriceSums[$serviceTypeItem->id]; ?>
            <?php endforeach; ?>
            <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($grandTotalPrice))); ?></td>
        </tr>
    </table>
</div>