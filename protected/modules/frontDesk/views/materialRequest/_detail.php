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
        <?php $productInfo = Product::model()->findByPk($detail->product_id); ?>
        <tr style="background-color: azure">
            <td>
                <?php echo CHtml::activeHiddenField($detail, "[$i]product_id"); ?>
                <?php echo CHtml::encode(CHtml::value($productInfo, 'name')); ?>
            </td>
            <td>
                <?php echo CHtml::encode(CHtml::value($productInfo, 'manufacturer_code')); ?>
            </td>
            <td>
                <?php echo CHtml::encode(CHtml::value($productInfo, 'masterSubCategoryCode')); ?>
            </td>
            <td>
                <?php echo CHtml::encode(CHtml::value($productInfo, 'brand.name')); ?>
            </td>
            <td>
                <?php echo CHtml::encode(CHtml::value($productInfo, 'subBrand.name')); ?>
            </td>
            <td>
                <?php echo CHtml::encode(CHtml::value($productInfo, 'subBrandSeries.name')); ?>
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
        <tr>
            <td colspan="9">
                <div class="row">
                    <div class="small-12 columns" style="padding-left: 0px; padding-right: 0px;">
                        <table>
                            <thead>
                                <tr>
                                    <?php foreach ($branches as $branch): ?>
                                        <th style="text-align: center"><?php echo CHtml::encode(CHtml::value($branch, 'code')); ?></th>
                                    <?php endforeach; ?>
                                    <th style="text-align: center">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php $inventoryTotalQuantities = $productInfo->getInventoryTotalQuantities(); ?>
                                    <?php $totalStock = 0; ?>
                                    <?php foreach ($branches as $branch): ?>
                                        <?php $index = -1; ?>
                                        <?php foreach ($inventoryTotalQuantities as $i => $inventoryTotalQuantity): ?>
                                            <?php if ($inventoryTotalQuantity['branch_id'] == $branch->id): ?>
                                                <?php $index = $i; ?>
                                                <?php break; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                        <?php if ($index >= 0): ?>
                                            <td>
                                                <?php echo CHtml::encode(CHtml::value($inventoryTotalQuantities[$i], 'total_stock')); ?>
                                                <?php $totalStock += CHtml::value($inventoryTotalQuantities[$i], 'total_stock'); ?>
                                            </td>
                                        <?php else: ?>
                                            <td>0</td>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    <td><?php echo CHtml::encode($totalStock); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
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
        <td style="text-align: right; font-weight: bold" colspan="3">&nbsp;</td>
    </tr>
</table>