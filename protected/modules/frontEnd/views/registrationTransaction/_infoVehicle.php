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
                <?php echo CHtml::activehiddenField($bodyRepair->header, 'vehicle_id'); ?>
                <?php echo CHtml::encode(CHtml::value($vehicle, 'plate_number')); ?>
                <?php echo CHtml::error($bodyRepair->header,'vehicle_id'); ?>
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