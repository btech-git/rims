<?php Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 2px }
    .width1-2 { width: 30px }
    .width1-3 { width: 50px }
    .width1-4 { width: 200px }
    .width1-5 { width: 30px }
    .width1-6 { width: 30px }
    .width1-7 { width: 30px }
    .width1-8 { width: 30px }
    .width1-9 { width: 30px }
    .width1-10 { width: 30px }
'); ?>

<style> 
 .table_wrapper{
    display: block;
    overflow-x: auto;
    white-space: nowrap;
}
</style>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">
        <?php $branch = Branch::model()->findByPk($branchId); ?>
        Raperind Motor <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?>
    </div>
    <div style="font-size: larger">Laporan Outstanding Purchase</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<div class="table_wrapper">
    <table class="responsive">
        <thead style="position: sticky; top: 0">
            <tr id="header1">
                <th class="width1-1">No</th>
                <th class="width1-2">PO #</th>
                <th class="width1-3">Tanggal</th>
                <th class="width1-4">Supplier</th>
                <th class="width1-5">Type</th>
                <th class="width1-6">Status</th>
                <th class="width1-7">Total (Rp)</th>
                <th class="width1-8">Receive #</th>
                <th class="width1-9">Invoice #</th>
                <th class="width1-10">Payment #</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($outstandingPurchaseOrderSummary->dataProvider->data as $i => $header): ?>
                <?php $receiveItems = $header->transactionReceiveItems; ?>
                <?php $receiveItemCodeNumbers = array_map(function($receiveItem) { return $receiveItem->receive_item_no; }, $receiveItems); ?>
                <?php $invoiceCodeNumbers = array_map(function($receiveItem) { return $receiveItem->invoice_number; }, $receiveItems); ?>
                <?php $paymentOuts = $header->paymentOuts; ?>
                <?php $paymentOutCodeNumbers = array_map(function($paymentOut) { return $paymentOut->payment_number; }, $paymentOuts); ?>
                <tr class="items1">
                    <td><?php echo CHtml::encode($i + 1); ?></td>
                    <td>
                        <?php echo CHtml::link(CHtml::encode($header->purchase_order_no), array(
                            "/transaction/transactionPurchaseOrder/show", 
                            "id"=>$header->id
                        ), array("target" => "_blank")); ?>
                    </td>
                    <td>
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->purchase_order_date))); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'supplier.name')); ?></td>
                    <td><?php echo CHtml::encode($header->getPurchaseStatus($header->purchase_type)); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'status_document')); ?></td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($header, 'total_price'))); ?>
                    </td>
                    <td><?php echo CHtml::encode(implode(', ', $receiveItemCodeNumbers)); ?></td>
                    <td><?php echo CHtml::encode(implode(', ', $invoiceCodeNumbers)); ?></td>
                    <td><?php echo CHtml::encode(implode(', ', $paymentOutCodeNumbers)); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>