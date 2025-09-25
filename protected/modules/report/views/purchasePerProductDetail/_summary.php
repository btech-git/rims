<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 20% }
    .width1-2 { width: 15% }
    .width1-3 { width: 30% }
    .width1-4 { width: 35% }
    
    .width2-1 { width: 15% }
    .width2-2 { width: 15% }
    .width2-3 { width: 25% }
    .width2-4 { width: 5% }
    .width2-5 { width: 10% }
    .width2-6 { width: 10% }
    .width2-7 { width: 10% }
    .width2-8 { width: 10% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Laporan Pembelian per Barang</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">Product Name</th>
            <th class="width1-2">Code</th>
            <th class="width1-3">Brand</th>
            <th class="width1-4">Category</th>
        </tr>
        <tr id="header2">
            <td colspan="4">
                <table>
                    <tr>
                        <th class="width2-1">PO #</th>
                        <th class="width2-2">Tanggal</th>
                        <th class="width2-3">Supplier</th>
                        <th class="width2-4">Quantity</th>
                        <th class="width2-5">Retail Price</th>
                        <th class="width2-6">Discount</th>
                        <th class="width2-7">Unit Price</th>
                        <th class="width2-8">Total</th>
                    </tr>
                </table>
            </td>
        </tr>
    </thead>
    <tbody>
        <?php $grandTotalPurchase = 0.00; ?>
        <?php foreach ($purchasePerProductSummary->dataProvider->data as $header): ?>
                <tr class="items1">
                    <td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'name')); ?></td>
                    <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'manufacturer_code')); ?></td>
                    <td class="width1-3">
                        <?php echo CHtml::encode(CHtml::value($header, 'brand.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($header, 'subBrand.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($header, 'subBrandSeries.name')); ?>
                    </td>
                    <td class="width1-4">
                        <?php echo CHtml::encode(CHtml::value($header, 'productMasterCategory.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($header, 'productSubMasterCategory.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($header, 'productSubCategory.name')); ?>
                    </td>
                </tr>

                <tr class="items2">
                    <td colspan="4">
                        <table>
                            <?php $totalPurchase = '0.00'; ?>
                            <?php $totalQuantity = '0.00'; ?>
                            <?php $purchaseOrderData = $header->getPurchasePerProductReport($startDate, $endDate, $branchId, $supplierId); ?>
                            <?php if (!empty($purchaseOrderData)): ?>
                                <?php foreach ($purchaseOrderData as $purchaseOrderItem): ?>
                                    <?php $totalPrice = $purchaseOrderItem['total_price']; ?>
                                    <?php $quantity = $purchaseOrderItem['quantity']; ?>
                                    <tr>
                                        <td class="width2-1">
                                            <?php echo CHtml::link($purchaseOrderItem['purchase_order_no'], Yii::app()->createUrl("transaction/transactionPurchaseOrder/view", array("id" => $purchaseOrderItem['id'])), array('target' => '_blank')); ?>
                                        </td>
                                        <td class="width2-2">
                                            <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($purchaseOrderItem['purchase_order_date']))); ?>
                                        </td>
                                        <td class="width2-3"><?php echo CHtml::encode($purchaseOrderItem['company']); ?></td>
                                        <td class="width2-4" style="text-align: center">
                                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $quantity)); ?>
                                        </td>
                                        <td class="width2-5" style="text-align: right">
                                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $purchaseOrderItem['retail_price'])); ?>
                                        </td>
                                        <td class="width2-6" style="text-align: right">
                                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $purchaseOrderItem['discount'])); ?>
                                        </td>
                                        <td class="width2-7" style="text-align: right">
                                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $purchaseOrderItem['unit_price'])); ?>
                                        </td>
                                        <td class="width2-8" style="text-align: right">
                                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPrice)); ?>
                                        </td>
                                    </tr>
                                    <?php $totalQuantity += $quantity; ?>
                                    <?php $totalPurchase += $totalPrice; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <tr>
                                <td style="text-align: right; font-weight: bold" colspan="3">Total</td>
                                <td style="text-align: center; font-weight: bold" class="width2-8">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalQuantity)); ?>
                                </td>
                                <td colspan="3"></td>
                                <td style="text-align: right; font-weight: bold" class="width2-8">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPurchase)); ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php $grandTotalPurchase += $totalPurchase; ?>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td style="text-align: right; font-weight: bold" colspan="3">TOTAL PEMBELIAN</td>
            <td style="text-align: right; font-weight: bold" class="width1-8">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotalPurchase)); ?>
            </td>
        </tr>
    </tfoot>
</table>