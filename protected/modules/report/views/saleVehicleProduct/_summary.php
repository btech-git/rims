<?php
Yii::app()->clientScript->registerCss('_report', '

    .width1-1 { width: 100% }
    
    .width2-1 { width: 10% }
    .width2-2 { width: 5% }
    .width2-3 { width: 20% }
    .width2-4 { width: 5% }
    .width2-5 { width: 10% }
    .width2-6 { width: 10% }
    .width2-7 { width: 10% }
    .width2-8 { width: 10% }
    .width2-9 { width: 10% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Penjualan per Kendaraan</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">Kendaraan</th>
        </tr>
        <tr id="header2">
            <td>
                <table>
                    <tr>
                        <th class="width2-1">Penjualan #</th>
                        <th class="width2-2">Tanggal</th>
                        <th class="width2-3">Customer</th>
                        <th class="width2-4">Plat #</th>
                        <th class="width2-5">Barang</th>
                        <th class="width2-6">Jasa</th>
                        <th class="width2-7">PPn</th>
                        <th class="width2-8">PPh</th>
                        <th class="width2-9">Total</th>
                    </tr>
                </table>
            </td>
        </tr>
    </thead>
    <tbody>
        <?php $totalSale = '0.00'; ?>
        <?php foreach ($saleVehicleProductSummary->dataProvider->data as $carSubModel): ?>
            <tr class="items1">
                <td class="width1-1" style="text-align: center; font-weight: bold">
                    <?php echo CHtml::encode(CHtml::value($carSubModel, 'carMake.name')); ?> -
                    <?php echo CHtml::encode(CHtml::value($carSubModel, 'carModel.name')); ?> -
                    <?php echo CHtml::encode(CHtml::value($carSubModel, 'id')); ?>
                </td>
            </tr>
            <tr class="items2">
                <td>
                    <table>
                        <?php $totalSale = '0.00'; ?>
                        <?php foreach ($saleInvoiceVehicleReportData[$carSubModel->id] as $saleInvoiceVehicleReportItem): ?>
                            <?php $grandTotal = $saleInvoiceVehicleReportItem['total_price']; ?>
                            <tr>
                                <td class="width2-1"><?php echo CHtml::encode($saleInvoiceVehicleReportItem['invoice_number']); ?></td>
                                <td class="width2-2">
                                    <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($saleInvoiceVehicleReportItem['invoice_date']))); ?>
                                </td>
                                <td class="width2-3"><?php echo CHtml::encode($saleInvoiceVehicleReportItem['customer_name']); ?></td>
                                <td class="width2-4"><?php echo CHtml::encode($saleInvoiceVehicleReportItem['plate_number']); ?></td>
                                <td class="width2-5" style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saleInvoiceVehicleReportItem['product_price'])); ?>
                                </td>
                                <td class="width2-6" style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saleInvoiceVehicleReportItem['service_price'])); ?>
                                </td>
                                <td class="width2-7" style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saleInvoiceVehicleReportItem['ppn_total'])); ?>
                                </td>
                                <td class="width2-8" style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saleInvoiceVehicleReportItem['pph_total'])); ?>
                                </td>
                                <td class="width2-9" style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotal)); ?>
                                </td>
                            </tr>
                            <?php $totalSale += $grandTotal; ?>
                        <?php endforeach; ?>
                        <tr>
                            <td style="text-align: right" colspan="8">Total</td>
                            <td class="width2-9" style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalSale)); ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>