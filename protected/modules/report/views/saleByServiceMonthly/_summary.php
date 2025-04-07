<div class="grid-view">
    <table class="report" style="table-layout: fixed; width: 2000px">
        <tr id="header1">
            <th style="width: 80px">Tanggal</th>
            <?php foreach ($serviceList as $serviceItem): ?>
                <th style="width: 220px; overflow: hidden" colspan="2"><?php echo CHtml::encode(CHtml::value($serviceItem, 'name')); ?></th>
            <?php endforeach; ?>
        </tr>
        <tr id="header1">
            <th></th>
            <?php foreach ($serviceList as $serviceItem): ?>
                <th style="width: 120px">Amount</th>
                <th style="width: 120px">Qty</th>
            <?php endforeach; ?>
        </tr>
        <?php $dppSums = array(); ?>
        <?php $quantitySums = array(); ?>
        <?php $totalPriceSum = '0.00'; ?>
        <?php $totalServiceSum = '0.00'; ?>
        <?php for ($n = 1; $n <= $numberOfDays; $n++): ?>
            <?php $day = str_pad($n, 2, '0', STR_PAD_LEFT); ?>
            <tr>
                <td style="text-align: center"><?php echo $n; ?></td>
                <?php $dppServiceSum = '0.00'; ?>
                <?php $dppSum = '0.00'; ?>
                <?php foreach ($serviceList as $serviceItem): ?>
                    <?php $key = $year . '-' . $month . '-' . $day . '|s|' . $serviceItem->id; ?>
                    <?php $dpp = isset($salePriceReportData[$key]) ? $salePriceReportData[$key] : ''; ?>
                    <?php $quantity = isset($saleQuantityReportData[$key]) ? $saleQuantityReportData[$key] : ''; ?>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $dpp)); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $quantity)); ?></td>
                    <?php $dppServiceSum += $dpp; ?>
                    <?php $dppSum += $dpp; ?>
                    <?php if (!isset($dppSums['s' . $serviceItem->id])): ?>
                        <?php $dppSums['s' . $serviceItem->id] = '0.00'; ?>
                    <?php endif; ?>
                    <?php $dppSums['s' . $serviceItem->id] += $dpp; ?>
                    <?php if (!isset($quantitySums['s' . $serviceItem->id])): ?>
                        <?php $quantitySums['s' . $serviceItem->id] = '0.00'; ?>
                    <?php endif; ?>
                    <?php $quantitySums['s' . $serviceItem->id] += $quantity; ?>
                <?php endforeach; ?>
                <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $dppServiceSum)); ?></td>
                <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $dppSum)); ?></td>
                <?php $key = $year . '-' . $month . '-' . $day; ?>
                <?php $totalPrice = isset($saleReportSummaryAllData[$key]['total_price']) ? $saleReportSummaryAllData[$key]['total_price'] : ''; ?>
                <?php $totalService = isset($saleReportSummaryAllData[$key]['total_service']) ? $saleReportSummaryAllData[$key]['total_service'] : ''; ?>
                <?php $totalPriceSum += $totalPrice; ?>
                <?php $totalServiceSum += $totalService; ?>
            </tr>
        <?php endfor; ?>
        <tr>
            <td></td>
            <?php foreach ($serviceList as $serviceItem): ?>
                <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $dppSums['s' . $serviceItem->id])); ?></td>
                <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $quantitySums['s' . $serviceItem->id])); ?></td>
            <?php endforeach; ?>
        </tr>
    </table>
</div>