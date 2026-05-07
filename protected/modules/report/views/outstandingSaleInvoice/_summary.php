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
    <div style="font-size: larger">Laporan Outstanding Invoice Penjualan</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<div class="table_wrapper">
    <table class="responsive">
        <thead style="position: sticky; top: 0">
            <tr id="header1">
                <th class="width1-1">No</th>
                <th class="width1-2">Invoice #</th>
                <th class="width1-3">Tanggal</th>
                <th class="width1-4">Customer</th>
                <th class="width1-5">Vehicle</th>
                <th class="width1-6">Plate #</th>
                <th class="width1-7">Status</th>
                <th class="width1-8">RG #</th>
                <th class="width1-9">SPK Customer #</th>
                <th class="width1-10">Total (Rp)</th>
                <th class="width1-11">Pembayaran (Rp)</th>
                <th class="width1-11">Sisa (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($outstandingSaleInvoiceSummary->dataProvider->data as $i => $header): ?>
                <tr class="items1">
                    <td><?php echo CHtml::encode($i + 1); ?></td>
                    <td>
                        <?php echo CHtml::link(CHtml::encode($header->invoice_number), array("/transaction/invoiceHeader/show", "id"=>$header->id), array("target" => "_blank")); ?>
                    </td>
                    <td>
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->invoice_date))); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carMake.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carModel.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carSubModel.name')); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'vehicle.plate_number')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
                    <td><?php echo CHtml::link(CHtml::value($header, 'registrationTransaction.transaction_number'), array("/frontDesk/registrationTransaction/view", "id"=>$header->registration_transaction_id), array("target" => "_blank")); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'registrationTransaction.customer_work_order_number')); ?></td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($header, 'total_price'))); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($header, 'payment_amount'))); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($header, 'payment_left'))); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>