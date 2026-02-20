<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 25% }
    .width1-2 { width: 15% }
    .width1-3 { width: 15% }
    .width1-3 { width: 15% }
    .width1-4 { width: 15% }
    .width1-5 { width: 15% }

    .width2-1 { width: 10% }
    .width2-2 { width: 10% }
    .width2-3 { width: 5% }
    .width2-4 { width: 25% }
    .width2-5 { width: 10% }
    .width2-6 { width: 10% }
    .width2-7 { width: 10% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Salesman Performance</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">Name</th>
            <th class="width1-2">ID Card #</th>
            <th class="width1-3">Divisi</th>
            <th class="width1-4">Position</th>
            <th class="width1-5">Level</th>
        </tr>
        <tr id="header2">
            <td colspan="5">
                <table>
                    <tr>
                        <th class="width2-1">SO #</th>
                        <th class="width2-2">Tanggal</th>
                        <th class="width2-3">Type</th>
                        <th class="width2-4">Customer</th>
                        <th class="width2-5">Vehicle</th>
                        <th class="width2-6">Total</th>
                        <th class="width2-7">Status</th>
                    </tr>
                </table>
            </td>
        </tr>
    </thead>
    <tbody>
        <?php $grandTotalSale = 0; ?>
        <?php foreach ($salesmanPerformanceSummary->dataProvider->data as $header): ?>
            <tr class="items1">
                <td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'name')); ?></td>
                <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'id_card')); ?></td>
                <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'division.name')); ?></td>
                <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'position.name')); ?></td>
                <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'level.name')); ?></td>
            </tr>
            <tr class="items2">
                <td colspan="5">
                    <table>
                        <?php $totalSale = 0.00; ?>
                        <?php $salesmanPerformanceReportData = $header->getSalesmanPerformanceReport($startDate, $endDate); ?>
                        <?php if (!empty($salesmanPerformanceReportData)): ?>
                            <?php foreach ($salesmanPerformanceReportData as $salesmanPerformanceReportRow): ?>
                                <?php $totalPrice = $salesmanPerformanceReportRow['total_price']; ?>
                                <tr>
                                    <td class="width2-1">
                                        <?php echo CHtml::link($salesmanPerformanceReportRow['invoice_number'], Yii::app()->createUrl("transaction/invoiceHeader/view", array("id" => $salesmanPerformanceReportRow['id'])), array('target' => '_blank')); ?>
                                    </td>
                                    <td class="width2-2">
                                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($salesmanPerformanceReportRow['invoice_date']))); ?>
                                    </td>
                                    <td class="width2-3">
                                        <?php echo CHtml::encode($salesmanPerformanceReportRow['repair_type']); ?>
                                    </td>
                                    <td class="width2-4" style="text-align: right">
                                        <?php echo CHtml::encode($salesmanPerformanceReportRow['customer']); ?>
                                    </td>
                                    <td class="width2-5" style="text-align: right">
                                        <?php echo CHtml::encode($salesmanPerformanceReportRow['vehicle']); ?>
                                    </td>
                                    <td class="width2-6" style="text-align: right">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPrice)); ?>
                                    </td>
                                    <td class="width2-7" style="text-align: right">
                                        <?php echo CHtml::encode($salesmanPerformanceReportRow['status']); ?>
                                    </td>
                                </tr>
                                <?php $totalSale += $totalPrice; ?>
                            <?php endforeach; ?>
                            <tr>
                                <td style="text-align: right; font-weight: bold" colspan="5">Total</td>
                                <td style="text-align: right; font-weight: bold">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalSale)); ?>
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                            <?php $grandTotalSale += $totalSale; ?>
                        <?php endif; ?>
                    </table>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td style="text-align: right; font-weight: bold" colspan="4">Total Penjualan</td>
            <td style="text-align: right; font-weight: bold">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotalSale)); ?>
            </td>
        </tr>
    </tfoot>
</table>