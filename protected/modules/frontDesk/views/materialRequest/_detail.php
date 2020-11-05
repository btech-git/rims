<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th style="text-align: center">Nama Barang</th>
        <th style="text-align: center">Code</th>
        <th style="text-align: center">Kategori</th>
        <th style="text-align: center">Brand</th>
        <th style="text-align: center">Sub Brand</th>
        <th style="text-align: center">Sub Brand Series</th>
        <th style="text-align: center; width: 10%">Quantity</th>
        <th style="text-align: center; width: 10%">Satuan</th>
        <th style="text-align: center; width: 5%"></th>
    </tr>
    <?php foreach ($materialRequest->details as $i => $detail): ?>
        <tr style="background-color: azure">
            <td>
                <?php echo CHtml::activeHiddenField($detail, "[$i]product_id"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'product.name')); ?>
            </td>
            <td>
                <?php echo CHtml::encode(CHtml::value($detail, 'product.manufacturer_code')); ?>
            </td>
            <td>
                <?php echo CHtml::encode(CHtml::value($detail, 'product.masterSubCategoryCode')); ?>
            </td>
            <td>
                <?php echo CHtml::encode(CHtml::value($detail, 'product.brand.name')); ?>
            </td>
            <td>
                <?php echo CHtml::encode(CHtml::value($detail, 'product.subBrand.name')); ?>
            </td>
            <td>
                <?php echo CHtml::encode(CHtml::value($detail, 'product.subBrandSeries.name')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::activeTextField($detail, "[$i]quantity", array('size' => 7, 'maxLength' => 20,
                    'onchange' => 'if (parseInt($(this).val()) > parseInt($("#current_stock_' . $i . '").val())) $(this).val($("#current_stock_' . $i . '").val())
                        $.ajax({
                            type: "POST",
                            dataType: "JSON",
                            url: "' . CController::createUrl('ajaxJsonTotal', array('id' => $materialRequest->header->id, 'index' => $i)) . '",
                            data: $("form").serialize(),
                            success: function(data) {
                                $("#total_qty").html(data.totalQuantity);
                            },
                        });	
                    ',
                )); ?>
                <?php echo CHtml::error($detail, 'quantity'); ?>
            </td>
            <td style="text-align: center">
                <?php $unit = Unit::model()->findByPk($detail->product->unit_id); ?>
                <?php echo CHtml::encode(CHtml::value($unit, 'name')); ?>
                <?php echo CHtml::error($detail, 'unit_id'); ?>
            </td>
            <td>
                <?php echo CHtml::button('Delete', array(
                    'onclick' => CHtml::ajax(array(
                        'type' => 'POST',
                        'url' => CController::createUrl('AjaxHtmlRemoveProduct', array('id' => $materialRequest->header->id, 'index' => $i)),
                        'update' => '#detail_div',
                    )),
                )); ?>
            </td>
        </tr>
    <?php endforeach; ?>
    <tr style="background-color: aquamarine">
        <td style="text-align: right; font-weight: bold" colspan="6">Total Qty:</td>
        <td style="text-align: right; font-weight: bold">
            <span id="total_qty">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $materialRequest->totalQuantity)); ?>
            </span>
        </td>
        <td style="text-align: right; font-weight: bold" colspan="2">&nbsp;</td>
    </tr>
</table>