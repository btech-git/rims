<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th style="text-align: center">Nama Item</th>
        <th style="text-align: center">Kode Item</th>
        <th style="text-align: center">Quantity</th>
        <th style="text-align: center">Memo</th>
        <th>&nbsp;</th>
    </tr>
    <?php foreach ($maintenanceRequest->details as $i => $detail): ?>
        <tr style="background-color: azure">
            <td><?php echo CHtml::activeTextField($detail, "[$i]item_name"); ?></td>
            <td style="width: 15%"><?php echo CHtml::activeTextField($detail, "[$i]item_code"); ?></td>
            <td style="width: 10%"><?php echo CHtml::activeTextField($detail, "[$i]quantity"); ?></td>
            <td><?php echo CHtml::activeTextField($detail, "[$i]memo"); ?></td>
            <td style="width: 5%">
                <?php echo CHtml::button('Delete', array(
                    'onclick' => CHtml::ajax(array(
                        'type' => 'POST',
                        'url' => CController::createUrl('AjaxHtmlRemoveDetail', array('id' => $maintenanceRequest->header->id, 'index' => $i)),
                        'update' => '#detail_div',
                    )),
                )); ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>