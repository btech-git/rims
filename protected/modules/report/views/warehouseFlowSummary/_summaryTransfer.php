<?php Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 3% }
    .width1-2 { width: 10% }
    .width1-3 { width: 10% }
    .width1-4 { width: 27% }
    .width1-5 { width: 10% }
    .width1-6 { width: 10% }
    .width1-7 { width: 10% }
    .width1-8 { width: 10% }
    .width1-9 { width: 10% }
'); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Perpindahan Barang Transfer Request</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">No</th>
            <th class="width1-2">Transfer Request #</th>
            <th class="width1-3">Tanggal</th>
            <th class="width1-4">Pengiriman</th>
            <th class="width1-5">Movement Out</th>
            <th class="width1-6">Penerimaan</th>
            <th class="width1-7">Movement In</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($transferRequestFlowSummary->dataProvider->data as $i => $header): ?>
            <?php $deliveryOrders = $header->transactionDeliveryOrders; ?>
            <?php $deliveryOrderCodeNumbers = array_map(function($deliveryOrder) { return $deliveryOrder->delivery_order_no; }, $deliveryOrders); ?>
            <?php $movementOutHeaders = array_reduce(array_map(function($deliveryOrder) { return $deliveryOrder->movementOutHeaders; }, $deliveryOrders), function($a, $b) { return in_array($b, $a) ? $a : array_merge($a, $b); }, array()); ?>
            <?php $movementOutHeaderCodeNumbers = array_map(function($movementOutHeader) { return $movementOutHeader->movement_out_no; }, $movementOutHeaders); ?>
            <?php $receiveItems = array_reduce(array_map(function($deliveryOrder) { return $deliveryOrder->transactionReceiveItems; }, $deliveryOrders), function($a, $b) { return in_array($b, $a) ? $a : array_merge($a, $b); }, array()); ?>
            <?php $receiveItemCodeNumbers = array_map(function($receiveItem) { return $receiveItem->receive_item_no; }, $receiveItems); ?>
            <?php $movementInHeaders = array_reduce(array_map(function($receiveItem) { return $receiveItem->movementInHeaders; }, $receiveItems), function($a, $b) { return in_array($b, $a) ? $a : array_merge($a, $b); }, array()); ?>
            <?php $movementInHeaderCodeNumbers = array_map(function($movementInHeader) { return $movementInHeader->movement_in_number; }, $movementInHeaders); ?>
            <tr class="items1">
                <td class="width1-1"><?php echo CHtml::encode($i + 1); ?></td>
                <td class="width1-2">
                    <?php echo CHtml::link(CHtml::encode($header->transfer_request_no), array("/transaction/transferRequest/view", "id"=>$header->id), array("target" => "_blank")); ?>
                </td>
                <td class="width1-3">
                    <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->transfer_request_date))); ?>
                </td>
                <td class="width1-4"><?php echo CHtml::encode(implode(', ', $deliveryOrderCodeNumbers)); ?></td>
                <td class="width1-5"><?php echo CHtml::encode(implode(', ', $movementOutHeaderCodeNumbers)); ?></td>
                <td class="width1-6"><?php echo CHtml::encode(implode(', ', $receiveItemCodeNumbers)); ?></td>
                <td class="width1-7"><?php echo CHtml::encode(implode(', ', $movementInHeaderCodeNumbers)); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>