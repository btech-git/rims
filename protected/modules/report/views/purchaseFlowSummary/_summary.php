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
            <th class="width1-3">Jam</th>
            <th class="width1-4">Supplier</th>
            <th class="width1-5">Status</th>
            <th class="width1-6">Penerimaan</th>
            <th class="width1-7">Tanggal</th>
            <th class="width1-8">Jam</th>
            <th class="width1-9">Movement In</th>
            <th class="width1-10">Tanggal</th>
            <th class="width1-11">Jam</th>
            <th class="width1-12">Invoice</th>
            <th class="width1-13">Tanggal</th>
            <th class="width1-14">Jam</th>
            <th class="width1-15">Payment Out</th>
            <th class="width1-16">Tanggal</th>
            <th class="width1-17">Jam</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($purchaseFlowSummary->dataProvider->data as $i => $header): ?>
            <?php $receiveItems = $header->transactionReceiveItems; ?>
            <?php $receiveItemCodeNumbers = array_map(function($receiveItem) { return $receiveItem->receive_item_no; }, $receiveItems); ?>
            <?php $receiveItemInvoiceNumbers = array_map(function($receiveItem) { return $receiveItem->invoice_number; }, $receiveItems); ?>
            <?php $invoiceDates = array_map(function($receiveItem) { return CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($receiveItem->invoice_date))); }, $receiveItems); ?>
            <?php $receiveItemDates = array_map(function($receiveItem) { return CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($receiveItem->receive_item_date))); }, $receiveItems); ?>
            <?php $receiveItemTimes = array_map(function($receiveItem) { return CHtml::encode(substr($receiveItem->created_datetime, -8)); }, $receiveItems); ?>
            <?php $movementInHeaders = array_reduce(array_map(function($receiveItem) { return $receiveItem->movementInHeaders; }, $receiveItems), function($a, $b) { return in_array($b, $a) ? $a : array_merge($a, $b); }, array()); ?>
            <?php $movementInHeaderCodeNumbers = array_map(function($movementInHeader) { return $movementInHeader->movement_in_number; }, $movementInHeaders); ?>
            <?php $movementInDates = array_map(function($movementInHeader) { return CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($movementInHeader->date_posting))); }, $movementInHeaders); ?>
            <?php $movementInTimes = array_map(function($movementInHeader) { return CHtml::encode(substr($movementInHeader->date_posting, -8)); }, $movementInHeaders); ?>
            <?php $paymentOutDetails = array_reduce(array_map(function($receiveItem) { return $receiveItem->payOutDetails; }, $receiveItems), function($a, $b) { return in_array($b, $a) ? $a : array_merge($a, $b); }, array()); ?>
            <?php $paymentOutCodeNumbers = array_map(function($paymentOutDetail) { return $paymentOutDetail->paymentOut->payment_number; }, $paymentOutDetails); ?>
            <?php $paymentOutDates = array_map(function($paymentOutDetail) { return CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($paymentOutDetail->paymentOut->payment_date))); }, $paymentOutDetails); ?>
            <?php $paymentOutTimes = array_map(function($paymentOutDetail) { return CHtml::encode(substr($paymentOutDetail->paymentOut->created_datetime, -8)); }, $paymentOutDetails); ?>
            <tr class="items1">
                <td><?php echo CHtml::encode($i + 1); ?></td>
                <td>
                    <?php echo CHtml::link(CHtml::encode($header->purchase_order_no), array("/transaction/transactionPurchaseOrder/view", "id"=>$header->id), array("target" => "_blank")); ?>
                </td>
                <td>
                    <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->purchase_order_date))); ?>
                </td>
                <td><?php echo CHtml::encode(substr($header->purchase_order_date, -8)); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($header, 'supplier.name')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($header, 'status_document')); ?></td>
                <td><?php echo CHtml::encode(implode(', ', $receiveItemCodeNumbers)); ?></td>
                <td><?php echo CHtml::encode(implode(', ', $receiveItemDates)); ?></td>
                <td><?php echo CHtml::encode(implode(', ', $receiveItemTimes)); ?></td>
                <td><?php echo CHtml::encode(implode(', ', $movementInHeaderCodeNumbers)); ?></td>
                <td><?php echo CHtml::encode(implode(', ', $movementInDates)); ?></td>
                <td><?php echo CHtml::encode(implode(', ', $movementInTimes)); ?></td>
                <td><?php echo CHtml::encode(implode(', ', $receiveItemInvoiceNumbers)); ?></td>
                <td><?php echo CHtml::encode(implode(', ', $invoiceDates)); ?></td>
                <td><?php echo CHtml::encode(implode(', ', $receiveItemTimes)); ?></td>
                <td><?php echo CHtml::encode(implode(', ', $paymentOutCodeNumbers)); ?></td>
                <td><?php echo CHtml::encode(implode(', ', $paymentOutDates)); ?></td>
                <td><?php echo CHtml::encode(implode(', ', $paymentOutTimes)); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>