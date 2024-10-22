<div class="table-responsive">
    <table class="table table-bordered">
        <thead class="table-secondary">
            <tr>
                <th>Code</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Harga Satuan</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($saleEstimation->productDetails as $i => $productDetail): ?>
                <?php $productInfo = Product::model()->findByPk($productDetail->product_id); ?>
                <?php echo CHtml::errorSummary($productDetail); ?>
                <tr>
                    <td>
                        <?php echo CHtml::activeHiddenField($productDetail, "[$i]product_id"); ?>
                        <?php echo CHtml::encode(CHtml::value($productDetail, "product.manufacturer_code")); ?>
                    </td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($productDetail, "product.name")); ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeTextField($productDetail, "[$i]quantity", array(
                            'class' => 'form-control',
                            'onchange' => CHtml::ajax(array(
                                'type' => 'POST',
                                'dataType' => 'JSON',
                                'url' => CController::createUrl('ajaxJsonTotalProduct', array('id' => $saleEstimation->header->id, 'index' => $i)),
                                'success' => 'function(data) {
                                    $("#total_amount_product_' . $i . '").html(data.totalAmountProduct);
                                    $("#total_quantity_product").html(data.totalQuantityProduct);
                                    $("#sub_total_product").html(data.subTotalProduct);
                                    $("#total_discount_product").html(data.totalDiscountProduct);
                                    $("#grand_total_product").html(data.grandTotalProduct);
                                    $("#sub_total_transaction").html(data.subTotalTransaction);
                                    $("#tax_item_amount").html(data.taxItemAmount);
                                    $("#tax_service_amount").html(data.taxServiceAmount);
                                    $("#grand_total_transaction").html(data.grandTotalTransaction);
                                }',
                            )),
                        ));
                        ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeTextField($productDetail, "[$i]sale_price", array(
                            'onchange' => CHtml::ajax(array(
                                'type' => 'POST',
                                'dataType' => 'JSON',
                                'url' => CController::createUrl('ajaxJsonTotalProduct', array('id' => $saleEstimation->header->id, 'index' => $i)),
                                'success' => 'function(data) {
                                    $("#total_amount_product_' . $i . '").html(data.totalAmountProduct);
                                    $("#total_quantity_product").html(data.totalQuantityProduct);
                                    $("#sub_total_product").html(data.subTotalProduct);
                                    $("#total_discount_product").html(data.totalDiscountProduct);
                                    $("#grand_total_product").html(data.grandTotalProduct);
                                    $("#sub_total_transaction").html(data.subTotalTransaction);
                                    $("#tax_item_amount").html(data.taxItemAmount);
                                    $("#tax_service_amount").html(data.taxServiceAmount);
                                    $("#grand_total_transaction").html(data.grandTotalTransaction);
                                }',
                            )),
                            'class' => "form-control",
                        )); ?>
                    </td>
                    <td style="width: 10%">
                        <?php echo CHtml::activeHiddenField($productDetail, "[$i]total_price", array('readonly' => true,)); ?>
                        <span id="total_amount_product_<?php echo $i; ?>">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($productDetail, 'totalAmountProduct'))); ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($saleEstimation->header->isNewRecord): ?>
                            <?php echo CHtml::button('X', array(
                                'class' => "btn btn-outline-dark",
                                'onclick' => CHtml::ajax(array(
                                    'type' => 'POST',
                                    'url' => CController::createUrl('ajaxHtmlRemoveProductDetail', array('id' => $saleEstimation->header->id, 'index' => $i)),
                                    'update' => '#detail-product',
                                )),
                            )); ?>
                        <?php else: ?>
                            <?php echo CHtml::button('X', array(
                                'class' => "btn btn-danger",
                                'onclick' => CHtml::ajax(array(
                                    'type' => 'POST',
                                    'url' => CController::createUrl('ajaxHtmlRemoveProductDetail', array('id' => $saleEstimation->header->id, 'index' => $i)),
                                    'update' => '#detail-product',
                                )),
                            )); ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="7">
                        Code: <?php echo CHtml::encode(CHtml::value($productInfo, "manufacturer_code")); ?> ||
                        Kategori: <?php echo CHtml::encode(CHtml::value($productInfo, "masterSubCategoryCode")); ?> ||
                        Brand: <?php echo CHtml::encode(CHtml::value($productInfo, "brand.name")); ?> ||
                        Sub Brand: <?php echo CHtml::encode(CHtml::value($productInfo, "subBrand.name")); ?> ||
                        Sub Brand Series: <?php echo CHtml::encode(CHtml::value($productInfo, "subBrandSeries.name")); ?> 
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td class="text-end fw-bold" colspan="2">Total Quantity</td>
                <td class="text-end fw-bold"></td>
                <td class="text-end fw-bold">Total Produk</td>
                <td class="text-end fw-bold"></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div>
