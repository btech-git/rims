<div style="text-align: center">
    <h3>Data Mobil Masuk Bengkel</h3>
</div>

<div style="text-align: right">
    <?php echo ReportHelper::summaryText($vehicleEntryDataprovider); ?>
</div>

<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">
    <?php echo CHtml::beginForm(); ?>
    <table class="table table-bordered table-striped">
        <thead>
            <tr class="table-primary">
                <th class="text-center" style="min-width: 50px">#</th>
                <th class="text-center" style="min-width: 150px">Tanggal Masuk</th>
                <th class="text-center" style="min-width: 100px">Plat #</th>
                <th class="text-center" style="min-width: 200px">Kendaraan</th>
                <th class="text-center" style="min-width: 100px">Warna</th>
                <th class="text-center" style="min-width: 250px">Customer</th>
                <th class="text-center" style="min-width: 50px">KM</th>
                <th class="text-center" style="min-width: 100px">Registration #</th>
                <th class="text-center" style="min-width: 100px">Tanggal</th>
                <th class="text-center" style="min-width: 100px">WO #</th>
                <th class="text-center" style="min-width: 100px">SL #</th>
                <th class="text-center" style="min-width: 150px">User Entry</th>
                <th class="text-center" colspan="3">Service</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vehicleEntryDataprovider->data as $i => $data): ?>
                <?php $registrationTransaction = RegistrationTransaction::model()->find(array(
                    'condition' => 'vehicle_id = :vehicle_id AND DATE(transaction_date) BETWEEN :start_date AND :end_date', 
                    'params' => array(
                        ':vehicle_id' => $data->id,
                        ':start_date' => $startDateIn,
                        ':end_date' => $endDateIn,
                    ),
                )); ?>
                <?php $saleEstimationHeader = SaleEstimationHeader::model()->find(array(
                    'condition' => 'vehicle_id = :vehicle_id AND DATE(transaction_date) BETWEEN :start_date AND :end_date', 
                    'params' => array(
                        ':vehicle_id' => $data->id,
                        ':start_date' => $startDateIn,
                        ':end_date' => $endDateIn,
                    ),
                )); ?>
            
                <tr>
                    <td class="text-center"><?php echo CHtml::encode($i + 1); ?></td>
                    <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy H:m:s", CHtml::value($data, 'entry_datetime'))); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'plate_number')); ?></td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($data, 'carMake.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($data, 'carModel.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($data, 'carSubModel.name')); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'color.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'customer.name')); ?></td>
                    <td style="text-align: right">
                        <?php if (!empty($registrationTransaction)): ?>
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($registrationTransaction, 'vehicle_mileage'))); ?>
                        <?php endif; ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($registrationTransaction, 'transaction_number')); ?></td>
                    <td>
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", CHtml::value($registrationTransaction, 'transaction_date'))); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($registrationTransaction, 'work_order_number')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($registrationTransaction, 'sales_order_number')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'entryUser.username')); ?></td>
                    <td>
                        <?php if (empty($registrationTransaction)): ?>
                            <?php echo CHtml::link('Estimasi', array("/frontDesk/saleEstimation/createWithVehicle", "vehicleId" => $data->id)); ?>
                        <?php else: ?>
                            <?php echo CHtml::link('Proses', array("updateToProgress", "id" => $data->id)); ?>
                        <?php endif; ?>
                    </td>
                    <td><?php echo CHtml::link('Keluar', array("updateToExit", "id" => $data->id)); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php echo CHtml::endForm(); ?>
</div>

<div class="text-end">
    <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
        'pages' => $vehicleEntryDataprovider->pagination,
    )); ?>
</div>