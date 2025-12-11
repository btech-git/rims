<div style="text-align: center">
    <h3>Data Mobil Keluar</h3>
</div>

<div style="text-align: right">
    <?php echo ReportHelper::summaryText($vehicleExitDataprovider); ?>
</div>

<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">
    <table class="table table-bordered table-striped">
        <thead>
            <tr class="table-primary">
                <th class="text-center" style="min-width: 50px">#</th>
                <th class="text-center" style="min-width: 100px">Plat #</th>
                <th class="text-center" style="min-width: 200px">Kendaraan</th>
                <th class="text-center" style="min-width: 100px">Warna</th>
                <th class="text-center" style="min-width: 250px">Customer</th>
                <th class="text-center" style="min-width: 100px">Tanggal</th>
                <th class="text-center" style="min-width: 50px">KM</th>
                <th class="text-center" style="min-width: 100px">Registration #</th>
                <th class="text-center" style="min-width: 100px">Invoice #</th>
                <th class="text-center" style="min-width: 100px">Payment #</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vehicleExitDataprovider->data as $i => $data): ?>
                <tr>
                    <td class="text-center"><?php echo CHtml::encode($i + 1); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'plate_number')); ?></td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($data, 'carMake.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($data, 'carModel.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($data, 'carSubModel.name')); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'color.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'customer.name')); ?></td>
                    <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy H:m:s", CHtml::value($data, 'exit_datetime'))); ?></td>
                    <td style="text-align: right">
                        <?php $registrationTransaction = RegistrationTransaction::model()->find(array(
                            'condition' => 'vehicle_id = :vehicle_id AND DATE(transaction_date) BETWEEN :start_date AND :end_date', 
                            'params' => array(
                                ':vehicle_id' => $data->id,
                                ':start_date' => $startDateExit,
                                ':end_date' => $endDateExit,
                            ),
                        )); ?>
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($registrationTransaction, 'vehicle_mileage'))); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($registrationTransaction, 'transaction_number')); ?></td>
                    <td>
                        <?php if(!empty($registrationTransaction)): ?>
                            <?php $invoiceHeader = InvoiceHeader::model()->findByAttributes(array('registration_transaction_id' => $registrationTransaction->id)); ?>
                            <?php echo CHtml::encode(CHtml::value($invoiceHeader, 'invoice_number')); ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if(!empty($invoiceHeader) && !empty($registrationTransaction)): ?>
                            <?php $paymentInDetail = PaymentInDetail::model()->findByAttributes(array('invoice_header_id' => $invoiceHeader->id)); ?>
                            <?php echo CHtml::encode(CHtml::value($paymentInDetail, 'paymentIn.payment_number')); ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="text-end">
    <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
        'pages' => $vehicleExitDataprovider->pagination,
    )); ?>
</div>