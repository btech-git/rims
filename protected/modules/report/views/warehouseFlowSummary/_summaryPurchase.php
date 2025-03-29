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
    <div style="font-size: larger">Perpindahan Barang Pembelian</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">No</th>
            <th class="width1-2">Purchase #</th>
            <th class="width1-3">Tanggal</th>
            <th class="width1-3">Jam</th>
            <th class="width1-4">Penerimaan</th>
            <th class="width1-3">Tanggal</th>
            <th class="width1-3">Jam</th>
            <th class="width1-5">Movement In</th>
            <th class="width1-3">Tanggal</th>
            <th class="width1-3">Jam</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($purchaseOrderFlowSummary->dataProvider->data as $i => $header): ?>
            <?php $receiveItems = $header->transactionReceiveItems; ?>
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
                    <?php echo CHtml::link(CHtml::encode($header->purchase_order_no), array("/transaction/transactionPurchaseOrder/view", "id"=>$header->id), array("target" => "_blank")); ?>
                </td>
                <td class="width1-3">
                    <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->purchase_order_date))); ?>
                </td>
                <td class="width1-3"><?php echo CHtml::encode(substr($header->purchase_order_date, -8)); ?></td>
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
            'itemCount' => $purchaseOrderFlowSummary->dataProvider->pagination->itemCount,
            'pageSize' => $purchaseOrderFlowSummary->dataProvider->pagination->pageSize,
            'currentPage' => $purchaseOrderFlowSummary->dataProvider->pagination->getCurrentPage(false),
        )); ?>
    </div>
    <div class="clear"></div>
</div>