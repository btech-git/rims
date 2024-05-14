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
            <th class="width1-4">Sub Brand</th>
            <th class="width1-5">Sub Brand Series</th>
            <th class="width1-6">Category</th>
            <th class="width1-7">Sub Master Category</th>
            <th class="width1-8">Sub Category</th>
        </tr>
        <tr id="header2">
            <td colspan="8">
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
                </tr>

                <tr class="items2">
                    <td colspan="8">
                        <table>
                            <?php $totalPurchase = 0.00; ?>
                            <?php 
                                $purchaseOrderDetailCriteria = new CDbCriteria;
                                $purchaseOrderDetailCriteria->join = 'INNER JOIN rims_transaction_purchase_order po ON po.id = t.purchase_order_id';
                                $purchaseOrderDetailCriteria->addCondition("po.purchase_order_date BETWEEN :start_date AND :end_date AND t.product_id = :product_id");
                                $purchaseOrderDetailCriteria->params = array(
                                    ':start_date' => $startDate,
                                    ':end_date' => $endDate,
                                    ':product_id' => $header->id,
                                );
                            ?>
                            <?php $purchaseDetails = TransactionPurchaseOrderDetail::model()->findAll($purchaseOrderDetailCriteria); ?>
                            <?php foreach ($purchaseDetails as $purchaseDetail): ?>
                                <?php $totalPrice = CHtml::value($purchaseDetail, 'total_price'); ?>
                                <tr>
                                    <td class="width2-1"><?php echo CHtml::link($purchaseDetail->purchaseOrder->purchase_order_no, Yii::app()->createUrl("transaction/transactionPurchaseOrder/view", array("id" => $purchaseDetail->purchase_order_id)), array('target' => '_blank')); ?></td>
                                    <td class="width2-2"><?php echo CHtml::encode(CHtml::value($purchaseDetail, 'purchaseOrder.purchase_order_date')); ?></td>
                                    <td class="width2-3"><?php echo CHtml::encode(CHtml::value($purchaseDetail, 'purchaseOrder.supplier.name')); ?></td>
                                    <td class="width2-4" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($purchaseDetail, 'quantity'))); ?></td>
                                    <td class="width2-5" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($purchaseDetail, 'retail_price'))); ?></td>
                                    <td class="width2-6" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($purchaseDetail, 'discount'))); ?></td>
                                    <td class="width2-7" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($purchaseDetail, 'unit_price'))); ?></td>
                                    <td class="width2-8" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPrice)); ?></td>
                                </tr>

                                <?php $totalPurchase += $totalPrice; ?>
                            <?php endforeach; ?>
                            <tr>
                                <td style="text-align: right; font-weight: bold" colspan="7">Total</td>
                                <td style="text-align: right; font-weight: bold" class="width2-8">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPurchase)); ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php $grandTotalPurchase += $totalPurchase; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td style="text-align: right; font-weight: bold" colspan="7">Total</td>
            <td style="text-align: right; font-weight: bold" class="width1-9">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotalPurchase)); ?>
            </td>
        </tr>
    </tfoot>
</table>