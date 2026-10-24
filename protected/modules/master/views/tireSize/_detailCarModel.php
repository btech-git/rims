<table>
    <thead>
        <tr>
            <th>Merk</th>
            <th>Model</th>
            <th>Description</th>
            <th style="width: 3%"></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($tireSize->carModelDetails as $i => $detail): ?>
            <tr>
                <td>
                    <?php echo CHtml::activeHiddenField($detail, "[$i]vehicle_car_model_id"); ?>
                    <?php echo CHtml::encode(CHtml::value($detail, "vehicleCarModel.carMake.name")); ?>
                </td>
                <td><?php echo CHtml::encode(CHtml::value($detail, "vehicleCarModel.name")); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($detail, "description")); ?></td>
                <td>
                    <?php echo CHtml::button('X', array(
                        'onclick' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlRemoveCarModelDetail', array('id' => $tireSize->header->id, 'index' => $i)),
                            'update' => '#car_model_div',
                        )),
                    )); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
