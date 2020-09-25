<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th style="text-align: center; width: 10%">Code</th>
        <th style="text-align: center">Name</th>
        <th style="text-align: center; width: 15%">Category</th>
        <th style="text-align: center; width: 15%">Type</th>
        <th style="text-align: center; width: 15%">Flat Rate Hour</th>
        <th style="width: 3%"></th>
    </tr>
    <?php foreach ($serviceGroup->pricelistDetails as $i => $detail): ?>
        <tr style="background-color: azure">
            <td>
                <?php echo CHtml::encode(CHtml::value($detail, 'service.code')); ?>
            </td>
            <td>
                <?php echo CHtml::activeHiddenField($detail, "[$i]service_id"); ?>
                <?php echo CHtml::encode($detail->service->name); ?>
                <?php echo CHtml::error($detail, 'service_id'); ?>
            </td>
            <td>
                <?php echo CHtml::encode(CHtml::value($detail, 'service.serviceCategory.name')); ?>
            </td>
            <td>
                <?php echo CHtml::encode(CHtml::value($detail, 'service.serviceType.name')); ?>
            </td>
            <td>
                <?php echo CHtml::activeTextField($detail, "[$i]flat_rate_hour"); ?>
                <?php echo CHtml::error($detail, 'flat_rate_hour'); ?>
            </td>
            <td style="width: 5%">
                <?php if ($serviceGroup->header->isNewRecord): ?>
                    <?php echo CHtml::button('Delete', array(
                        'onclick' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlRemoveService', array('id' => $serviceGroup->header->id, 'index' => $i)),
                            'update' => '#detail_service_div',
                        )),
                    )); ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
