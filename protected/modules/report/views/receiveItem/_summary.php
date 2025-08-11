<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 15% }
    .width1-2 { width: 10% }
    .width1-3 { width: 10% }
    .width1-4 { width: 10% }
    .width1-5 { width: 15% }
    .width1-6 { width: 30% }
    .width1-7 { width: 10% }

    .width2-1 { width: 40% }
    .width2-2 { width: 10% }
    .width2-3 { width: 10% }
    .width2-4 { width: 10% }
    .width2-5 { width: 30% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">
        <?php $branch = Branch::model()->findByPk($branchId); ?>
        <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?>
    </div>
    <div style="font-size: larger">Laporan Receive Item</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1">Receive #</th>
        <th class="width1-2">Tanggal</th>
        <th class="width1-3">ETA</th>
        <th class="width1-4">Type</th>
        <th class="width1-5">Reference #</th>
        <th class="width1-6">Supplier</th>
        <th class="width1-7">Tujuan</th>
    </tr>
    <tr id="header2">
        <td colspan="7">
            <table>
                <tr>
                    <th class="width2-1">Product</th>
                    <th class="width2-2">Qty Request</th>
                    <th class="width2-3">Qty Received</th>
                    <th class="width2-4">Qty Movement</th>
                    <th class="width2-5">Memo</th>
                </tr>
            </table>
        </td>
    </tr>
    <?php foreach ($receiveItemSummary->dataProvider->data as $header): ?>
        <tr class="items1">
            <td class="width1-1">
                <?php echo CHtml::link(CHtml::encode($header->receive_item_no), array("/transaction/transactionReceiveItem/view", "id"=>$header->id), array("target" => "_blank")); ?>
            </td>
            <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->receive_item_date))); ?></td>
            <td class="width1-3"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->arrival_date))); ?></td>
            <td class="width1-4"><?php echo CHtml::encode(($header->request_type)); ?></td>
            <td class="width1-5">
                <?php if (!empty($header->purchase_order_id)): ?>
                    <?php echo CHtml::encode(CHtml::value($header, 'purchaseOrder.purchase_order_no')); ?>
                <?php elseif (!empty($header->transfer_request_id)): ?>
                    <?php echo CHtml::encode(CHtml::value($header, 'transferRequest.transfer_request_no')); ?>
                <?php elseif (!empty($header->consignment_in_id)): ?>
                    <?php echo CHtml::encode(CHtml::value($header, 'consignmentIn.consignment_in_no')); ?>
                <?php elseif (!empty($header->delivery_order_id)): ?>
                    <?php echo CHtml::encode(CHtml::value($header, 'deliveryOrder.delivery_order_no')); ?>
                <?php else: ?>
                    <?php echo 'N/A'; ?>
                <?php endif; ?>
            </td>
            <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'supplier.name')); ?></td>
            <td class="width1-7"><?php echo CHtml::encode(CHtml::value($header, 'destinationBranch.name')); ?></td>
        </tr>
        
        <tr class="items2">
            <td colspan="7">
                <table>
                    <?php $quantityReceiveSum = 0; ?>
                    <?php foreach ($header->transactionReceiveItemDetails as $detail): ?>
                        <?php $quantityReceive = CHtml::value($detail, 'qty_received'); ?>
                        <tr>
                            <td class="width2-1">
                                <?php echo CHtml::encode(CHtml::value($detail, 'product.manufacturer_code')); ?> -
                                <?php echo CHtml::encode(CHtml::value($detail, 'product.name')); ?> -
                                <?php echo CHtml::encode(CHtml::value($detail, 'product.brand.name')); ?> -
                                <?php echo CHtml::encode(CHtml::value($detail, 'product.subBrand.name')); ?> -
                                <?php echo CHtml::encode(CHtml::value($detail, 'product.subBrandSeries.name')); ?> -
                                <?php echo CHtml::encode(CHtml::value($detail, 'product.productMasterCategory.name')); ?> -
                                <?php echo CHtml::encode(CHtml::value($detail, 'product.productSubMasterCategory.name')); ?> -
                                <?php echo CHtml::encode(CHtml::value($detail, 'product.productSubCategory.name')); ?>
                            </td>
                            <td class="width2-2" style="text-align: center">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'qty_request'))); ?>
                            </td>
                            <td class="width2-3" style="text-align: center">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $quantityReceive)); ?>
                            </td>
                            <td class="width2-4" style="text-align: center">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity_movement'))); ?>
                            </td>
                            <td class="width2-5"><?php echo CHtml::encode(CHtml::value($detail, 'note')); ?></td>
                        </tr>
                        <?php $quantityReceiveSum += $quantityReceive; ?>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="2">TOTAL: </td>
                        <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $quantityReceiveSum)); ?></td>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
    <?php endforeach; ?>
</table>