<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 5% }
    .width1-2 { width: 75% }
    .width1-3 { width: 20% }

    .width2-1 { width: 10% }
    .width2-2 { width: 10% }
    .width2-3 { width: 10% }
    .width2-4 { width: 10% }
    .width2-5 { width: 10% }
    .width2-6 { width: 5% }
    .width2-7 { width: 5% }
    .width2-8 { width: 10% }
');
?>

<div style="font-weight: bold; text-align: center">
    <?php $branch = Branch::model()->findByPk($branchId); ?>
    <div style="font-size: larger">Raperind Motor <?php echo CHtml::encode(CHtml::value($branch, 'name'));?></div>
    <div style="font-size: larger">Rincian Penjualan per Pelanggan</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">ID</th>
            <th class="width1-2">Customer</th>
            <th class="width1-3">Type</th>
        </tr>
        <tr id="header2">
            <td colspan="3">
                <table>
                    <tr>
                        <th class="width2-1">Penjualan #</th>
                        <th class="width2-2">Tanggal</th>
                        <th class="width2-3">Vehicle</th>
                        <th class="width2-4">Barang</th>
                        <th class="width2-5">Jasa</th>
                        <th class="width2-6">ppn</th>
                        <th class="width2-7">pph</th>
                        <th class="width2-8">Total</th>
                    </tr>
                </table>
            </td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($customerSaleReport as $i => $dataItem): ?>
            <tr class="items1">
                <td class="width1-1"><?php echo CHtml::encode($dataItem['customer_id']); ?></td>
                <td class="width1-2"><?php echo CHtml::encode($dataItem['customer_name']); ?></td>
                <td class="width1-3"><?php echo CHtml::encode($dataItem['customer_type']); ?></td>
            </tr>
            <tr class="items2">
                <td colspan="3">
                    <table>
                        <?php $totalSale = 0.00; ?>
                        <?php $saleReportData = InvoiceHeader::model()->findAll(array(
                            'condition' => 'customer_id = :customer_id AND invoice_date BETWEEN :start_date AND :end_date', 
                            'params' => array(
                                ':customer_id' => $dataItem['customer_id'],
                                ':start_date' => $startDate,
                                ':end_date' => $endDate,
                            ),
                        )); ?>
                        <?php if (!empty($saleReportData)): ?>
                            <?php foreach ($saleReportData as $saleReportRow): ?>
                                <?php $grandTotal = CHtml::value($saleReportRow, 'total_price'); ?>
                                <tr>
                                    <td class="width2-1">
                                        <?php echo CHtml::link(CHtml::encode(CHtml::value($saleReportRow, 'invoice_number')), Yii::app()->createUrl("transaction/invoiceHeader/view", array("id" => CHtml::encode(CHtml::value($saleReportRow, 'id')))), array('target' => '_blank')); ?>
                                    </td>
                                    <td class="width2-2">
                                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime(CHtml::value($saleReportRow, 'invoice_date')))); ?>
                                    </td>
                                    <td class="width2-3">
                                        <?php echo CHtml::encode(CHtml::value($saleReportRow, 'plate_number')); ?>
                                    </td>
                                    <td class="width2-4" style="text-align: right">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($saleReportRow, 'product_price'))); ?>
                                    </td>
                                    <td class="width2-5" style="text-align: right">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($saleReportRow, 'service_price'))); ?>
                                    </td>
                                    <td class="width2-6" style="text-align: right">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($saleReportRow, 'ppn_total'))); ?>
                                    </td>
                                    <td class="width2-7" style="text-align: right">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($saleReportRow, 'pph_total'))); ?>
                                    </td>
                                    <td class="width2-8" style="text-align: right">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotal)); ?>
                                    </td>
                                </tr>
                                <?php $totalSale += $grandTotal; ?>
                            <?php endforeach; ?>
                            <tr>
                                <td style="text-align: right" colspan="7">Total</td>
                                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalSale)); ?></td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>