<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 85% }
    .width1-2 { width: 15% }

    .width2-1 { width: 15% }
    .width2-2 { width: 10% }
    .width2-3 { width: 10% }
    .width2-4 { width: 25% }
    .width2-5 { width: 10% }
    .width2-6 { width: 15% }
    .width2-7 { width: 15% }
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
            <th colspan="2" style="text-align: center">ID - Name</th>
        </tr>
        <tr id="header2">
            <td colspan="2">
                <table>
                    <tr>
                        <th class="width2-1">Penjualan #</th>
                        <th class="width2-2">Tanggal</th>
                        <th class="width2-3">Kode Barang</th>
                        <th class="width2-4">Nama Barang</th>
                        <th class="width2-5">Quantity</th>
                        <th class="width2-6">Harga</th>
                        <th class="width2-7">Total</th>
                    </tr>
                </table>
            </td>
        </tr>
    </thead>
    <tbody>
        <?php $grandTotalSale = 0.00; ?>
        <?php foreach ($saleVehicleProductSummary->dataProvider->data as $header): ?>
            <tr class="items1">
                <td colspan="2" style="text-align: center">
                    <?php echo CHtml::encode(CHtml::value($header, 'id')); ?> - 
                    <?php echo CHtml::encode(CHtml::value($header, 'name')); ?>
                </td>
            </tr>
            <tr class="items2">
                <td colspan="2">
                    <table>
                        <?php $saleRetailProductData = $header->getSaleVehicleProductReport($startDate, $endDate, $branchId); ?>
                        <?php $saleRetailServiceData = $header->getSaleVehicleServiceReport($startDate, $endDate, $branchId); ?>
                        <?php $totalSale = 0.00; ?>
                        <?php foreach ($saleRetailProductData as $saleRetailProductRow): ?>
                            <?php $totalProduct = $saleRetailProductRow['total_price']; ?>
                            <tr>
                                <td class="width2-1"><?php echo CHtml::encode($saleRetailProductRow['invoice_number']); ?></td>
                                <td class="width2-2">
                                    <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($saleRetailProductRow['invoice_date']))); ?>
                                </td>
                                <td class="width2-3"><?php echo CHtml::encode($saleRetailProductRow['code']); ?></td>
                                <td class="width2-4"><?php echo CHtml::encode($saleRetailProductRow['name']); ?></td>
                                <td class="width2-5" style="text-align: center">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saleRetailProductRow['quantity'])); ?>
                                </td>
                                <td class="width2-6" style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saleRetailProductRow['unit_price'])); ?>
                                </td>
                                <td class="width2-7" style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalProduct)); ?>
                                </td>
                            </tr>
                            <?php $totalSale += $totalProduct; ?>
                        <?php endforeach; ?>
                        <?php foreach ($saleRetailServiceData as $saleRetailServiceRow): ?>
                            <?php $totalService = $saleRetailServiceRow['total_price']; ?>
                            <tr>
                                <td class="width2-1"><?php echo CHtml::encode($saleRetailServiceRow['invoice_number']); ?></td>
                                <td class="width2-2">
                                    <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($saleRetailServiceRow['invoice_date']))); ?>
                                </td>
                                <td class="width2-3"><?php echo CHtml::encode($saleRetailServiceRow['code']); ?></td>
                                <td class="width2-4"><?php echo CHtml::encode($saleRetailServiceRow['name']); ?></td>
                                <td class="width2-5" style="text-align: center">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saleRetailServiceRow['quantity'])); ?>
                                </td>
                                <td class="width2-6" style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saleRetailServiceRow['unit_price'])); ?>
                                </td>
                                <td class="width2-7" style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalService)); ?>
                                </td>
                            </tr>
                            <?php $totalSale += $totalService; ?>
                        <?php endforeach; ?>
                        <tr>
                            <td style="text-align: right; font-weight: bold" colspan="6">Total</td>
                            <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalSale)); ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <?php $grandTotalSale += $totalSale; ?>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
    <tr>
        <td style="text-align: right; font-weight: bold; width: 85%">Total</td>
        <td style="text-align: right; font-weight: bold; width: 15%">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotalSale)); ?>
        </td>
    </tr>
    </tfoot>
</table>