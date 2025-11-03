<div class="table-responsive">
    <table class="table table-bordered">
        <thead class="table-secondary">
            <tr>
                <th style="width: 15%">Code</th>
                <th>Product</th>
                <th style="width: 10%">Quantity</th>
                <th style="width: 15%">Harga Satuan</th>
                <th style="width: 10%">Disc Type</th>
                <th style="width: 10%">Discount</th>
                <th style="width: 15%">Total</th>
                <th style="width: 5%">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($saleEstimation->productDetails as $i => $productDetail): ?>
                <?php $productInfo = Product::model()->findByPk($productDetail->product_id); ?>
                <?php echo CHtml::errorSummary($productDetail); ?>
                <tr>
                    <td>
                        <?php echo CHtml::activeHiddenField($productDetail, "[$i]product_id"); ?>
                        <?php echo CHtml::encode(CHtml::value($productInfo, "manufacturer_code")); ?>
                    </td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($productInfo, "name")); ?> -
                        <?php echo CHtml::encode(CHtml::value($productInfo, "brand.name")); ?> -
                        <?php echo CHtml::encode(CHtml::value($productInfo, "subBrand.name")); ?> -
                        <?php echo CHtml::encode(CHtml::value($productInfo, "subBrandSeries.name")); ?> 
                    </td>
                    <td>
                        <?php echo CHtml::activeTextField($productDetail, "[$i]quantity", array(
                            'class' => 'form-control',
                            'onchange' => CHtml::ajax(array(
                                'type' => 'POST',
                                'dataType' => 'JSON',
                                'url' => CController::createUrl('ajaxJsonTotalProduct', array('id' => $saleEstimation->header->id, 'index' => $i)),
                                'success' => 'function(data) {
                                    $("#total_price_product_' . $i . '").html(data.totalPriceProduct);
                                    $("#total_quantity_product").html(data.totalQuantityProduct);
                                    $("#sub_total_product").html(data.subTotalProduct);
                                    $("#sub_total_transaction").html(data.subTotalTransaction);
                                    $("#tax_total_transaction").html(data.taxTotalTransaction);
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
                                    $("#total_price_product_' . $i . '").html(data.totalPriceProduct);
                                    $("#total_quantity_product").html(data.totalQuantityProduct);
                                    $("#sub_total_product").html(data.subTotalProduct);
                                    $("#sub_total_transaction").html(data.subTotalTransaction);
                                    $("#tax_total_transaction").html(data.taxTotalTransaction);
                                    $("#grand_total_transaction").html(data.grandTotalTransaction);
                                }',
                            )),
                            'class' => "form-control",
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeDropDownList($productDetail, "[$i]discount_type", array(
                            'Nominal' => 'Nominal',
                            'Percent' => '%'
                        ), array('prompt' => '[--Select Discount Type --]')); ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeTextField($productDetail, "[$i]discount_value", array(
                            'onchange' => CHtml::ajax(array(
                                'type' => 'POST',
                                'dataType' => 'JSON',
                                'url' => CController::createUrl('ajaxJsonTotalProduct', array('id' => $saleEstimation->header->id, 'index' => $i)),
                                'success' => 'function(data) {
                                    $("#total_price_product_' . $i . '").html(data.totalPriceProduct);
                                    $("#total_quantity_product").html(data.totalQuantityProduct);
                                    $("#sub_total_product").html(data.subTotalProduct);
                                    $("#sub_total_transaction").html(data.subTotalTransaction);
                                    $("#tax_total_transaction").html(data.taxTotalTransaction);
                                    $("#grand_total_transaction").html(data.grandTotalTransaction);
                                }',
                            )),
                            'class' => "form-control",
                        )); ?>
                    </td>
                    <td style="text-align: right">
                        <span id="total_price_product_<?php echo $i; ?>">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($productDetail, 'total_price'))); ?>
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
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td class="text-end fw-bold" colspan="2">Total Quantity</td>
                <td class="text-center fw-bold">
                    <span id="total_quantity_product">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0", CHtml::value($saleEstimation->header,'total_quantity_product'))); ?>                                                
                    </span>
                </td>
                <td class="text-end fw-bold" colspan="3">Total Produk</td>
                <td class="text-end fw-bold">
                    <span id="sub_total_product">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0", CHtml::value($saleEstimation->header, 'sub_total_product'))); ?>                                                
                    </span>
                </td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div>
