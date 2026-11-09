<table>
    <thead>
        <tr>
            <td>Plate #</td>
            <td>Vehicle</td>
            <td>Color</td>
            <td>Machine #</td>
            <td>Frame #</td>
            <td>KM Sebelum</td>
            <td>KM Sekarang</td>
            <td>KM Selanjutnya</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <?php echo CHtml::activehiddenField($registrationTransaction->header, 'vehicle_id'); ?>
                <?php echo CHtml::encode(CHtml::value($vehicle, 'plate_number')); ?>
                <?php echo CHtml::error($registrationTransaction->header,'vehicle_id'); ?>
            </td>
            <td>
                <?php echo CHtml::encode(CHtml::value($vehicle, 'carMake.name')); ?>
                <?php echo CHtml::encode(CHtml::value($vehicle, 'carModel.name')); ?>
                <?php echo CHtml::encode(CHtml::value($vehicle, 'carSubModel.name')); ?>
            </td>
            <td>
                <?php $color = Colors::model()->findByPk($vehicle->color_id); ?>
                <?php echo CHtml::encode(CHtml::value($color, 'name')); ?>
            </td>
            <td><?php echo CHtml::encode(CHtml::value($vehicle, 'machine_number')); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($vehicle, 'frame_number')); ?></td>
            <td><?php echo number_format(CHtml::value($registrationTransaction->header, 'previous_mileage'), 0); ?></td>
            <td><?php echo number_format(CHtml::value($registrationTransaction->header, 'vehicle_mileage'), 0); ?></td>
            <td><?php echo number_format(CHtml::value($registrationTransaction->header, 'next_mileage'), 0); ?></td>
        </tr>
    </tbody>
</table>

<hr />

<table>
    <thead>
        <tr>
            <td>Customer</td>
            <td>Type</td>
            <td>Address</td>
            <td>Phone</td>
            <td>Email</td>
            <td>Birth Date</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <?php echo CHtml::activeHiddenField($registrationTransaction->header, 'customer_id'); ?>
                <?php echo CHtml::encode(CHtml::value($customer, 'name')); ?>
                <?php echo CHtml::error($registrationTransaction->header,'customer_id'); ?>
            </td>
            <td><?php echo CHtml::encode(CHtml::value($customer, 'customer_type')); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($customer, 'address')); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($customer, 'mobile_phone')); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($customer, 'email')); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($customer, 'birthdate')); ?></td>
        </tr>
    </tbody>
</table>