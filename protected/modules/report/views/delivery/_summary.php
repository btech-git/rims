<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 15% }
    .width1-2 { width: 10% }
    .width1-3 { width: 10% }
    .width1-4 { width: 30% }
    .width1-5 { width: 10% }
    .width1-6 { width: 10% }
    .width1-7 { width: 5% }
    .width1-8 { width: 10% }

    .width2-1 { width: 50% }
    .width2-2 { width: 10% }
    .width2-3 { width: 10% }
    .width2-4 { width: 10% }
    .width2-5 { width: 20% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">
        <?php $branch = Branch::model()->findByPk($branchId); ?>
        <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?>
    </div>
    <div style="font-size: larger">Laporan Pengiriman Barang</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead>
        <tr id="header1">
            <th class="width1-1">Delivery #</th>
            <th class="width1-2">Tanggal</th>
            <th class="width1-3">Type</th>
            <th class="width1-4">Customer</th>
            <th class="width1-5">Reference #</th>
            <th class="width1-6">ETA</th>
            <th class="width1-7">Tujuan</th>
            <th class="width1-8">Pengirim</th>
        </tr>
        <tr id="header2">
            <td colspan="8">
                <table>
                    <tr>
                        <th class="width2-1">Product</th>
                        <th class="width2-2">Quantity Request</th>
                        <th class="width2-3">Quantity Delivery</th>
                        <th class="width2-4">Quantity Movement</th>
                        <th class="width2-5">Memo</th>
                    </tr>
                </table>
            </td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($deliveryOrderSummary->dataProvider->data as $header): ?>
            <tr class="items1">
                <td class="width1-1">
                    <?php echo CHtml::link(CHtml::encode($header->delivery_order_no), array("/transaction/transactionDeliveryOrder/view", "id"=>$header->id), array("target" => "_blank")); ?>
                </td>
                <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->delivery_date))); ?></td>
                <td class="width1-3"><?php echo CHtml::encode(($header->request_type)); ?></td>
                <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                <td class="width1-5">
                    <?php if (!empty($header->sales_order_id)): ?>
                        <?php echo CHtml::encode(CHtml::value($header, 'saleOrder.sale_order_no')); ?>
                    <?php elseif (!empty($header->sent_request_id)): ?>
                        <?php echo CHtml::encode(CHtml::value($header, 'sentRequest.sent_request_no')); ?>
                    <?php elseif (!empty($header->consignment_out_id)): ?>
                        <?php echo CHtml::encode(CHtml::value($header, 'consignmentOut.consignment_out_no')); ?>
                    <?php elseif (!empty($header->transfer_request_id)): ?>
                        <?php echo CHtml::encode(CHtml::value($header, 'transferRequest.transfer_request_no')); ?>
                    <?php else: ?>
                        <?php echo 'N/A'; ?>
                    <?php endif; ?>
                </td>
                <td class="width1-6"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->estimate_arrival_date))); ?></td>
                <td class="width1-7"><?php echo CHtml::encode(CHtml::value($header, 'destinationBranch.code')); ?></td>
                <td class="width1-8"><?php echo CHtml::encode(CHtml::value($header, 'sender.username')); ?></td>
            </tr>

            <tr class="items2">
                <td colspan="8">
                    <table>
                        <?php $quantityDeliverySum = 0; ?>
                        <?php foreach ($header->transactionDeliveryOrderDetails as $detail): ?>
                            <?php $quantityDelivery = CHtml::value($detail, 'quantity_delivery'); ?>
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
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity_request'))); ?>
                                </td>
                                <td class="width2-3" style="text-align: center">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $quantityDelivery)); ?>
                                </td>
                                <td class="width2-4" style="text-align: center">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity_movement'))); ?>
                                </td>
                                <td class="width2-5" style="text-align: right"><?php echo CHtml::encode(CHtml::value($detail, 'note')); ?></td>
                            </tr>
                            <?php $quantityDeliverySum += $quantityDelivery; ?>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="2">TOTAL: </td>
                            <td style="text-align: center">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $quantityDeliverySum)); ?>
                            </td>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>