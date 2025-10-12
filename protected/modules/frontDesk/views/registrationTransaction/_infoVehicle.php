<table>
    <thead>
        <tr>
            <td>Plate #</td>
            <td>Vehicle</td>
            <td>Color</td>
            <td>Machine #</td>
            <td>Frame #</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php echo CHtml::encode(CHtml::value($vehicleData, 'plate_number')); ?></td>
            <td>
                <?php echo CHtml::encode(CHtml::value($vehicleData, 'carMake.name')); ?> - 
                <?php echo CHtml::encode(CHtml::value($vehicleData, 'carModel.name')); ?> - 
                <?php echo CHtml::encode(CHtml::value($vehicleData, 'carSubModel.name')); ?>
            </td>
            <td>
                <?php $color = Colors::model()->findByPk($vehicleData->color_id); ?>
                <?php echo CHtml::encode(CHtml::value($color, 'name')); ?>
            </td>
            <td><?php echo CHtml::encode(CHtml::value($vehicleData, 'machine_number')); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($vehicleData, 'frame_number')); ?></td>
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
            <td><?php echo CHtml::encode(CHtml::value($customer, 'name')); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($customer, 'customer_type')); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($customer, 'address')); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($customer, 'mobile_phone')); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($customer, 'email')); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($customer, 'birthdate')); ?></td>
        </tr>
    </tbody>
</table>