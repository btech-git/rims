<?php if (count($registrationTransaction->productDetails) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Quantity</th>
                <th>Unit</th>
                <th>Retail Price</th>
                <th>Rec Sell Price</th>
                <th>Sale Price</th>
                <th>Discount Type</th>
                <th>Discount</th>
                <th>Total Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($registrationTransaction->productDetails as $i => $productDetail): ?>
                <?php $productInfo = Product::model()->findByPk($productDetail->product_id); ?>
                <?php echo CHtml::errorSummary($productDetail); ?>
                    <tr <?php if ($productDetail->sale_package_detail_id != null): ?>style="display: none"<?php endif; ?>>
                        <td>
                            <?php echo CHtml::activeHiddenField($productDetail, "[$i]product_id"); ?>
                            <?php echo CHtml::activeTextField($productDetail, "[$i]product_name", array('readonly' => true, 'value' => $productDetail->product_id != "" ? $productDetail->product->name : '')); ?>
                        </td>
                        <td>
                            <?php echo CHtml::activeTextField($productDetail, "[$i]quantity", array(
                                'onchange' => CHtml::ajax(array(
                                    'type' => 'POST',
                                    'dataType' => 'JSON',
                                    'url' => CController::createUrl('ajaxJsonTotalProduct', array('id' => $registrationTransaction->header->id, 'index' => $i)),
                                    'success' => 'function(data) {
                                        $("#total_amount_product_' . $i . '").html(data.totalAmountProduct);
                                        $("#total_quantity_product").html(data.totalQuantityProduct);
                                        $("#sub_total_product").html(data.subTotalProduct);
                                        $("#total_discount_product").html(data.totalDiscountProduct);
                                        $("#grand_total_product").html(data.grandTotalProduct);
                                        $("#sub_total_transaction").html(data.subTotalTransaction);
                                        $("#tax_item_amount").html(data.taxItemAmount);
                                        $("#grand_total_transaction").html(data.grandTotalTransaction);
                                    }',
                                )),
                                'class' => "form-control is-valid",
                            )); ?>
                        </td>
                        <td><?php echo CHtml::encode(CHtml::value($productInfo, "unit.name")); ?></td>
                        <td><?php echo CHtml::activeTextField($productDetail, "[$i]retail_price", array('readonly' => true,)); ?></td>
                        <td><?php echo CHtml::activeTextField($productDetail, "[$i]recommended_selling_price", array('readonly' => true,)); ?></td>
                        <td>
                            <?php echo CHtml::activeTextField($productDetail, "[$i]sale_price", array(
                                'onchange' => CHtml::ajax(array(
                                    'type' => 'POST',
                                    'dataType' => 'JSON',
                                    'url' => CController::createUrl('ajaxJsonTotalProduct', array('id' => $registrationTransaction->header->id, 'index' => $i)),
                                    'success' => 'function(data) {
                                        $("#total_amount_product_' . $i . '").html(data.totalAmountProduct);
                                        $("#total_quantity_product").html(data.totalQuantityProduct);
                                        $("#sub_total_product").html(data.subTotalProduct);
                                        $("#total_discount_product").html(data.totalDiscountProduct);
                                        $("#grand_total_product").html(data.grandTotalProduct);
                                        $("#sub_total_transaction").html(data.subTotalTransaction);
                                        $("#tax_item_amount").html(data.taxItemAmount);
                                        $("#grand_total_transaction").html(data.grandTotalTransaction);
                                    }',
                                )),
                                'class' => "form-control is-valid",
                            )); ?>
                        </td>
                        <td>
                            <?php echo CHtml::activeDropDownList($productDetail, "[$i]discount_type", array(
                                'Nominal' => 'Nominal',
                                'Percent' => '%'
                            ), array('prompt' => '[--Select Discount Type --]')); ?>
                        </td>
                        <td>
                            <?php echo CHtml::activeTextField($productDetail, "[$i]discount", array(
                                'onchange' => CHtml::ajax(array(
                                    'type' => 'POST',
                                    'dataType' => 'JSON',
                                    'url' => CController::createUrl('ajaxJsonTotalProduct', array('id' => $registrationTransaction->header->id, 'index' => $i)),
                                    'success' => 'function(data) {
                                        $("#total_amount_product_' . $i . '").html(data.totalAmountProduct);
                                        $("#total_quantity_product").html(data.totalQuantityProduct);
                                        $("#sub_total_product").html(data.subTotalProduct);
                                        $("#total_discount_product").html(data.totalDiscountProduct);
                                        $("#grand_total_product").html(data.grandTotalProduct);
                                        $("#sub_total_transaction").html(data.subTotalTransaction);
                                        $("#tax_item_amount").html(data.taxItemAmount);
                                        $("#grand_total_transaction").html(data.grandTotalTransaction);
                                    }',
                                )),
                                'class' => "form-control is-valid",
                            )); ?>
                        </td>
                        <td style="width: 10%; text-align: right">
                            <span id="total_amount_product_<?php echo $i; ?>">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($productDetail, 'totalAmountProduct'))); ?>
                            </span>
                        </td>
                        <td>
                            <?php echo CHtml::button('X', array(
                                'onclick' => CHtml::ajax(array(
                                    'type' => 'POST',
                                    'url' => CController::createUrl('ajaxHtmlRemoveProductDetail', array('id' => $registrationTransaction->header->id, 'index' => $i)),
                                    'update' => '#detail_product_div',
                                )) .
                                CHtml::ajax(array(
                                    'type' => 'POST',
                                    'dataType' => 'JSON',
                                    'url' => CController::createUrl('ajaxJsonTotalProduct', array('id' => $registrationTransaction->header->id, 'index' => $i)),
                                    'success' => 'function(data) {
                                        $("#total_amount_product_' . $i . '").html(data.totalAmountProduct);
                                        $("#total_quantity_product").html(data.totalQuantityProduct);
                                        $("#sub_total_product").html(data.subTotalProduct);
                                        $("#total_discount_product").html(data.totalDiscountProduct);
                                        $("#grand_total_product").html(data.grandTotalProduct);
                                        $("#sub_total_transaction").html(data.subTotalTransaction);
                                        $("#tax_item_amount").html(data.taxItemAmount);
                                        $("#grand_total_transaction").html(data.grandTotalTransaction);
                                    }',
                                )),
                            )); ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="8">
                            Code: <?php echo CHtml::encode(CHtml::value($productInfo, "manufacturer_code")); ?> ||
                            Kategori: <?php echo CHtml::encode(CHtml::value($productInfo, "masterSubCategoryCode")); ?> ||
                            Brand: <?php echo CHtml::encode(CHtml::value($productInfo, "brand.name")); ?> ||
                            Sub Brand: <?php echo CHtml::encode(CHtml::value($productInfo, "subBrand.name")); ?> ||
                            Sub Brand Series: <?php echo CHtml::encode(CHtml::value($productInfo, "subBrandSeries.name")); ?> 
                        </td>			
                        <td colspan="2">
                            <?php echo CHtml::button('Stock', array(
                                'onclick' => '$("#stock-check-dialog_' . $i . '").dialog("open"); return false;'
                            )); ?>
                            <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                                'id' => "stock-check-dialog_" . $i,
                                'options' => array(
                                    'title' => 'Stock',
                                    'autoOpen' => false,
                                    'width' => 'auto',
                                    'modal' => true,
                                ),
                            )); ?>

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
                            <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
                        </td>
                    </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
