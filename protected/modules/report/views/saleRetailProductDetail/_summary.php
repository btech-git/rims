<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 5% }
    .width1-2 { width: 10% }
    .width1-3 { width: 15% }
    .width1-4 { width: 10% }
    .width1-5 { width: 10% }
    .width1-6 { width: 10% }
    .width1-7 { width: 10% }
    .width1-8 { width: 10% }

    .width2-1 { width: 15% }
    .width2-2 { width: 10% }
    .width2-3 { width: 5% }
    .width2-4 { width: 25% }
    .width2-5 { width: 10% }
    .width2-6 { width: 5% }
    .width2-7 { width: 15% }
    .width2-8 { width: 15% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Penjualan Retail Product Detail</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead>
        <tr id="header1">
            <th class="width1-1">ID</th>
            <th class="width1-2">Code</th>
            <th class="width1-3">Name</th>
            <th class="width1-4">Brand</th>
            <th class="width1-5">Sub Brand</th>
            <th class="width1-6">Master Category</th>
            <th class="width1-7">Sub Master Category</th>
            <th class="width1-8">Sub Category</th>
        </tr>
        <tr id="header2">
            <td colspan="8">
                <table>
                    <tr>
                        <th class="width2-1">Penjualan #</th>
                        <th class="width2-2">Tanggal</th>
                        <th class="width2-3">Jenis</th>
                        <th class="width2-4">Customer</th>
                        <th class="width2-5">Vehicle</th>
                        <th class="width2-6">Quantity</th>
                        <th class="width2-7">Harga</th>
                        <th class="width2-8">Total</th>
                    </tr>
                </table>
            </td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($saleRetailProductSummary->dataProvider->data as $header): ?>
            <tr class="items1">
                <td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'id')); ?></td>
                <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'manufacturer_code')); ?></td>
                <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'name')); ?></td>
                <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'brand.name')); ?></td>
                <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'subBrand.name')); ?></td>
                <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'productMasterCategory.name')); ?></td>
                <td class="width1-7"><?php echo CHtml::encode(CHtml::value($header, 'productSubMasterCategory.name')); ?></td>
                <td class="width1-8"><?php echo CHtml::encode(CHtml::value($header, 'productSubCategory.name')); ?></td>
            </tr>
            <tr class="items2">
                <td colspan="8">
                    <table>
                        <?php $saleRetailData = $header->getSaleRetailReport($startDate, $endDate); ?>
                        <?php $totalSale = 0.00; ?>
                        <?php foreach ($saleRetailData as $saleRetailRow): ?>
                            <?php $total = $saleRetailRow['total_price']; ?>
                            <tr>
                                <td class="width2-1"><?php echo CHtml::encode($saleRetailRow['transaction_number']); ?></td>
                                <td class="width2-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($saleRetailRow['transaction_date']))); ?></td>
                                <td class="width2-3"><?php echo CHtml::encode($saleRetailRow['repair_type']); ?></td>
                                <td class="width2-4"><?php echo CHtml::encode($saleRetailRow['customer']); ?></td>
                                <td class="width2-5"><?php echo CHtml::encode($saleRetailRow['vehicle']); ?></td>
                                <td class="width2-6" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saleRetailRow['quantity'])); ?></td>
                                <td class="width2-7" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saleRetailRow['sale_price'])); ?></td>
                                <td class="width2-8" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $total)); ?></td>
                            </tr>
                            <?php $totalSale += $total; ?>
                        <?php endforeach; ?>
                        <tr>
                            <td style="text-align: right" colspan="6">Total</td>
                            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalSale)); ?></td>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>