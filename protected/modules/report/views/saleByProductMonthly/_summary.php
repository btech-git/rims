<div class="grid-view">
    <table class="report" style="table-layout: fixed; width: 2000px">
        <tr id="header1">
            <th style="width: 80px">Tanggal</th>
            <?php foreach ($productList as $productItem): ?>
                <th style="width: 120px; overflow: hidden" colspan="2"><?php echo CHtml::encode(CHtml::value($productItem, 'name')); ?></th>
            <?php endforeach; ?>
        </tr>
        <tr id="header1">
            <th></th>
            <?php foreach ($productList as $productItem): ?>
                <th style="width: 120px">Amount</th>
                <th style="width: 120px">Qty</th>
            <?php endforeach; ?>
        </tr>
        <?php $dppSums = array(); ?>
        <?php $quantitySums = array(); ?>
        <?php $totalPriceSum = '0.00'; ?>
        <?php $totalProductSum = '0.00'; ?>
        <?php for ($n = 1; $n <= $numberOfDays; $n++): ?>
            <?php $day = str_pad($n, 2, '0', STR_PAD_LEFT); ?>
            <tr>
                <td style="text-align: center"><?php echo $n; ?></td>
                <?php $dppSum = '0.00'; ?>
                <?php $dppProductSum = '0.00'; ?>
                <?php foreach ($productList as $productItem): ?>
                    <?php $key = $year . '-' . $month . '-' . $day . '|p|' . $productItem->id; ?>
                    <?php $dpp = isset($salePriceReportData[$key]) ? $salePriceReportData[$key] : ''; ?>
                    <?php $quantity = isset($saleQuantityReportData[$key]) ? $saleQuantityReportData[$key] : ''; ?>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dpp)); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $quantity)); ?></td>
                    <?php $dppProductSum += $dpp; ?>
                    <?php $dppSum += $dpp; ?>
                    <?php if (!isset($dppSums['p' . $productItem->id])): ?>
                        <?php $dppSums['p' . $productItem->id] = '0.00'; ?>
                    <?php endif; ?>
                    <?php $dppSums['p' . $productItem->id] += $dpp; ?>
                    <?php if (!isset($quantitySums['p' . $productItem->id])): ?>
                        <?php $quantitySums['p' . $productItem->id] = '0.00'; ?>
                    <?php endif; ?>
                    <?php $quantitySums['p' . $productItem->id] += $quantity; ?>
                <?php endforeach; ?>
                <?php $key = $year . '-' . $month . '-' . $day; ?>
                <?php $totalPrice = isset($saleReportSummaryAllData[$key]['total_price']) ? $saleReportSummaryAllData[$key]['total_price'] : ''; ?>
                <?php $totalProduct = isset($saleReportSummaryAllData[$key]['total_product']) ? $saleReportSummaryAllData[$key]['total_product'] : ''; ?>
                <?php $totalPriceSum += $totalPrice; ?>
                <?php $totalProductSum += $totalProduct; ?>
            </tr>
        <?php endfor; ?>
        <tr>
            <td></td>
            <?php $dppProductSumTotal = '0.00'; ?>
            <?php $dppSumTotal = '0.00'; ?>
            <?php foreach ($productList as $productItem): ?>
                <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dppSums['p' . $productItem->id])); ?></td>
                <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $quantitySums['p' . $productItem->id])); ?></td>
                <?php $dppProductSumTotal += $dppSums['p' . $productItem->id]; ?>
                <?php $dppSumTotal += $dppSums['p' . $productItem->id]; ?>
            <?php endforeach; ?>
        </tr>
    </table>
</div>