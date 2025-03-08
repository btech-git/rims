<?php Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 2px }
    .width1-2 { width: 30px }
    .width1-3 { width: 50px }
    .width1-4 { width: 130px }
    .width1-5 { width: 30px }
    .width1-6 { width: 30px }
    .width1-7 { width: 30px }
    .width1-8 { width: 30px }
    .width1-9 { width: 30px }
    .width1-10 { width: 30px }
    .width1-11 { width: 30px }
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
    <div style="font-size: larger">Laporan Penjualan Retail Summary</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<div class="table_wrapper">
    <table class="responsive">
        <thead style="position: sticky; top: 0">
            <tr id="header1">
                <th class="width1-1">No</th>
                <th class="width1-2">RG #</th>
                <th class="width1-3">Tanggal</th>
                <th class="width1-4">Customer</th>
                <th class="width1-5">Vehicle</th>
                <th class="width1-6">Status</th>
                <th class="width1-7">Amount</th>
                <th class="width1-8">Work Order</th>
                <th class="width1-8">Sales Order</th>
                <th class="width1-9">Movement Out</th>
                <th class="width1-10">Invoice</th>
                <th class="width1-11">Tanggal Invoice</th>
                <th class="width1-12">Payment In</th>
                <th class="width1-13">Tanggal Payment</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($saleFlowSummary->dataProvider->data as $i => $header): ?>
                <?php $movementOutHeaders = $header->movementOutHeaders; ?>
                <?php $movementOutHeaderCodeNumbers = array_map(function($movementOutHeader) { return $movementOutHeader->movement_out_no; }, $movementOutHeaders); ?>
                <?php $invoiceHeaders = $header->invoiceHeaders; ?>
                <?php $invoiceHeaderCodeNumbers = array_map(function($invoiceHeader) { return $invoiceHeader->invoice_number; }, $invoiceHeaders); ?>
                <?php $invoiceHeaderTransactionDates = array_map(function($invoiceHeader) { return $invoiceHeader->invoice_date . ' ' . CHtml::encode(Yii::app()->dateFormatter->format('hh:mm:ss', strtotime($invoiceHeader->created_datetime))); }, $invoiceHeaders); ?>
                <?php $paymentInDetails = array_reduce(array_map(function($invoiceHeader) { return $invoiceHeader->paymentInDetails; }, $invoiceHeaders), function($a, $b) { return in_array($b, $a) ? $a : array_merge($a, $b); }, array()); ?>
                <?php $paymentInHeaderCodeNumbers = array_map(function($paymentInDetail) { return $paymentInDetail->paymentIn->payment_number; }, $paymentInDetails); ?>
                <?php $paymentInHeaderDates = array_map(function($paymentInDetail) { return $paymentInDetail->paymentIn->payment_date . ' ' . $paymentInDetail->paymentIn->payment_time; }, $paymentInDetails); ?>
                <tr class="items1">
                    <td class="width1-1"><?php echo CHtml::encode($i + 1); ?></td>
                    <td class="width1-2">
                        <?php echo CHtml::link(CHtml::encode($header->transaction_number), array("/frontDesk/generalRepairRegistration/view", "id"=>$header->id), array("target" => "_blank")); ?>
                    </td>
                    <td class="width1-3">
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy hh:mm:ss', strtotime($header->transaction_date))); ?>
                    </td>
                    <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                    <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'vehicle.plate_number')); ?></td>
                    <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
                    <td class="width1-7" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($header, 'grand_total'))); ?>
                    </td>
                    <td class="width1-8"><?php echo CHtml::encode(CHtml::value($header, 'work_order_number')); ?></td>
                    <td class="width1-8"><?php echo CHtml::encode(CHtml::value($header, 'sales_order_number')); ?></td>
                    <td class="width1-9"><?php echo CHtml::encode(implode(', ', $movementOutHeaderCodeNumbers)); ?></td>
                    <td class="width1-10"><?php echo CHtml::encode(implode(', ', $invoiceHeaderCodeNumbers)); ?></td>
                    <td class="width1-3"><?php echo CHtml::encode(implode(', ', $invoiceHeaderTransactionDates)); ?></td>
                    <td class="width1-11"><?php echo CHtml::encode(implode(', ', $paymentInHeaderCodeNumbers)); ?></td>
                    <td class="width1-3"><?php echo CHtml::encode(implode(', ', $paymentInHeaderDates)); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>