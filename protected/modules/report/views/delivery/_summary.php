<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 15% }
    .width1-3 { width: 15% }
    .width1-4 { width: 10% }
    .width1-5 { width: 10% }
    .width1-6 { width: 15% }
    .width1-7 { width: 15% }

    .width2-1 { width: 40% }
    .width2-2 { width: 5% }
    .width2-3 { width: 15% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">
        <?php $branch = Branch::model()->findByPk($branchId); ?>
        <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?>
    </div>
    <div style="font-size: larger">Laporan Delivery Order</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1">Delivery #</th>
        <th class="width1-2">Tanggal</th>
        <th class="width1-3">Type</th>
        <th class="width1-4">Customer</th>
        <th class="width1-5">SO #</th>
        <th class="width1-6">Request #</th>
        <th class="width1-7">Consignment #</th>
        <th class="width1-8">Transfer #</th>
        <th class="width1-9">Branch</th>
        <th class="width1-10">Pengirim</th>
    </tr>
    <tr id="header2">
        <td colspan="10">
            <table>
                <tr>
                    <th class="width2-1">Product</th>
                    <th class="width2-2">Quantity</th>
                    <th class="width2-3">Quantity Request</th>
                    <th class="width2-4">Quantity Sisa</th>
                    <th class="width2-5">Memo</th>
                </tr>
            </table>
        </td>
    </tr>
    <?php foreach ($deliveryOrderSummary->dataProvider->data as $header): ?>
        <tr class="items1">
            <td class="width1-1"><?php echo CHtml::encode($header->delivery_order_no); ?></td>
            <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->delivery_date))); ?></td>
            <td class="width1-3"><?php echo CHtml::encode(($header->request_type)); ?></td>
            <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
            <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'saleOrder.sale_order_no')); ?></td>
            <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'sentRequest.sent_request_no')); ?></td>
            <td class="width1-7"><?php echo CHtml::encode(CHtml::value($header, 'consigmentOut.consignment_out_no')); ?></td>
            <td class="width1-8"><?php echo CHtml::encode(CHtml::value($header, 'transferRequest. transfer_request_no')); ?></td>
            <td class="width1-9"><?php echo CHtml::encode(CHtml::value($header, 'branch.name')); ?></td>
            <td class="width1-10"><?php echo CHtml::encode(CHtml::value($header, 'user.username')); ?></td>
        </tr>
        
        <tr class="items2">
            <td colspan="10">
                <table>
                    <?php foreach ($header->transactionDeliveryOrderDetails as $detail): ?>
                        <tr>
                            <td class="width2-1"><?php echo CHtml::encode(CHtml::value($detail, 'product.name')); ?></td>
                            <td class="width2-2" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity_request'))); ?></td>
                            <td class="width2-3" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity_delivery'))); ?></td>
                            <td class="width2-4" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity_request_left'))); ?></td>
                            <td class="width2-5" style="text-align: right"><?php echo CHtml::encode(CHtml::value($detail, 'note')); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="2">TOTAL: </td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'totalQuantity'))); ?></td>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
    <?php endforeach; ?>
</table>