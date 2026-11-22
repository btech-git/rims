<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 3% }
    .width1-2 { width: 10% }
    .width1-3 { width: 20% }
    .width1-4 { width: 20% }
    .width1-5 { width: 30% }
    .width1-6 { width: 7% }
    .width1-7 { width: 10% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Raperind Motor</div>
    <div style="font-size: larger">Pembelian per Parts Summary</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">ID</th>
            <th class="width1-2">Code</th>
            <th class="width1-3">Name</th>
            <th class="width1-4">Brand</th>
            <th class="width1-5">Category</th>
            <th class="width1-6">Quantity</th>
            <th class="width1-7">Total</th>
        </tr>
    </thead>
    <tbody>
        <?php $totalPurchase = '0.00'; ?>
        <?php $totalQuantity = 0; ?>
        
        <?php foreach ($purchasePerProductSummary->dataProvider->data as $header): ?>
            <?php $purchasePrice = $header->getPurchasePriceReport($startDate, $endDate, $branchId); ?>
            <?php $purchaseQuantity = $header->getTotalQuantityPurchase($startDate, $endDate, $branchId); ?>
        
                <tr class="items1">
                    <td><?php echo CHtml::encode(CHtml::value($header, 'id')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'manufacturer_code')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'name')); ?></td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($header, 'brand.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($header, 'subBrand.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($header, 'subBrandSeries.name')); ?>
                    </td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($header, 'productMasterCategory.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($header, 'productSubMasterCategory.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($header, 'productSubCategory.name')); ?>
                    </td>
                    <td style="text-align: center;">
                        <?php echo CHtml::link(Yii::app()->numberFormatter->format('#,##0', $purchaseQuantity), Yii::app()->createUrl("report/purchasePerProduct/transactionInfo", array(
                            "productId" => $header->id,
                            "startDate" => $startDate,
                            "endDate" => $endDate,
                        )), array('target' => '_blank'));?>
                    </td>
                    <td style="text-align: right;">
                        <?php echo CHtml::link(Yii::app()->numberFormatter->format('#,##0.00', $purchasePrice), Yii::app()->createUrl("report/purchasePerProduct/transactionInfo", array(
                            "productId" => $header->id,
                            "startDate" => $startDate,
                            "endDate" => $endDate,
                        )), array('target' => '_blank'));?>
                    </td>
                </tr>
                
                <?php $totalQuantity += $purchaseQuantity; ?>
                <?php $totalPurchase += $purchasePrice; ?>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td style="text-align: right; font-weight: bold" colspan="5">Total</td>
            <td style="text-align: center; font-weight: bold">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalQuantity)); ?>
            </td>
            <td style="text-align: right; font-weight: bold">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalPurchase)); ?>
            </td>
        </tr>
    </tfoot>
</table>