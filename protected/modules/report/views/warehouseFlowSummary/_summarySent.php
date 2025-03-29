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
    <div style="font-size: larger">Perpindahan Barang Sent Request</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">No</th>
            <th class="width1-2">Sent Request #</th>
            <th class="width1-3">Tanggal</th>
            <th class="width1-3">Jam</th>
            <th class="width1-4">Pengiriman</th>
            <th class="width1-3">Tanggal</th>
            <th class="width1-3">Jam</th>
            <th class="width1-5">Movement Out</th>
            <th class="width1-3">Tanggal</th>
            <th class="width1-3">Jam</th>
            <th class="width1-6">Penerimaan</th>
            <th class="width1-3">Tanggal</th>
            <th class="width1-3">Jam</th>
            <th class="width1-7">Movement In</th>
            <th class="width1-3">Tanggal</th>
            <th class="width1-3">Jam</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($sentRequestFlowSummary->dataProvider->data as $i => $header): ?>
            <?php $deliveryOrders = $header->transactionDeliveryOrders; ?>
            <?php $deliveryOrderCodeNumbers = array_map(function($deliveryOrder) { return $deliveryOrder->delivery_order_no; }, $deliveryOrders); ?>
            <?php $deliveryOrderDates = array_map(function($deliveryOrder) { return Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($deliveryOrder->delivery_date)); }, $deliveryOrders); ?>
            <?php $deliveryTimes = array_map(function($deliveryOrder) { return substr($deliveryOrder->created_datetime, -8); }, $deliveryOrders); ?>
            <?php $movementOutHeaders = array_reduce(array_map(function($deliveryOrder) { return $deliveryOrder->movementOutHeaders; }, $deliveryOrders), function($a, $b) { return in_array($b, $a) ? $a : array_merge($a, $b); }, array()); ?>
            <?php $movementOutHeaderCodeNumbers = array_map(function($movementOutHeader) { return $movementOutHeader->movement_out_no; }, $movementOutHeaders); ?>
            <?php $movementOutHeaderDates = array_map(function($movementOutHeader) { return Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($movementOutHeader->date_posting)); }, $movementOutHeaders); ?>
            <?php $movementOutHeaderTimes = array_map(function($movementOutHeader) { return substr($movementOutHeader->date_posting, -8); }, $movementOutHeaders); ?>
            <?php $receiveItems = array_reduce(array_map(function($deliveryOrder) { return $deliveryOrder->transactionReceiveItems; }, $deliveryOrders), function($a, $b) { return in_array($b, $a) ? $a : array_merge($a, $b); }, array()); ?>
            <?php $receiveItemCodeNumbers = array_map(function($receiveItem) { return $receiveItem->receive_item_no; }, $receiveItems); ?>
            <?php $receiveItemDates = array_map(function($receiveItem) { return CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($receiveItem->receive_item_date))); }, $receiveItems); ?>
            <?php $receiveItemTimes = array_map(function($receiveItem) { return CHtml::encode(substr($receiveItem->created_datetime, -8)); }, $receiveItems); ?>
            <?php $movementInHeaders = array_reduce(array_map(function($receiveItem) { return $receiveItem->movementInHeaders; }, $receiveItems), function($a, $b) { return in_array($b, $a) ? $a : array_merge($a, $b); }, array()); ?>
            <?php $movementInHeaderCodeNumbers = array_map(function($movementInHeader) { return $movementInHeader->movement_in_number; }, $movementInHeaders); ?>
            <?php $movementInDates = array_map(function($movementInHeader) { return CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($movementInHeader->date_posting))); }, $movementInHeaders); ?>
            <?php $movementInTimes = array_map(function($movementInHeader) { return CHtml::encode(substr($movementInHeader->date_posting, -8)); }, $movementInHeaders); ?>
            <tr class="items1">
                <td class="width1-1"><?php echo CHtml::encode($i + 1); ?></td>
                <td class="width1-2">
                    <?php echo CHtml::link(CHtml::encode($header->sent_request_no), array("/transaction/transactionSentRequest/view", "id"=>$header->id), array("target" => "_blank")); ?>
                </td>
                <td class="width1-3">
                    <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->sent_request_date))); ?>
                </td>
                <td class="width1-3"><?php echo CHtml::encode($header->sent_request_time); ?></td>
                <td class="width1-4"><?php echo CHtml::encode(implode(', ', $deliveryOrderCodeNumbers)); ?></td>
                <td class="width1-5"><?php echo CHtml::encode(implode(', ', $deliveryOrderDates)); ?></td>
                <td class="width1-5"><?php echo CHtml::encode(implode(', ', $deliveryTimes)); ?></td>
                <td class="width1-5"><?php echo CHtml::encode(implode(', ', $movementOutHeaderCodeNumbers)); ?></td>
                <td class="width1-5"><?php echo CHtml::encode(implode(', ', $movementOutHeaderDates)); ?></td>
                <td class="width1-5"><?php echo CHtml::encode(implode(', ', $movementOutHeaderTimes)); ?></td>
                <td class="width1-6"><?php echo CHtml::encode(implode(', ', $receiveItemCodeNumbers)); ?></td>
                <td class="width1-5"><?php echo CHtml::encode(implode(', ', $receiveItemDates)); ?></td>
                <td class="width1-5"><?php echo CHtml::encode(implode(', ', $receiveItemTimes)); ?></td>
                <td class="width1-7"><?php echo CHtml::encode(implode(', ', $movementInHeaderCodeNumbers)); ?></td>
                <td class="width1-5"><?php echo CHtml::encode(implode(', ', $movementInDates)); ?></td>
                <td class="width1-5"><?php echo CHtml::encode(implode(', ', $movementInTimes)); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div>
    <div class="right">
        <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
            'itemCount' => $sentRequestFlowSummary->dataProvider->pagination->itemCount,
            'pageSize' => $sentRequestFlowSummary->dataProvider->pagination->pageSize,
            'currentPage' => $sentRequestFlowSummary->dataProvider->pagination->getCurrentPage(false),
        )); ?>
    </div>
    <div class="clear"></div>
</div>