<div style="text-align: center">
    <h3>Data Mobil Masuk Bengkel</h3>
</div>

<div style="text-align: right">
    <?php echo ReportHelper::summaryText($vehicleEntryDataprovider); ?>
</div>

<?php echo CHtml::beginForm(); ?>
<div class="table_wrapper">
    <table class="responsive">
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
                <?php $saleEstimationHeader = SaleEstimationHeader::model()->find(array(
                    'condition' => 'vehicle_id = :vehicle_id', 
                    'params' => array(
                        ':vehicle_id' => $data->id,
                    ),
                )); ?>
            
                <tr>
                    <td class="text-center"><?php echo CHtml::encode($i + 1); ?></td>
                    <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy H:m:s", CHtml::value($data, 'vehicle.entry_datetime'))); ?></td>
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
                    <td><?php echo CHtml::encode(CHtml::value($data, 'vehicle.entryUser.username')); ?></td>
                    <td><?php echo CHtml::link('Proses', array("updateToProgress", "id" => $data->id), array('confirm' => 'Are you confirmed to start services?')); ?></td>
                    <td><?php echo CHtml::link('Keluar', array("updateToExit", "id" => $data->id), array('confirm' => 'Are you confirmed to exit vehicle?')); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php echo CHtml::endForm(); ?>

<div class="text-end">
    <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
        'pages' => $vehicleEntryDataprovider->pagination,
    )); ?>
</div>