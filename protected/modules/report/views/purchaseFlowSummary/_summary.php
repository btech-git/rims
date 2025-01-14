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
    .width1-10 { width: 10% }
'); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Raperind Motor</div>
    <div style="font-size: larger">Laporan Pembelian Summary</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">No</th>
            <th class="width1-2">PO #</th>
            <th class="width1-3">Tanggal</th>
            <th class="width1-4">Supplier</th>
            <th class="width1-5">Status</th>
            <th class="width1-6">Amount</th>
            <th class="width1-7">Penerimaan</th>
            <th class="width1-8">Movement In</th>
            <th class="width1-9">Invoice</th>
            <th class="width1-10">Payment Out</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($purchaseFlowSummary->dataProvider->data as $i => $header): ?>
            <?php $receiveItems = $header->transactionReceiveItems; ?>
            <?php $receiveItemCodeNumbers = array_map(function($receiveItem) { return $receiveItem->receive_item_no; }, $receiveItems); ?>
            <?php $receiveItemInvoiceNumbers = array_map(function($receiveItem) { return $receiveItem->invoice_number; }, $receiveItems); ?>
            <?php $movementInHeaders = array_reduce(array_map(function($receiveItem) { return $receiveItem->movementInHeaders; }, $receiveItems), function($a, $b) { return in_array($b, $a) ? $a : array_merge($a, $b); }, array()); ?>
            <?php $movementInHeaderCodeNumbers = array_map(function($movementInHeader) { return $movementInHeader->movement_in_number; }, $movementInHeaders); ?>
            <?php $paymentOutDetails = array_reduce(array_map(function($receiveItem) { return $receiveItem->payOutDetails; }, $receiveItems), function($a, $b) { return in_array($b, $a) ? $a : array_merge($a, $b); }, array()); ?>
            <?php $paymentOutCodeNumbers = array_map(function($paymentOutDetail) { return $paymentOutDetail->paymentOut->payment_number; }, $paymentOutDetails); ?>
            <tr class="items1">
                <td class="width1-1"><?php echo CHtml::encode($i + 1); ?></td>
                <td class="width1-2">
                    <?php echo CHtml::link(CHtml::encode($header->purchase_order_no), array("/frontDesk/generalRepairRegistration/view", "id"=>$header->id), array("target" => "_blank")); ?>
                </td>
                <td class="width1-3">
                    <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->purchase_order_date))); ?>
                </td>
                <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'supplier.name')); ?></td>
                <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'status_document')); ?></td>
                <td class="width1-7" style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($header, 'total_price'))); ?>
                </td>
                <td class="width1-5"><?php echo CHtml::encode(implode(', ', $receiveItemCodeNumbers)); ?></td>
                <td class="width1-6"><?php echo CHtml::encode(implode(', ', $movementInHeaderCodeNumbers)); ?></td>
                <td class="width1-7"><?php echo CHtml::encode(implode(', ', $receiveItemInvoiceNumbers)); ?></td>
                <td class="width1-8"><?php echo CHtml::encode(implode(', ', $paymentOutCodeNumbers)); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>