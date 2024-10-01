<div class="table-responsive">
    <table class="table table-bordered">
        <thead class="table-secondary">
            <tr>
                <th>Deskripsi</th>
                <th>Quantity</th>
                <th>Satuan</th>
                <th>Harga Retail</th>
                <th>Harga Satuan</th>
                <th>Jumlah</th>
                <th>PPN</th>
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
                    <td><?php echo CHtml::encode(CHtml::value($productInfo, "unit.name")); ?></td>
                    <td class="text-end">
                        <?php echo CHtml::activeHiddenField($productDetail, "[$i]retail_price", array('readonly' => true,)); ?>
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($productDetail, 'retail_price'))); ?>
                    </td>
                    <td>
                        <?php
                        echo CHtml::activeTextField($productDetail, "[$i]sale_price", array(
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
                        ));
                        ?>
                    </td>
                    <td>
                        <?php /*echo CHtml::activeDropDownList($productDetail, "[$i]discount_type", array(
                            'Nominal' => 'Nominal',
                            'Percent' => '%'
                        ), array('prompt' => '[--Select Discount Type --]'));*/ ?>
                    </td>
                    <td>
                        <?php /*echo CHtml::activeTextField($productDetail, "[$i]discount_value", array(
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
                            'class' => "form-control is-valid",
                        ));*/ ?>
                    </td>
                    <td style="width: 10%">
                        <?php echo CHtml::activeHiddenField($productDetail, "[$i]total_price", array('readonly' => true,)); ?>
                        <span id="total_amount_product_<?php echo $i; ?>">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($productDetail, 'totalAmountProduct'))); ?>
                        </span>
                    </td>
                    <td>
                        <?php echo CHtml::button('X', array(
                            'onclick' => CHtml::ajax(array(
                                'type' => 'POST',
                                'url' => CController::createUrl('ajaxHtmlRemoveProductDetail', array('id' => $saleEstimation->header->id, 'index' => $i)),
                                'update' => '#detail-product',
                            )),
                        )); ?>
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
    </table>
</div>
