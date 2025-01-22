<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 100% }

    .width2-1 { width: 10% }
    .width2-2 { width: 10% }
    .width2-3 { width: 30% }
    .width2-4 { width: 10% }
    .width2-5 { width: 10% }
    .width2-6 { width: 5% }
    .width2-7 { width: 5% }
    .width2-8 { width: 10% }
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
            <th class="width1-1" style="text-align: center">ID - Name</th>
        </tr>
        <tr id="header2">
            <td>
                <table>
                    <tr>
                        <th class="width2-1">Penjualan #</th>
                        <th class="width2-2">Tanggal</th>
                        <th class="width2-3">Customer</th>
                        <th class="width2-4">Barang</th>
                        <th class="width2-5">Disc Barang</th>
                        <th class="width2-5">Jasa</th>
                        <th class="width2-5">Disc Jasa</th>
                        <th class="width2-6">PPn</th>
                        <th class="width2-7">PPh</th>
                        <th class="width2-8">Total</th>
                    </tr>
                </table>
            </td>
        </tr>
    </thead>
    <tbody>
        <?php $grandTotalSale = 0.00; ?>
        <?php foreach ($saleVehicleProductSummary->dataProvider->data as $header): ?>
            <tr class="items1">
                <td class="width1-1" style="text-align: center">
                    <?php echo CHtml::encode(CHtml::value($header, 'id')); ?> - 
                    <?php echo CHtml::encode(CHtml::value($header, 'name')); ?>
                </td>
            </tr>
            <tr class="items2">
                <td>
                    <table>
                        <?php $totalSale = 0.00; ?>
                        <?php $saleRetailVehicleData = $header->getSaleVehicleReport($startDate, $endDate, $branchId); ?>
                        <?php foreach ($saleRetailVehicleData as $saleRetailVehicleRow): ?>
                        <?php $invoiceHeader = InvoiceHeader::model()->findByPk($saleRetailVehicleRow['id']); ?>
                        <?php $discountProduct = $invoiceHeader->getTotalDiscountProduct(); ?>
                        <?php $discountService = $invoiceHeader->getTotalDiscountService(); ?>
                            <?php $grandTotal = $saleRetailVehicleRow['total_price']; ?>
                            <tr>
                                <td class="width2-1"><?php echo CHtml::encode($saleRetailVehicleRow['invoice_number']); ?></td>
                                <td class="width2-2">
                                    <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($saleRetailVehicleRow['invoice_date']))); ?>
                                </td>
                                <td class="width2-3">
                                    <?php echo CHtml::encode($saleRetailVehicleRow['customer']); ?>
                                </td>
                                <td class="width2-4" style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saleRetailVehicleRow['product_price'])); ?>
                                </td>
                                <td class="width2-5" style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $discountProduct)); ?>
                                </td>
                                <td class="width2-5" style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saleRetailVehicleRow['service_price'])); ?>
                                </td>
                                <td class="width2-5" style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $discountService)); ?>
                                </td>
                                <td class="width2-6" style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saleRetailVehicleRow['ppn_total'])); ?>
                                </td>
                                <td class="width2-7" style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saleRetailVehicleRow['pph_total'])); ?>
                                </td>
                                <td class="width2-8" style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotal)); ?>
                                </td>
                            </tr>
                            <?php $totalSale += $grandTotal; ?>
                        <?php endforeach; ?>
                        <tr>
                            <td style="text-align: right; font-weight: bold" colspan="9">Total</td>
                            <td style="text-align: right; font-weight: bold">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalSale)); ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <?php $grandTotalSale += $totalSale; ?>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
    <tr>
        <td style="text-align: right; font-weight: bold">
            Total: 
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotalSale)); ?>
        </td>
    </tr>
    </tfoot>
</table>