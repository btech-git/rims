<fieldset>
    <legend>Kendaraan Masuk / Keluar</legend>
    <table class="report">
        <thead>
            <tr id="header1">
                <th>No.</th>
                <th class="width1-1">Plat #</th>
                <th class="width1-2">Kendaraan</th>
                <th class="width1-3">Warna</th>
                <th class="width1-4">KM</th>
                <th class="width1-5">Customer</th>
                <th class="width1-6">Type</th>
                <th class="width1-7">Phone</th>
                <th class="width1-8">Email</th>
                <th class="width1-9">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($registrationTransactionData as $i => $header): ?>
                <tr class="items1">
                    <td style="text-align: center"><?php echo $i + 1; ?></td>
                    <td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'vehicle.plate_number')); ?></td>
                    <td class="width1-2">
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carMake.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carModel.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carSubModel.name')); ?>
                    </td>
                    <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'vehicle.color.name')); ?></td>
                    <td class="width1-4" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'vehicle_mileage'))); ?>
                    </td>
                    <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                    <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'customer.customer_type')); ?></td>
                    <td class="width1-7"><?php echo CHtml::encode(CHtml::value($header, 'customer.mobile_phone')); ?></td>
                    <td class="width1-8"><?php echo CHtml::encode(CHtml::value($header, 'customer.email')); ?></td>
                    <td class="width1-9"><?php echo CHtml::encode(CHtml::value($header, 'vehicle.status_location')); ?></td>
                </tr>
                <?php $i++; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>

<hr />

<fieldset>
    <legend>Kendaraan Di Bengkel</legend>
    <table class="report">
        <thead>
            <tr id="header1">
                <th>No.</th>
                <th class="width1-1">Plat #</th>
                <th class="width1-2">Kendaraan</th>
                <th class="width1-3">Warna</th>
                <th class="width1-4">KM</th>
                <th class="width1-5">Customer</th>
                <th class="width1-6">Type</th>
                <th class="width1-7">Phone</th>
                <th class="width1-8">Email</th>
                <th class="width1-9">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vehicleData as $i => $header): ?>
                <tr class="items1">
                    <td style="text-align: center"><?php echo $i + 1; ?></td>
                    <td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'vehicle.plate_number')); ?></td>
                    <td class="width1-2">
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carMake.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carModel.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carSubModel.name')); ?>
                    </td>
                    <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'vehicle.color.name')); ?></td>
                    <td class="width1-4" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'vehicle_mileage'))); ?>
                    </td>
                    <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                    <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'customer.customer_type')); ?></td>
                    <td class="width1-7"><?php echo CHtml::encode(CHtml::value($header, 'customer.mobile_phone')); ?></td>
                    <td class="width1-8"><?php echo CHtml::encode(CHtml::value($header, 'customer.email')); ?></td>
                    <td class="width1-9"><?php echo CHtml::encode(CHtml::value($header, 'vehicle.status_location')); ?></td>
                </tr>
                <?php $i++; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>
