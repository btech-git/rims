<?php Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 10% }
    .width1-3 { width: 10% }

'); ?>


<div class="grid-view">
    <table class="report" style="width: 2500px">
        <thead style="position: sticky; top: 0">
            <tr id="header1">
                <th class="width1-1"></th>
                <?php for ($month = 1; $month <= 12; $month++): ?>
                    <th class="width1-2"><?php echo CHtml::encode($monthList[$month]); ?></th>
                <?php endfor; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($yearlyStatistics as $id => $yearlyStatisticsItem): ?>
                <tr class="items1">
                    <td style="text-align: left"><?php echo CHtml::encode($yearlyStatisticsItem['name']); ?></td>
                    <?php for ($month = 1; $month <= 12; $month++): ?>
                        <td style="padding: 16px">
                            <?php if (isset($yearlyStatisticsItem[$month])): ?>
                                <div><strong>Qty Mean:</strong> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $yearlyStatisticsItem[$month]['quantityMean'])); ?></div>
                                <div><strong>Qty Median:</strong> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $yearlyStatisticsItem[$month]['quantityMedian'])); ?></div>
                                <div><strong>Prc Mean:</strong> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $yearlyStatisticsItem[$month]['totalPriceMean'])); ?></div>
                                <div><strong>Prc Median:</strong> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $yearlyStatisticsItem[$month]['totalPriceMedian'])); ?></div>
                            <?php endif; ?>
                        </td>
                    <?php endfor; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>