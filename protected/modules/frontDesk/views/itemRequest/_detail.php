<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th style="text-align: center">Nama Barang</th>
        <th style="text-align: center">Deskripsi</th>
        <th style="text-align: center; width: 10%">Quantity</th>
        <th style="text-align: center; width: 10%">Satuan</th>
        <th style="text-align: center; width: 10%">Harga Satuan</th>
        <th style="text-align: center; width: 10%">Total</th>
        <th style="text-align: center; width: 5%"></th>
    </tr>
    <?php foreach ($itemRequest->details as $i => $detail): ?>
            <td>
                <?php echo CHtml::activeTextField($detail, "[$i]item_name"); ?>
                <?php echo CHtml::error($detail, 'item_name'); ?>
            </td>
            <td>
                <?php echo CHtml::activeTextField($detail, "[$i]description"); ?>
                <?php echo CHtml::error($detail, 'description'); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::activeTextField($detail, "[$i]quantity", array(
                    'size' => 5, 
                    'maxLength' => 10,
                    'onchange' => '
                        $.ajax({
                            type: "POST",
                            dataType: "JSON",
                            url: "' . CController::createUrl('ajaxJsonTotal', array('id' => $itemRequest->header->id, 'index' => $i)) . '",
                            data: $("form").serialize(),
                            success: function(data) {
                                $("#total_price_' . $i . '").html(data.total_price);
                                $("#total_quantity").html(data.total_quantity);
                                $("#grand_total").html(data.grand_total);
                            },
                        });	
                    ',
                )); ?>
                <?php echo CHtml::error($detail, 'quantity'); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::activeDropDownList($detail, "[$i]unit_id", CHtml::listData(Unit::model()->findAll(), 'id', 'name'), array('prompt'=>'[--Select Unit --]')); ?>
                <?php echo CHtml::error($detail, 'unit_id'); ?>
            </td>
            <td>
                <?php echo CHtml::activeTextField($detail, "[$i]unit_price", array('size' => 7, 'maxLength' => 20,
                    'onchange' => '
                        $.ajax({
                            type: "POST",
                            dataType: "JSON",
                            url: "' . CController::createUrl('ajaxJsonTotal', array('id' => $itemRequest->header->id, 'index' => $i)) . '",
                            data: $("form").serialize(),
                            success: function(data) {
                                $("#total_price_' . $i . '").html(data.total_price);
                                $("#total_quantity").html(data.total_quantity);
                                $("#grand_total").html(data.grand_total);
                            },
                        });	
                    ',
                )); ?>
                <?php echo CHtml::error($detail, 'unit_price'); ?>
            </td>
            <td style="text-align: right">
                <span id="total_price_<?php echo $i; ?>"><?php echo CHtml::encode(CHtml::value($detail, 'total_price')); ?></span>
            </td>
            <td>
                <?php echo CHtml::button('Delete', array(
                    'onclick' => CHtml::ajax(array(
                        'type' => 'POST',
                        'url' => CController::createUrl('AjaxHtmlRemoveProduct', array('id' => $itemRequest->header->id, 'index' => $i)),
                        'update' => '#detail_div',
                    )),
                )); ?>
            </td>
        </tr>
    <?php endforeach; ?>
    <tr style="background-color: aquamarine">
        <td style="text-align: right; font-weight: bold" colspan="2">Total Qty:</td>
        <td style="text-align: center; font-weight: bold">
            <span id="total_quantity"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($itemRequest, 'total_quantity'))); ?></span>
        </td>
        <td style="text-align: right; font-weight: bold" colspan="2">Total Price:</td>
        <td style="text-align: right; font-weight: bold">
            <span id="grand_total"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($itemRequest, 'total_price'))); ?></span>
        </td>
        <td></td>
    </tr>
</table>