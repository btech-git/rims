<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 3% }
    .width1-2 { width: 10% }
    .width1-3 { width: 20% }
    .width1-4 { width: 20% }
    .width1-5 { width: 30% }
    .width1-6 { width: 7% }

    .width2-1 { width: 10% }
    .width2-2 { width: 7% }
    .width2-3 { width: 15% }
    .width2-4 { width: 15% }
    .width2-5 { width: 10% }
    .width2-6 { width: 15% }
    .width2-7 { width: 5% }
    .width2-8 { width: 10% }
    .width2-9 { width: 10% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Rincian Penjualan per Barang</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">ID</th>
            <th class="width1-2">Code</th>
            <th class="width1-3">Name</th>
            <th class="width1-4">Brand</th>
            <th class="width1-5">Master Category</th>
            <th class="width1-6">Satuan</th>
        </tr>
        <tr id="header2">
            <td colspan="6">
                <table>
                    <tr>
                        <th class="width2-1">Penjualan #</th>
                        <th class="width2-2">Tanggal</th>
                        <th class="width2-3">Customer</th>
                        <th class="width2-4">Asuransi</th>
                        <th class="width2-5">Plat #</th>
                        <th class="width2-6">Kendaraan</th>
                        <th class="width2-7">Quantity</th>
                        <th class="width2-8">Harga</th>
                        <th class="width2-9">Total</th>
                    </tr>
                </table>
            </td>
        </tr>
    </thead>
    <tbody>
        <?php $grandTotalSale = 0.00; ?>
        <?php foreach ($saleRetailProductSummary->dataProvider->data as $header): ?>
            <tr class="items1">
                <td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'id')); ?></td>
                <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'manufacturer_code')); ?></td>
                <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'name')); ?></td>
                <td class="width1-4">
                    <?php echo CHtml::encode(CHtml::value($header, 'brand.name')); ?> - 
                    <?php echo CHtml::encode(CHtml::value($header, 'subBrand.name')); ?> - 
                    <?php echo CHtml::encode(CHtml::value($header, 'subBrandSeries.name')); ?>
                </td>
                <td class="width1-5">
                    <?php echo CHtml::encode(CHtml::value($header, 'productMasterCategory.name')); ?> - 
                    <?php echo CHtml::encode(CHtml::value($header, 'productSubMasterCategory.name')); ?> - 
                    <?php echo CHtml::encode(CHtml::value($header, 'productSubCategory.name')); ?>
                </td>
                <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'unit.name')); ?></td>
            </tr>
            <tr class="items2">
                <td colspan="6">
                    <table>
                        <?php $saleRetailData = $header->getSaleRetailProductDetailReport($startDate, $endDate, $branchId, $customerType); ?>
                        <?php $totalSale = 0.00; ?>
                        <?php foreach ($saleRetailData as $saleRetailRow): ?>
                            <?php $total = $saleRetailRow['total_price']; ?>
                            <tr>
                                <td class="width2-1"><?php echo CHtml::encode($saleRetailRow['invoice_number']); ?></td>
                                <td class="width2-2">
                                    <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($saleRetailRow['invoice_date']))); ?>
                                </td>
                                <td class="width2-3"><?php echo CHtml::encode($saleRetailRow['customer']); ?></td>
                                <td class="width2-4"><?php echo CHtml::encode($saleRetailRow['insurance']); ?></td>
                                <td class="width2-5"><?php echo CHtml::encode($saleRetailRow['plate_number']); ?></td>
                                <td class="width2-6">
                                    <?php echo CHtml::encode($saleRetailRow['car_make']); ?> - 
                                    <?php echo CHtml::encode($saleRetailRow['car_model']); ?> - 
                                    <?php echo CHtml::encode($saleRetailRow['car_sub_model']); ?>
                                </td>
                                <td class="width2-7" style="text-align: center">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saleRetailRow['quantity'])); ?>
                                </td>
                                <td class="width2-8" style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saleRetailRow['unit_price'])); ?>
                                </td>
                                <td class="width2-9" style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $total)); ?>
                                </td>
                            </tr>
                            <?php $totalSale += $total; ?>
                        <?php endforeach; ?>
                        <tr>
                            <td style="text-align: right; font-weight: bold" colspan="8">Total</td>
                            <td style="text-align: right; font-weight: bold" class="width2-9">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalSale)); ?>
                            </td>
                        </tr>
                        <?php $grandTotalSale += $totalSale; ?>
                    </table>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td style="text-align: right; font-weight: bold" colspan="5">Total</td>
            <td style="text-align: right; font-weight: bold" class="width1-6">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotalSale)); ?>
            </td>
        </tr>
    </tfoot>
</table>