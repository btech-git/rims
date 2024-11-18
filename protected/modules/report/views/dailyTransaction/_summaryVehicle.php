<fieldset>
    <legend>Kendaraan Masuk / Keluar</legend>
    <table class="report">
        <thead>
            <tr id="header1">
                <th class="width1-1">Plat #</th>
                <th class="width1-2">Kendaraan</th>
                <th class="width1-3">Customer</th>
                <th class="width1-4">Type</th>
                <th class="width1-5">Phone</th>
                <th class="width1-6">Email</th>
                <th class="width1-7">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($registrationTransactionData as $header): ?>
                <tr class="items1">
                    <td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'vehicle.plate_number')); ?></td>
                    <td class="width1-2">
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carMake.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carModel.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carSubModel.name')); ?>
                    </td>
                    <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                    <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'customer.customer_type')); ?></td>
                    <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'customer.mobile_phone')); ?></td>
                    <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'customer.email')); ?></td>
                    <td class="width1-7"><?php echo CHtml::encode(CHtml::value($header, 'vehicle_status')); ?></td>
                </tr>
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
                <th class="width1-1">Plat #</th>
                <th class="width1-2">Kendaraan</th>
                <th class="width1-3">Customer</th>
                <th class="width1-4">Type</th>
                <th class="width1-5">Phone</th>
                <th class="width1-6">Email</th>
                <th class="width1-7">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vehicleData as $header): ?>
                <tr class="items1">
                    <td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'vehicle.plate_number')); ?></td>
                    <td class="width1-2">
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carMake.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carModel.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carSubModel.name')); ?>
                    </td>
                    <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                    <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'customer.customer_type')); ?></td>
                    <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'customer.mobile_phone')); ?></td>
                    <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'customer.email')); ?></td>
                    <td class="width1-7"><?php echo CHtml::encode(CHtml::value($header, 'vehicle_status')); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>
