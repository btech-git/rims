<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th style="text-align: center">Nama Barang</th>
        <th style="text-align: center; width: 10%"">Code</th>
        <th style="text-align: center; width: 5px"">Kategori</th>
        <th style="text-align: center">Brand</th>
        <th style="text-align: center; width: 10%">Quantity</th>
        <th style="text-align: center; width: 5px">Satuan</th>
        <th style="text-align: center; width: 5px">Posisi Stok</th>
        <th style="text-align: center; width: 5px">Rata2 Penjualan</th>
        <th style="text-align: center; width: 5px">Stok Min</th>
        <th style="text-align: center">Memo</th>
        <th style="text-align: center; width: 5%"></th>
    </tr>
    <?php foreach ($transferRequest->details as $i => $detail): ?>
        <tr style="background-color: azure">
            <td>
                <?php echo CHtml::activeHiddenField($detail, "[$i]product_id"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'product.name')); ?>
            </td>
            <td><?php echo CHtml::encode(CHtml::value($detail, 'product.manufacturer_code')); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($detail, 'product.masterSubCategoryCode')); ?></td>
            <td>
                <?php echo CHtml::encode(CHtml::value($detail, 'product.brand.name')); ?> - 
                <?php echo CHtml::encode(CHtml::value($detail, 'product.subBrand.name')); ?> -
                <?php echo CHtml::encode(CHtml::value($detail, 'product.subBrandSeries.name')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::activeTextField($detail, "[$i]quantity", array(
                    'size' => 7, 
                    'maxLength' => 20,
                    'onchange' => 'if (parseInt($(this).val()) > parseInt($("#current_stock_' . $i . '").val())) $(this).val($("#current_stock_' . $i . '").val())
                        $.ajax({
                            type: "POST",
                            dataType: "JSON",
                            url: "' . CController::createUrl('ajaxJsonTotal', array('id' => $transferRequest->header->id, 'index' => $i)) . '",
                            data: $("form").serialize(),
                            success: function(data) {
                                $("#total_' . $i . '").html(data.total);
                                $("#total_qty").html(data.totalQuantity);
                                $("#grand_total").html(data.grandTotal);
                            },
                        });	
                    ',
                )); ?>
                <?php echo CHtml::error($detail, 'quantity'); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::activeHiddenField($detail, "[$i]unit_price"); ?>
                <?php echo CHtml::activeHiddenField($detail, "[$i]unit_id"); ?>
                <?php $unit = Unit::model()->findByPk($detail->unit_id); ?>
                <?php echo CHtml::encode(CHtml::value($unit, 'name')); ?>
                <?php echo CHtml::error($detail, 'unit_id'); ?>
            </td>
            <td>
                <?php echo CHtml::activeHiddenField($detail, "[$i]stock_quantity"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'stock_quantity')); ?>
                <?php echo CHtml::error($detail, 'stock_quantity'); ?>
            </td>
            <td>
                <?php echo CHtml::activeHiddenField($detail, "[$i]average_sale_amount"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'average_sale_amount')); ?>
                <?php echo CHtml::error($detail, 'average_sale_amount'); ?>
            </td>
            <td><?php echo CHtml::encode(CHtml::value($detail, 'product.minimum_stock')); ?></td>
            <td>
                <?php echo CHtml::activeTextField($detail, "[$i]memo"); ?>
                <?php echo CHtml::error($detail, 'memo'); ?>
            </td>
            <td>
                <?php echo CHtml::button('Delete', array(
                    'onclick' => CHtml::ajax(array(
                        'type' => 'POST',
                        'url' => CController::createUrl('AjaxHtmlRemoveProduct', array('id' => $transferRequest->header->id, 'index' => $i)),
                        'update' => '#detail_div',
                    )),
                )); ?>
            </td>
        </tr>
    <?php endforeach; ?>
    <tr style="background-color: aquamarine">
        <td style="text-align: right; font-weight: bold" colspan="4">Total Qty:</td>
        <td style="text-align: right; font-weight: bold">
            <span id="total_qty">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $transferRequest->totalQuantity)); ?>
            </span>
        </td>
        <td colspan="6">&nbsp;</td>
    </tr>
</table>