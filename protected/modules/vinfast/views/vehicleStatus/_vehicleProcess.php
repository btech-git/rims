<div style="text-align: center">
    <h3>Data Mobil Dalam Proses</h3>
</div>

<div style="text-align: right">
    <?php echo ReportHelper::summaryText($vehicleProcessDataprovider); ?>
</div>

<?php echo CHtml::beginForm(); ?>
<div class="table_wrapper">
    <table class="responsive">
        <thead>
            <tr class="table-primary">
                <th class="text-center" style="min-width: 50px">#</th>
                <th class="text-center" style="min-width: 100px">Plat #</th>
                <th class="text-center" style="min-width: 200px">Kendaraan</th>
                <th class="text-center" style="min-width: 100px">Warna</th>
                <th class="text-center" style="min-width: 250px">Customer</th>
                <th class="text-center" style="min-width: 50px">KM</th>
                <th class="text-center" style="min-width: 100px">Registration #</th>
                <th class="text-center" style="min-width: 100px">Tanggal</th>
                <th class="text-center" style="min-width: 100px">WO #</th>
                <th class="text-center" style="min-width: 100px">SL #</th>
                <th class="text-center" style="min-width: 100px">Invoice #</th>
                <th class="text-center" style="min-width: 100px">Payment #</th>
                <th class="text-center" style="min-width: 50px">Selesai</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vehicleProcessDataprovider->data as $i => $data): ?>
                <tr>
                    <td class="text-center"><?php echo CHtml::encode($i + 1); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'vehicle.plate_number')); ?></td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($data, 'vehicle.carMake.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($data, 'vehicle.carModel.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($data, 'vehicle.carSubModel.name')); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'vehicle.color.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'customer.name')); ?></td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($data, 'vehicle_mileage'))); ?>
                    </td>
                    <td><?php echo CHtml::link(CHtml::value($data, 'transaction_number'), array("saleRegistration/view", "id" => $data->id), array('target' => '_blank')); ?></td>
                    <td>
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", CHtml::value($data, 'transaction_date'))); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'work_order_number')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'sales_order_number')); ?></td>
                    <td>
                        <?php $invoiceHeader = InvoiceHeader::model()->findByAttributes(array('registration_transaction_id' => $data->id)); ?>
                        <?php echo empty($invoiceHeader) ? '' : CHtml::link(CHtml::value($invoiceHeader, 'invoice_number'), array("/transaction/invoiceHeader/view", "id" => $invoiceHeader->id), array('target' => '_blank')); ?>
                    </td>
                    <td>
                        <?php if(!empty($invoiceHeader)): ?>
                            <?php $paymentInDetail = PaymentInDetail::model()->findByAttributes(array('invoice_header_id' => $invoiceHeader->id)); ?>
                            <?php echo  empty($paymentInDetail) ? '' : CHtml::link(CHtml::value($paymentInDetail, 'paymentIn.payment_number'), array("/transaction/paymentIn/view", "id" => $paymentInDetail->payment_in_id), array('target' => '_blank')); ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php echo CHtml::link('Keluar', array("updateToExit", "id" => $data->id), array('confirm' => 'Are you confirmed to exit vehicle?')); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php echo CHtml::endForm(); ?>

<div class="text-end">
    <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
        'pages' => $vehicleProcessDataprovider->pagination,
    )); ?>
</div>