<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Raperind Motor</div>
    <div style="font-size: larger">Laporan Pembelian Harian Summary</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report" style="table-layout: fixed; width: 2000px">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th style="width: 70px">No</th>
            <th style="width: 150px">PO #</th>
            <th style="width: 120px">Tanggal</th>
            <th style="width: 120px">Jam</th>
            <th style="width: 220px">Supplier</th>
            <th style="width: 120px">Status</th>
            <th style="width: 170px">Penerimaan</th>
            <th style="width: 120px">Tanggal</th>
            <th style="width: 120px">Jam</th>
            <th style="width: 150px">Movement In</th>
            <th style="width: 120px">Tanggal</th>
            <th style="width: 120px">Jam</th>
            <th style="width: 200px">Invoice</th>
            <th style="width: 120px">Tanggal</th>
            <th style="width: 120px">Jam</th>
            <th style="width: 150px">Payment Out</th>
            <th style="width: 120px">Tanggal</th>
            <th style="width: 120px">Jam</th>
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
                <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->purchase_order_date))); ?></td>
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