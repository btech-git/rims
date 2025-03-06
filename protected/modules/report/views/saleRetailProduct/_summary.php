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
    .width1-9 { width: 5% }
    .width1-10 { width: 10% }
');
?>

<div style="font-weight: bold; text-align: center">
    <?php $branch = Branch::model()->findByPk($branchId); ?>
    <div style="font-size: larger">Raperind Motor <?php echo CHtml::encode(CHtml::value($branch, 'name'));?></div>
    <div style="font-size: larger">Penjualan per Barang</div>
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
            <th class="width1-5">Sub Brand</th>
            <th class="width1-6">Master Category</th>
            <th class="width1-7">Sub Master Category</th>
            <th class="width1-8">Sub Category</th>
            <th class="width1-9">Quantity</th>
            <th class="width1-10">Total</th>
        </tr>
    </thead>
    <tbody>
        <?php $totalQuantity = '0.00'; ?>
        <?php $totalSale = '0.00'; ?>
        <?php foreach ($saleRetailProductSummary->dataProvider->data as $header): ?>
            <?php $totalQuantitySales = $header->getTotalQuantitySales($startDate, $endDate, $branchId, $customerType); ?>
            <?php $totalAmountSales = $header->getTotalSales($startDate, $endDate, $branchId, $customerType); ?>
            <tr class="items1">
                <td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'id')); ?></td>
                <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'manufacturer_code')); ?></td>
                <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'name')); ?></td>
                <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'brand.name')); ?></td>
                <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'subBrand.name')); ?></td>
                <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'productMasterCategory.name')); ?></td>
                <td class="width1-7"><?php echo CHtml::encode(CHtml::value($header, 'productSubMasterCategory.name')); ?></td>
                <td class="width1-8"><?php echo CHtml::encode(CHtml::value($header, 'productSubCategory.name')); ?></td>
                <td class="width1-9" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalQuantitySales)); ?></td>
                <td class="width1-10" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalAmountSales)); ?></td>
            </tr>
            <?php $totalQuantity += $totalQuantitySales; ?>
            <?php $totalSale += $totalAmountSales; ?>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="8" style="text-align: right; font-weight: bold">Total Sales</td>
            <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalQuantity)); ?></td>
            <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalSale)); ?></td>
        </tr>
    </tfoot>
</table>