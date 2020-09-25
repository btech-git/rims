<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th style="text-align: center; width: 10%">Car Make</th>
        <th style="text-align: center; width: 10%">Car Model</th>
        <th style="text-align: center; width: 10%">Description</th>
        <th style="width: 3%"></th>
    </tr>
    <?php foreach ($serviceGroup->vehicleDetails as $i => $detail): ?>
        <tr style="background-color: azure">
            <td>
                <?php echo CHtml::encode(CHtml::value($detail, 'vehicleCarModel.carMake.name')); ?>
            </td>
            <td>
                <?php if ($serviceGroup->header->isNewRecord): ?>
                    <?php echo CHtml::activeHiddenField($detail, "[$i]vehicle_car_model_id"); ?>
                <?php endif; ?>
                <?php echo CHtml::encode($detail->vehicleCarModel->name); ?>
                <?php echo CHtml::error($detail, 'vehicle_car_model_id'); ?>
            </td>
            <td>
                <?php echo CHtml::encode(CHtml::value($detail, 'vehicleCarModel.description')); ?>
            </td>
            <td style="width: 5%">
                <?php if ($serviceGroup->header->isNewRecord): ?>
                    <?php echo CHtml::button('Delete', array(
                        'onclick' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlRemoveVehicle', array('id' => $serviceGroup->header->id, 'index' => $i)),
                            'update' => '#detail_vehicle_div',
                        )),
                    )); ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
