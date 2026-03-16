<table>
    <thead>
        <tr>
            <td>Plate #</td>
            <td>Machine #</td>
            <td>Vehicle</td>
            <td>Color</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <?php echo CHtml::activehiddenField($bodyRepairRegistration->header, 'vehicle_id'); ?>
                <?php echo CHtml::encode(CHtml::value($vehicle, 'plate_number')); ?>
                <?php echo CHtml::error($bodyRepairRegistration->header,'vehicle_id'); ?>
            </td>
            <td><?php echo CHtml::encode(CHtml::value($vehicle, 'machine_number')); ?></td>
            <td>
                <?php echo CHtml::encode(CHtml::value($vehicle, 'carMake.name')); ?>
                <?php echo CHtml::encode(CHtml::value($vehicle, 'carModel.name')); ?>
                <?php echo CHtml::encode(CHtml::value($vehicle, 'carSubModel.name')); ?>
            </td>
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
            <td>Name</td>
            <td>Type</td>
            <td>Address</td>
            <td>Email</td>
            <td>Rate</td>
            <td>Birth Date</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php echo CHtml::encode(CHtml::value($customer, 'name')); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($customer, 'customer_type')); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($customer, 'address')); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($customer, 'email')); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($customer, 'flat_rate')); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($customer, 'birthdate')); ?></td>
        </tr>
    </tbody>
</table>