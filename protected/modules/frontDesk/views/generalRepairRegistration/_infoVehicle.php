<table>
    <thead>
        <tr>
            <td>Plate #</td>
            <td>Machine #</td>
            <td>Car Make</td>
            <td>Model</td>
            <td>Sub Model</td>
            <td>Color</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <?php echo CHtml::activehiddenField($generalRepairRegistration->header, 'vehicle_id'); ?>
                <?php echo CHtml::encode(CHtml::value($vehicle, 'plate_number')); ?>
                <?php echo CHtml::error($generalRepairRegistration->header,'vehicle_id'); ?>
            </td>
            <td><?php echo CHtml::encode(CHtml::value($vehicle, 'machine_number')); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($vehicle, 'carMake.name')); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($vehicle, 'carModel.name')); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($vehicle, 'carSubModel.name')); ?></td>
            <td>
                <?php $color = Colors::model()->findByPk($vehicle->color_id); ?>
                <?php echo CHtml::encode(CHtml::value($color, 'name')); ?>
            </td>
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
                <?php echo CHtml::activeHiddenField($generalRepairRegistration->header, 'customer_id'); ?>
                <?php echo CHtml::encode(CHtml::value($customer, 'name')); ?>
                <?php echo CHtml::error($generalRepairRegistration->header,'customer_id'); ?>
            </td>
            <td><?php echo CHtml::encode(CHtml::value($customer, 'customer_type')); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($customer, 'address')); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($customer, 'mobile_phone')); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($customer, 'email')); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($customer, 'birthdate')); ?></td>
        </tr>
    </tbody>
</table>