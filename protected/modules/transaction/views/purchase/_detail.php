<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th style="text-align: center">Nama Barang</th>
        <th style="text-align: center; width: 5%">Jumlah</th>
        <th style="text-align: center; width: 5%">Satuan</th>
        <th style="text-align: center; width: 5%">Harga</th>
        <th style="text-align: center; width: 5%">Disc 1</th>
        <th style="text-align: center; width: 5%">Type 1</th>
        <th style="text-align: center; width: 5%">Disc 2</th>
        <th style="text-align: center; width: 5%">Type 2</th>
<!--        <th style="text-align: center; width: 5%">Disc 3</th>
        <th style="text-align: center; width: 5%">Type 3</th>
        <th style="text-align: center; width: 5%">Disc 4</th>
        <th style="text-align: center; width: 5%">Type 4</th>
        <th style="text-align: center; width: 5%">Disc 5</th>
        <th style="text-align: center; width: 5%">Type 5</th>-->
        <th style="text-align: center; width: 5%">Total</th>
        <th style="text-align: center; width: 5%"></th>
    </tr>
    <?php foreach ($purchase->details as $i => $detail): ?>
        <tr style="background-color: azure">
            <td>
                <?php echo CHtml::activeHiddenField($detail, "[$i]product_id"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'product.name')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::activeTextField($detail, "[$i]quantity", array('size' => 7, 'maxLength' => 20,
                    'onchange' => 'if (parseInt($(this).val()) > parseInt($("#current_stock_' . $i . '").val())) $(this).val($("#current_stock_' . $i . '").val())
						$.ajax({
                            type: "POST",
                            dataType: "JSON",
                            url: "' . CController::createUrl('ajaxJsonTotal', array('id' => $purchase->header->id, 'index' => $i)) . '",
                            data: $("form").serialize(),
                            success: function(data) {
                                $("#total_' . $i . '").html(data.total);
                                $("#sub_total").html(data.subTotal);
                                $("#total_qty").html(data.totalQuantity);
                                $("#tax").html(data.taxValue);
                                $("#grand_total").html(data.grandTotal);
                            },
                        });	
					',
                )); ?>
                <?php echo CHtml::error($detail, 'quantity'); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::activeDropDownList($detail, "[$i]unit_id", CHtml::listData(Unit::model()->findAll(), 'id', 'name'), array('empty' => '-- Pilih Satuan --')); ?>
                <?php echo CHtml::error($detail, 'unit_id'); ?>
            </td>
            <td style="text-align: center">
                <?php
                echo CHtml::activeTextField($detail, "[$i]unit_price", array('size' => 7, 'maxLength' => 20,
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonTotal', array('id' => $purchase->header->id, 'index' => $i)),
                        'success' => 'function(data) {
                            $("#total_' . $i . '").html(data.total);
                            $("#sub_total").html(data.subTotal);
                            $("#total_qty").html(data.totalQuantity);
                            $("#tax").html(data.taxValue);
                            $("#grand_total").html(data.grandTotal);
						}',
                    )),));
                ?>
                <?php echo CHtml::error($detail, 'unit_price'); ?>
            </td>
            <td style="text-align: center">
                <?php
                echo CHtml::activeTextField($detail, "[$i]discount1_nominal", array('size' => 7, 'maxLength' => 20,
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonTotal', array('id' => $purchase->header->id, 'index' => $i)),
                        'success' => 'function(data) {
                            $("#total_' . $i . '").html(data.total);
                            $("#sub_total").html(data.subTotal);
                            $("#total_qty").html(data.totalQuantity);
                            $("#tax").html(data.taxValue);
                            $("#grand_total").html(data.grandTotal);
						}',
                    )),));
                ?>
                <?php echo CHtml::error($detail, 'discount1_nominal'); ?>
            </td>
            <td style="text-align: center">
                <?php
                echo CHtml::activeTextField($detail, "[$i]discount1_type", array('size' => 7, 'maxLength' => 20,
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonTotal', array('id' => $purchase->header->id, 'index' => $i)),
                        'success' => 'function(data) {
                            $("#total_' . $i . '").html(data.total);
                            $("#sub_total").html(data.subTotal);
                            $("#total_qty").html(data.totalQuantity);
                            $("#tax").html(data.taxValue);
                            $("#grand_total").html(data.grandTotal);
						}',
                    )),));
                ?>
                <?php echo CHtml::error($detail, 'discount1_type'); ?>
            </td>
            <td style="text-align: center">
                <?php
                echo CHtml::activeTextField($detail, "[$i]discount2_nominal", array('size' => 7, 'maxLength' => 20,
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonTotal', array('id' => $purchase->header->id, 'index' => $i)),
                        'success' => 'function(data) {
                            $("#total_' . $i . '").html(data.total);
                            $("#sub_total").html(data.subTotal);
                            $("#total_qty").html(data.totalQuantity);
                            $("#tax").html(data.taxValue);
                            $("#grand_total").html(data.grandTotal);
						}',
                    )),));
                ?>
                <?php echo CHtml::error($detail, 'discount2_nominal'); ?>
            </td>
            <td style="text-align: center">
                <?php
                echo CHtml::activeTextField($detail, "[$i]discount2_type", array('size' => 7, 'maxLength' => 20,
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonTotal', array('id' => $purchase->header->id, 'index' => $i)),
                        'success' => 'function(data) {
                            $("#total_' . $i . '").html(data.total);
                            $("#sub_total").html(data.subTotal);
                            $("#total_qty").html(data.totalQuantity);
                            $("#tax").html(data.taxValue);
                            $("#grand_total").html(data.grandTotal);
						}',
                    )),));
                ?>
                <?php echo CHtml::error($detail, 'discount2_type'); ?>
            </td>
            <td style="text-align: right">
                <span id="total_<?php echo $i; ?>">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'total'))); ?>
                </span>
            </td>
            <td>
                <?php
                echo CHtml::button('Delete', array(
                    'onclick' => CHtml::ajax(array(
                        'type' => 'POST',
                        'url' => CController::createUrl('AjaxHtmlRemoveProduct', array('id' => $purchase->header->id, 'index' => $i)),
                        'update' => '#detail_div',
                    )),
                ));
                ?>
            </td>
        </tr>
    <?php endforeach; ?>
    <tr style="background-color: aquamarine">
        <td style="text-align: right; font-weight: bold" colspan="5">Total Qty:</td>
        <td style="text-align: right; font-weight: bold">
            <span id="total_qty">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $purchase->totalQuantity)); ?>
            </span>
        </td>
        <td style="text-align: right; font-weight: bold" colspan="2">Sub Total:</td>
        <td style="text-align: right; font-weight: bold">
            <span id="sub_total">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchase->subTotal)); ?>
            </span>
        </td>
        <td></td>
    </tr>
    <tr style="background-color: aquamarine">
        <td style="text-align: right; font-weight: bold" colspan="8">Discount:</td>
        <td style="text-align: right; font-weight: bold">
            <span id="discount">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchase->subTotal)); ?>
            </span>
        </td>
        <td></td>
    </tr>
    <tr style="background-color: aquamarine">
        <td style="text-align: right; font-weight: bold" colspan="8">PPn:</td>
        <td style="text-align: right; font-weight: bold">
            <span id="tax">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchase->subTotal)); ?>
            </span>
        </td>
        <td></td>
    </tr>
    <tr style="background-color: aquamarine">
        <td style="text-align: right; font-weight: bold" colspan="8">Grand Total:</td>
        <td style="text-align: right; font-weight: bold">
            <span id="grand_total">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchase->subTotal)); ?>
            </span>
        </td>
        <td></td>
    </tr>
</table>