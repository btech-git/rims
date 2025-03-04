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
    .width1-11 { width: 10% }
'); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Raperind Motor</div>
    <div style="font-size: larger">Laporan Penjualan Retail Summary</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
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
            <th class="width1-9">Movement Out</th>
            <th class="width1-10">Invoice</th>
            <th class="width1-11">Payment In</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($saleFlowSummary->dataProvider->data as $i => $header): ?>
            <?php $movementOutHeaders = $header->movementOutHeaders; ?>
            <?php $movementOutHeaderCodeNumbers = array_map(function($movementOutHeader) { return $movementOutHeader->movement_out_no; }, $movementOutHeaders); ?>
            <?php $invoiceHeaders = $header->invoiceHeaders; ?>
            <?php $invoiceHeaderCodeNumbers = array_map(function($invoiceHeader) { return $invoiceHeader->invoice_number; }, $invoiceHeaders); ?>
            <?php $paymentInDetails = array_reduce(array_map(function($invoiceHeader) { return $invoiceHeader->paymentInDetails; }, $invoiceHeaders), function($a, $b) { return in_array($b, $a) ? $a : array_merge($a, $b); }, array()); ?>
            <?php $paymentInHeaderCodeNumbers = array_map(function($paymentInDetail) { return $paymentInDetail->paymentIn->payment_number; }, $paymentInDetails); ?>
            <tr class="items1">
                <td class="width1-1"><?php echo CHtml::encode($i + 1); ?></td>
                <td class="width1-2">
                    <?php echo CHtml::link(CHtml::encode($header->transaction_number), array("/frontDesk/generalRepairRegistration/view", "id"=>$header->id), array("target" => "_blank")); ?>
                </td>
                <td class="width1-3">
                    <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->transaction_date))); ?>
                </td>
                <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'vehicle.plate_number')); ?></td>
                <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
                <td class="width1-7" style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($header, 'grand_total'))); ?>
                </td>
                <td class="width1-8"><?php echo CHtml::encode(CHtml::value($header, 'work_order_number')); ?></td>
                <td class="width1-9"><?php echo CHtml::encode(implode(', ', $movementOutHeaderCodeNumbers)); ?></td>
                <td class="width1-10"><?php echo CHtml::encode(implode(', ', $invoiceHeaderCodeNumbers)); ?></td>
                <td class="width1-11"><?php echo CHtml::encode(implode(', ', $paymentInHeaderCodeNumbers)); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>