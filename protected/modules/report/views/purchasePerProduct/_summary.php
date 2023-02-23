<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 15% }
    .width1-3 { width: 15% }
    .width1-4 { width: 10% }
    .width1-5 { width: 10% }
    .width1-6 { width: 15% }
    .width1-7 { width: 15% }
    .width1-8 { width: 15% }
    .width1-9 { width: 15% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Laporan Pembelian per Barang</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1">Product Name</th>
        <th class="width1-2">Code</th>
        <th class="width1-3">Brand</th>
        <th class="width1-4">Sub Brand</th>
        <th class="width1-5">Sub Brand Series</th>
        <th class="width1-6">Category</th>
        <th class="width1-7">Sub Master Category</th>
        <th class="width1-8">Sub Category</th>
        <th class="width1-9">Price</th>
    </tr>
    <?php $totalPurchase = 0.00; ?>
    <?php foreach ($purchasePerProductSummary->dataProvider->data as $header): ?>
        <?php $purchasePrice = $header->getPurchasePriceReport($startDate, $endDate); ?>
        <?php if ($purchasePrice > 0): ?>
            <tr class="items1">
                <td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'name')); ?></td>
                <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'manufacturer_code')); ?></td>
                <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'brand.name')); ?></td>
                <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'subBrand.name')); ?></td>
                <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'subBrandSeries.name')); ?></td>
                <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'productMasterCategory.name')); ?></td>
                <td class="width1-7"><?php echo CHtml::encode(CHtml::value($header, 'productSubMasterCategory.name')); ?></td>
                <td class="width1-8"><?php echo CHtml::encode(CHtml::value($header, 'productSubCategory.name')); ?></td>
                <td class="width1-9" style="text-align: right;"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $purchasePrice)); ?></td>
            </tr>
            <?php $totalPurchase += $purchasePrice; ?>
        <?php endif; ?>
    <?php endforeach; ?>
    <tr>
        <td style="text-align: right; font-weight: bold" colspan="8">Total</td>
        <td style="text-align: right; font-weight: bold" class="width1-9"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPurchase)); ?></td>
    </tr>
</table>