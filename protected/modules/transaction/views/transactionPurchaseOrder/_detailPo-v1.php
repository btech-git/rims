<table>
    <tr>
        <td width="10%">
            Product : 
            <?php echo CHtml::activeHiddenField($detail, "[$i]product_id", array('size' => 20, 'maxlength' => 20)); ?>
        </td>
        <td width="85%">
            <?php echo CHtml::activeTextField($detail, "[$i]product_name", array(
                'size' => 15,
                'maxlength' => 10,
                'readonly' => true,
                'value' => $detail->product_id == "" ? '' : Product::model()->findByPk($detail->product_id)->name
            )); ?>
        </td>
        <td width="5%">
            <?php echo CHtml::button('X', array(
                'onclick' => CHtml::ajax(array(
                    'type' => 'POST',
                    'url' => CController::createUrl('ajaxHtmlRemoveDetail',
                        array('id' => $purchaseOrder->header->id, 'index' => $i)),
                    'update' => '#detail',
                )),
            )); ?>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <?php echo CHtml::activeHiddenField($detail, "[$i]unit_id"); ?>
            <?php $unit = Unit::model()->findByPk($detail->unit_id); ?>
            Manufacture Code: <?php echo CHtml::Encode(CHtml::value($detail, 'product.manufacturer_code')); ?> ||
            Brand: <?php echo CHtml::Encode(CHtml::value($detail, 'product.brand.name')); ?> ||
            Sub Brand: <?php echo CHtml::Encode(CHtml::value($detail, 'product.subBrand.name')); ?> ||
            Brand Series: <?php echo CHtml::Encode(CHtml::value($detail, 'product.subBrandSeries.name')); ?> ||
            Unit: <?php echo CHtml::encode(CHtml::value($unit, 'name')); ?>
        </td>
    </tr>
    <tr>
        <td colspan="3" id="request_<?php echo $i; ?>">
            <?php

            $requestOrderDetails = TransactionRequestOrderDetail::model()->findAllByAttributes(array('product_id' => $detail->product_id));

            $this->renderPartial('_detailRequest', array(
                'requestOrderDetails' => $requestOrderDetails,
                'purchaseOrder' => $purchaseOrder,
                'detail' => $detail,
                'index' => $i
            ), false, true);
            //$this->renderPartial('_detailRequest',array('detail'=>$detail,'i'=>$i,'requestOrderDetails'=>$requestOrderDetails)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <div class="row">
                <div class="medium-6 columns">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">Quantity</label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo CHtml::activeTextField($detail, "[$i]quantity", array(
                                    'onchange' => '
                                        $.ajax({
                                            type: "POST",
                                            dataType: "JSON",
                                            url: "' . CController::createUrl('ajaxJsonTotal', array('id' => $purchaseOrder->header->id, 'index' => $i)) . '",
                                            data: $("form").serialize(),
                                            success: function(data) {
                                                $("#discount_1_nominal_' . $i . '").html(data.discount1Nominal);
                                                $("#discount_2_nominal_' . $i . '").html(data.discount2Nominal);
                                                $("#discount_3_nominal_' . $i . '").html(data.discount3Nominal);
                                                $("#discount_4_nominal_' . $i . '").html(data.discount4Nominal);
                                                $("#discount_5_nominal_' . $i . '").html(data.discount5Nominal);
                                                $("#total_quantity_detail_' . $i . '").html(data.totalQuantityDetail);
                                                $("#unit_price_detail_' . $i . '").html(data.unitPriceAfterDiscount);
                                                $("#sub_total_detail_' . $i . '").html(data.subTotalDetail);
                                                $("#total_discount_detail_' . $i . '").html(data.totalDiscountDetail);
                                                $("#tax_detail_' . $i . '").html(data.taxDetail);
                                                $("#grand_total_detail_' . $i . '").html(data.grandTotalDetail);
                                                $("#sub_total_before_discount").html(data.subTotalBeforeDiscount);
                                                $("#sub_total_discount").html(data.subTotalDiscount);
                                                $("#sub_total").html(data.subTotal);
                                                $("#total_quantity").html(data.totalQuantity);
                                                $("#tax_value").html(data.taxValue);
                                                $("#grand_total").html(data.grandTotal);
                                            },
                                        });	
                                    ',
                                )); ?>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">Retail Price</label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo CHtml::activeTextField($detail, "[$i]retail_price", array(
                                    'onchange' => '
                                        $.ajax({
                                            type: "POST",
                                            dataType: "JSON",
                                            url: "' . CController::createUrl('ajaxJsonTotal', array('id' => $purchaseOrder->header->id, 'index' => $i)) . '",
                                            data: $("form").serialize(),
                                            success: function(data) {
                                                $("#discount_1_nominal_' . $i . '").html(data.discount1Nominal);
                                                $("#discount_2_nominal_' . $i . '").html(data.discount2Nominal);
                                                $("#discount_3_nominal_' . $i . '").html(data.discount3Nominal);
                                                $("#discount_4_nominal_' . $i . '").html(data.discount4Nominal);
                                                $("#discount_5_nominal_' . $i . '").html(data.discount5Nominal);
                                                $("#price_after_discount_1_' . $i . '").html(data.priceAfterDiscount1);
                                                $("#price_after_discount_2_' . $i . '").html(data.priceAfterDiscount2);
                                                $("#price_after_discount_3_' . $i . '").html(data.priceAfterDiscount3);
                                                $("#price_after_discount_4_' . $i . '").html(data.priceAfterDiscount4);
                                                $("#price_after_discount_5_' . $i . '").html(data.priceAfterDiscount5);
                                                $("#total_quantity_detail_' . $i . '").html(data.totalQuantityDetail);
                                                $("#unit_price_detail_' . $i . '").html(data.unitPriceAfterDiscount);
                                                $("#sub_total_detail_' . $i . '").html(data.subTotalDetail);
                                                $("#total_discount_detail_' . $i . '").html(data.totalDiscountDetail);
                                                $("#tax_detail_' . $i . '").html(data.taxDetail);
                                                $("#grand_total_detail_' . $i . '").html(data.grandTotalDetail);
                                                $("#sub_total_before_discount").html(data.subTotalBeforeDiscount);
                                                $("#sub_total_discount").html(data.subTotalDiscount);
                                                $("#sub_total").html(data.subTotal);
                                                $("#total_quantity").html(data.totalQuantity);
                                                $("#tax_value").html(data.taxValue);
                                                $("#grand_total").html(data.grandTotal);
                                            },
                                        });	
                                    ',
                                )); ?>
<!--                                array('value' => intval($detail->retail_price))); -->
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">Last Buying Price</label>
                            </div>
                            <div class="small-8 columns">
                                <div class="row">
                                    <div class="small-10 columns">
                                        <?php echo CHtml::activeTextField($detail, "[$i]last_buying_price", array()); ?>
                                    </div>
                                    <div class="small-2 columns">
                                        <?php echo CHtml::button('$$', array(
                                            'rel' => $i,
                                            'onclick' => '
                                                var productId = $("#' . CHtml::activeId($detail, "[$i]product_id") . '").val();
                                                var supplierId = $("#' . CHtml::activeId($purchaseOrder->header, "supplier_id") . '").val();
                                                $.fn.yiiGridView.update("product-price-grid", {
                                                    data: {"ProductPrice[product_id]": productId, "ProductPrice[supplier_id]": supplierId}
                                                });
                                                $("#product-price-dialog").dialog("open");
                                                $("#DetailIndex").val(' . $i . ');
                                                return false;
                                            ',
                                        )); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">HPP</label>

                            </div>
                            <div class="small-8 columns">
                                <?php echo CHtml::activeTextField($detail, "[$i]hpp", array(
                                    'readonly' => true,
                                    'value' => $detail->product_id != "" ? Product::model()->findByPk($detail->product_id)->hpp : '0'
                                )); ?>

                            </div>
                        </div>
                    </div>


                </div>
                <div class="medium-6 columns">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">Discount Step</label>
                            </div>
                            <div class="small-8 columns">
                                <div class="row">
                                    <div class="small-8 columns">
                                        <?php
                                        echo CHtml::activeDropDownList($detail, "[$i]discount_step",
                                            array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5'),
                                            array('prompt' => '[--Select Discount step--]'));
                                        ?>
                                    </div>
                                    <div class="small-3 columns">
                                        <?php echo CHtml::button('Add', array(
                                            'id' => 'add' . $i,
                                            'onclick' => 'var step = +jQuery("#TransactionPurchaseOrderDetail_' . $i . '_discount_step").val();
											stepbtn' . $i . ' = step;
											switch (step) {
												case 1:
												$("#step1_' . $i . '").show();
												$("#step2_' . $i . '").hide();
												$("#step3_' . $i . '").hide();
												$("#step4_' . $i . '").hide();
												$("#step5_' . $i . '").hide();
												break;
												case 2:
												$("#step1_' . $i . '").show();
												$("#step2_' . $i . '").show();
												$("#step3_' . $i . '").hide();
												$("#step4_' . $i . '").hide();
												$("#step5_' . $i . '").hide();
												break;
												case 3:
												$("#step1_' . $i . '").show();
												$("#step2_' . $i . '").show();
												$("#step3_' . $i . '").show();
												$("#step4_' . $i . '").hide();
												$("#step5_' . $i . '").hide();
												break;
												case 4:
												$("#step1_' . $i . '").show();
												$("#step2_' . $i . '").show();
												$("#step3_' . $i . '").show();
												$("#step4_' . $i . '").show();
												$("#step5_' . $i . '").hide();
												break;
												case 5:
												$("#step1_' . $i . '").show();
												$("#step2_' . $i . '").show();
												$("#step3_' . $i . '").show();
												$("#step4_' . $i . '").show();
												$("#step5_' . $i . '").show();
												break;

												default:
												$("#step1_' . $i . '").hide();
												$("#step2_' . $i . '").hide();
												$("#step3_' . $i . '").hide();
												$("#step4_' . $i . '").hide();
												$("#step5_' . $i . '").hide();

												break;
										}'
                                        )); ?>
                                    </div>
                                    <div class="small-2 columns text-right">
                                        <?php /*echo CHtml::button('Count', array(
                                            'id' => 'count_' . $i,
                                            // 'style'=>'display:none;',
                                            'onclick' =>

                                                'var step = +jQuery("#TransactionPurchaseOrderDetail_' . $i . '_discount_step").val();
											switch (step) {
											case 1:
											$("#TransactionPurchaseOrderDetail_' . $i . '_total_quantity").val(jQuery("#TransactionPurchaseOrderDetail_' . $i . '_discount1_temp_quantity").val());
											$("#TransactionPurchaseOrderDetail_' . $i . '_total_price").val(jQuery("#TransactionPurchaseOrderDetail_' . $i . '_discount1_temp_price").val());
											$("#TransactionPurchaseOrderDetail_' . $i . '_subtotal").val(jQuery("#TransactionPurchaseOrderDetail_' . $i . '_discount1_temp_price").attr("realPrice"));
											$("#TransactionPurchaseOrderDetail_' . $i . '_discount").val(jQuery("#TransactionPurchaseOrderDetail_' . $i . '_discount1_temp_price").attr("rel"));
											$.ajax({
											type: "POST",

											url: "' . CController::createUrl('ajaxCountTotal',
                                                    array()) . '/totalquantity/" +$("#TransactionPurchaseOrderDetail_' . $i . '_total_quantity").val()+"/totalprice/"+$("#TransactionPurchaseOrderDetail_' . $i . '_total_price").val(),


											data: $("form").serialize(),
											dataType: "json",
											success: function(data) {
											console.log(data.unitprice);
											$("#TransactionPurchaseOrderDetail_' . $i . '_unit_price").val(data.unitprice);

											},});
											break;
											case 2:
											$("#TransactionPurchaseOrderDetail_' . $i . '_total_quantity").val(jQuery("#TransactionPurchaseOrderDetail_' . $i . '_discount2_temp_quantity").val());
											$("#TransactionPurchaseOrderDetail_' . $i . '_total_price").val(jQuery("#TransactionPurchaseOrderDetail_' . $i . '_discount2_temp_price").val());
											$("#TransactionPurchaseOrderDetail_' . $i . '_subtotal").val(jQuery("#TransactionPurchaseOrderDetail_' . $i . '_discount2_temp_price").attr("realPrice"));
											$("#TransactionPurchaseOrderDetail_' . $i . '_discount").val(jQuery("#TransactionPurchaseOrderDetail_' . $i . '_discount2_temp_price").attr("rel"));
											$.ajax({
											type: "POST",

											url: "' . CController::createUrl('ajaxCountTotal',
                                                    array()) . '/totalquantity/" +$("#TransactionPurchaseOrderDetail_' . $i . '_total_quantity").val()+"/totalprice/"+$("#TransactionPurchaseOrderDetail_' . $i . '_total_price").val(),


											data: $("form").serialize(),
											dataType: "json",
											success: function(data) {
											console.log(data.unitprice);
											$("#TransactionPurchaseOrderDetail_' . $i . '_unit_price").val(data.unitprice);

											},});
											break;
											case 3:
											$("#TransactionPurchaseOrderDetail_' . $i . '_total_quantity").val(jQuery("#TransactionPurchaseOrderDetail_' . $i . '_discount3_temp_quantity").val());
											$("#TransactionPurchaseOrderDetail_' . $i . '_total_price").val(jQuery("#TransactionPurchaseOrderDetail_' . $i . '_discount3_temp_price").val());
											$("#TransactionPurchaseOrderDetail_' . $i . '_subtotal").val(jQuery("#TransactionPurchaseOrderDetail_' . $i . '_discount3_temp_price").attr("realPrice"));
											$("#TransactionPurchaseOrderDetail_' . $i . '_discount").val(jQuery("#TransactionPurchaseOrderDetail_' . $i . '_discount3_temp_price").attr("rel"));
											$.ajax({
											type: "POST",

											url: "' . CController::createUrl('ajaxCountTotal',
                                                    array()) . '/totalquantity/" +$("#TransactionPurchaseOrderDetail_' . $i . '_total_quantity").val()+"/totalprice/"+$("#TransactionPurchaseOrderDetail_' . $i . '_subtotal").val(),


											data: $("form").serialize(),
											dataType: "json",
											success: function(data) {
											console.log(data.unitprice);
											$("#TransactionPurchaseOrderDetail_' . $i . '_unit_price").val(data.unitprice);

											},});
											break;
											case 4:
											$("#TransactionPurchaseOrderDetail_' . $i . '_total_quantity").val(jQuery("#TransactionPurchaseOrderDetail_' . $i . '_discount4_temp_quantity").val());
											$("#TransactionPurchaseOrderDetail_' . $i . '_total_price").val(jQuery("#TransactionPurchaseOrderDetail_' . $i . '_discount4_temp_price").val());
											$("#TransactionPurchaseOrderDetail_' . $i . '_subtotal").val(jQuery("#TransactionPurchaseOrderDetail_' . $i . '_discount4_temp_price").attr("realPrice"));
											$("#TransactionPurchaseOrderDetail_' . $i . '_discount").val(jQuery("#TransactionPurchaseOrderDetail_' . $i . '_discount4_temp_price").attr("rel"));
											$.ajax({
											type: "POST",

											url: "' . CController::createUrl('ajaxCountTotal',
                                                    array()) . '/totalquantity/" +$("#TransactionPurchaseOrderDetail_' . $i . '_total_quantity").val()+"/totalprice/"+$("#TransactionPurchaseOrderDetail_' . $i . '_total_price").val(),


											data: $("form").serialize(),
											dataType: "json",
											success: function(data) {
											console.log(data.unitprice);
											$("#TransactionPurchaseOrderDetail_' . $i . '_unit_price").val(data.unitprice);

											},});
											break;
											case 5:
											$("#TransactionPurchaseOrderDetail_' . $i . '_total_quantity").val(jQuery("#TransactionPurchaseOrderDetail_' . $i . '_discount5_temp_quantity").val());
											$("#TransactionPurchaseOrderDetail_' . $i . '_total_price").val(jQuery("#TransactionPurchaseOrderDetail_' . $i . '_discount5_temp_price").val());
											$("#TransactionPurchaseOrderDetail_' . $i . '_subtotal").val(jQuery("#TransactionPurchaseOrderDetail_' . $i . '_discount5_temp_price").attr("realPrice"));
											$("#TransactionPurchaseOrderDetail_' . $i . '_discount").val(jQuery("#TransactionPurchaseOrderDetail_' . $i . '_discount5_temp_price").attr("rel"));
											$.ajax({
											type: "POST",

											url: "' . CController::createUrl('ajaxCountTotal',
                                                    array()) . '/totalquantity/" +$("#TransactionPurchaseOrderDetail_' . $i . '_total_quantity").val()+"/totalprice/"+$("#TransactionPurchaseOrderDetail_' . $i . '_total_price").val(),


											data: $("form").serialize(),
											dataType: "json",
											success: function(data) {
											console.log(data.unitprice);
											$("#TransactionPurchaseOrderDetail_' . $i . '_unit_price").val(data.unitprice);

											},});
											break;

											default:
											$("#TransactionPurchaseOrderDetail_' . $i . '_total_quantity").val(jQuery("#TransactionPurchaseOrderDetail_' . $i . '_quantity").val());
											$("#TransactionPurchaseOrderDetail_' . $i . '_total_price").val(jQuery("#TransactionPurchaseOrderDetail_' . $i . '_retail_price").val());
											$.ajax({
											type: "POST",

											url: "' . CController::createUrl('ajaxCountTotalNonDiscount',
                                                    array()) . '/totalquantity/" +$("#TransactionPurchaseOrderDetail_' . $i . '_total_quantity").val()+"/totalprice/"+$("#TransactionPurchaseOrderDetail_' . $i . '_total_price").val(),


											data: $("form").serialize(),
											dataType: "json",
											success: function(data) {
											console.log(data.unitprice);
											$("#TransactionPurchaseOrderDetail_' . $i . '_unit_price").val(data.unitprice);
											$("#TransactionPurchaseOrderDetail_' . $i . '_total_price").val(data.price);
											$("#TransactionPurchaseOrderDetail_' . $i . '_subtotal").val(data.price);
											$("#TransactionPurchaseOrderDetail_' . $i . '_discount").val("0");
			
											},});
											break;

											}'

                                        ));*/ ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- // step 1 -->
                    <div class="field" id="step1_<?php echo $i; ?>">
                        <div class="row collapse">
                            <div class="small-2 columns">
                                <label class="prefix">Step 1</label>
                            </div>
                            <div class="small-10 columns">
                                <div class="row">
                                    <div class="small-3 columns">
                                        <?php echo CHtml::activeDropDownList($detail, "[$i]discount1_type",
                                            array('1' => 'Percent', '2' => 'Amount', '3' => 'Bonus'),
                                            array('prompt' => '[--Select Discount Type--]')); ?>
                                    </div>
                                    <div class="small-3 columns">
                                        <?php echo CHtml::activeTextField($detail, "[$i]discount1_nominal", array(
                                            'onchange' => '
                                                $.ajax({
                                                    type: "POST",
                                                    dataType: "JSON",
                                                    url: "' . CController::createUrl('ajaxJsonTotal', array('id' => $purchaseOrder->header->id, 'index' => $i)) . '",
                                                    data: $("form").serialize(),
                                                    success: function(data) {
                                                        $("#discount_1_nominal_' . $i . '").html(data.discount1Nominal);
                                                        $("#discount_2_nominal_' . $i . '").html(data.discount2Nominal);
                                                        $("#discount_3_nominal_' . $i . '").html(data.discount3Nominal);
                                                        $("#discount_4_nominal_' . $i . '").html(data.discount4Nominal);
                                                        $("#discount_5_nominal_' . $i . '").html(data.discount5Nominal);
                                                        $("#price_after_discount_1_' . $i . '").html(data.priceAfterDiscount1);
                                                        $("#price_after_discount_2_' . $i . '").html(data.priceAfterDiscount2);
                                                        $("#price_after_discount_3_' . $i . '").html(data.priceAfterDiscount3);
                                                        $("#price_after_discount_4_' . $i . '").html(data.priceAfterDiscount4);
                                                        $("#price_after_discount_5_' . $i . '").html(data.priceAfterDiscount5);
                                                        $("#total_quantity_detail_' . $i . '").html(data.totalQuantityDetail);
                                                        $("#unit_price_detail_' . $i . '").html(data.unitPriceAfterDiscount);
                                                        $("#sub_total_detail_' . $i . '").html(data.subTotalDetail);
                                                        $("#total_discount_detail_' . $i . '").html(data.totalDiscountDetail);
                                                        $("#tax_detail_' . $i . '").html(data.taxDetail);
                                                        $("#grand_total_detail_' . $i . '").html(data.grandTotalDetail);
                                                        $("#sub_total_before_discount").html(data.subTotalBeforeDiscount);
                                                        $("#sub_total_discount").html(data.subTotalDiscount);
                                                        $("#sub_total").html(data.subTotal);
                                                        $("#total_quantity").html(data.totalQuantity);
                                                        $("#tax_value").html(data.taxValue);
                                                        $("#grand_total").html(data.grandTotal);
                                                    },
                                                });	
                                            ',
                                        )); ?>
                                        <?php /*echo CHtml::button('Count', array(
                                            'id' => 'count_step1_' . $i,
                                            'style' => 'display:none;',
                                            'onclick' => 'var quantity = +jQuery("#TransactionPurchaseOrderDetail_' . $i . '_quantity").val();
											var retail = +jQuery("#TransactionPurchaseOrderDetail_' . $i . '_retail_price").val();
											var discountType = +jQuery("#TransactionPurchaseOrderDetail_' . $i . '_discount1_type").val();
											var discountAmount = +jQuery("#TransactionPurchaseOrderDetail_' . $i . '_discount1_nominal").val();
											//var price = 0;
											$.ajax({
												type: "POST",
												url: "' . CController::createUrl('ajaxCountAmount', array()) . '/discountType/" +discountType+"/discountAmount/"+discountAmount+"/retail/" +retail+"/quantity/"+quantity,


												data: $("form").serialize(),
												dataType: "json",
												success: function(data) {
													console.log(data.subtotal);
													console.log(data.totalquantity);
													console.log(data.newPrice);
													console.log(data.discountAmount);
													$("#TransactionPurchaseOrderDetail_' . $i . '_discount1_temp_price").val(data.subtotal);
													$("#TransactionPurchaseOrderDetail_' . $i . '_discount1_temp_price").attr("rel",data.discountAmount);
													$("#TransactionPurchaseOrderDetail_' . $i . '_discount1_temp_price").attr("realPrice",data.price);
													$("#TransactionPurchaseOrderDetail_' . $i . '_discount1_temp_quantity").val(data.totalquantity);
												},});'
                                        ));*/ ?>
                                    </div>
                                    <div class="small-3 columns text-right">
                                        <span id="discount_1_nominal_<?php echo $i; ?>">
                                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->getDiscount1Amount())); ?>
                                        </span>
                                    </div>
                                    <div class="small-3 columns text-right">
                                        <span id="price_after_discount_1_<?php echo $i; ?>">
                                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->getUnitPriceAfterDiscount1())); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="field" id="step2_<?php echo $i; ?>">
                        <div class="row collapse">
                            <div class="small-2 columns">
                                <label class="prefix">Step 2</label>
                            </div>
                            <div class="small-10 columns">
                                <div class="row">
                                    <div class="small-3 columns">
                                        <?php echo CHtml::activeDropDownList($detail, "[$i]discount2_type",
                                            array('1' => 'Percent', '2' => 'Amount', '3' => 'Bonus'),
                                            array('prompt' => '[--Select Discount Type--]')); ?>
                                    </div>
                                    <div class="small-3 columns">
                                        <?php echo CHtml::activeTextField($detail, "[$i]discount2_nominal", array(
                                            'onchange' => '
                                                $.ajax({
                                                    type: "POST",
                                                    dataType: "JSON",
                                                    url: "' . CController::createUrl('ajaxJsonTotal', array('id' => $purchaseOrder->header->id, 'index' => $i)) . '",
                                                    data: $("form").serialize(),
                                                    success: function(data) {
                                                        $("#discount_1_nominal_' . $i . '").html(data.discount1Nominal);
                                                        $("#discount_2_nominal_' . $i . '").html(data.discount2Nominal);
                                                        $("#discount_3_nominal_' . $i . '").html(data.discount3Nominal);
                                                        $("#discount_4_nominal_' . $i . '").html(data.discount4Nominal);
                                                        $("#discount_5_nominal_' . $i . '").html(data.discount5Nominal);
                                                        $("#price_after_discount_1_' . $i . '").html(data.priceAfterDiscount1);
                                                        $("#price_after_discount_2_' . $i . '").html(data.priceAfterDiscount2);
                                                        $("#price_after_discount_3_' . $i . '").html(data.priceAfterDiscount3);
                                                        $("#price_after_discount_4_' . $i . '").html(data.priceAfterDiscount4);
                                                        $("#price_after_discount_5_' . $i . '").html(data.priceAfterDiscount5);
                                                        $("#total_quantity_detail_' . $i . '").html(data.totalQuantityDetail);
                                                        $("#unit_price_detail_' . $i . '").html(data.unitPriceAfterDiscount);
                                                        $("#sub_total_detail_' . $i . '").html(data.subTotalDetail);
                                                        $("#total_discount_detail_' . $i . '").html(data.totalDiscountDetail);
                                                        $("#tax_detail_' . $i . '").html(data.taxDetail);
                                                        $("#grand_total_detail_' . $i . '").html(data.grandTotalDetail);
                                                        $("#sub_total_before_discount").html(data.subTotalBeforeDiscount);
                                                        $("#sub_total_discount").html(data.subTotalDiscount);
                                                        $("#sub_total").html(data.subTotal);
                                                        $("#total_quantity").html(data.totalQuantity);
                                                        $("#tax_value").html(data.taxValue);
                                                        $("#grand_total").html(data.grandTotal);
                                                    },
                                                });	
                                            ',
                                        )); ?>
                                        <?php /*echo CHtml::button('Count', array(
                                            'id' => 'count_step2_' . $i,
                                            'style' => 'display:none;',
                                            'onclick' => 'var quantity = +jQuery("#TransactionPurchaseOrderDetail_' . $i . '_quantity").val();
											var retail = +jQuery("#TransactionPurchaseOrderDetail_' . $i . '_retail_price").val();
											var discountType = +jQuery("#TransactionPurchaseOrderDetail_' . $i . '_discount2_type").val();
											var discountAmount = +jQuery("#TransactionPurchaseOrderDetail_' . $i . '_discount2_nominal").val();
											var price = +jQuery("#TransactionPurchaseOrderDetail_' . $i . '_discount1_temp_price").val();;

											$.ajax({
												type: "POST",

												url: "' . CController::createUrl('ajaxCountAmountStep', array()) . '/discountType/" +discountType+"/discountAmount/"+discountAmount+"/retail/" +retail+"/quantity/"+quantity+"/price/"+price,


												data: $("form").serialize(),
												dataType: "json",
												success: function(data) {
													console.log(data.subtotal);
													console.log(data.totalquantity);
													console.log(data.newPrice);
													console.log(data.oriPrice);
													console.log(data.discountAmount);
													$("#TransactionPurchaseOrderDetail_' . $i . '_discount2_temp_price").val(data.subtotal);
													$("#TransactionPurchaseOrderDetail_' . $i . '_discount2_temp_price").attr("rel",data.discountAmount);
													$("#TransactionPurchaseOrderDetail_' . $i . '_discount2_temp_price").attr("realPrice",data.oriPrice);
													$("#TransactionPurchaseOrderDetail_' . $i . '_discount2_temp_quantity").val(data.totalquantity);
												},});'


                                        ));*/ ?>
                                    </div>
                                    <div class="small-3 columns text-right">
                                        <span id="discount_2_nominal_<?php echo $i; ?>">
                                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->getDiscount2Amount())); ?>
                                        </span>
                                    </div>
                                    <div class="small-3 columns text-right">
                                        <span id="price_after_discount_2_<?php echo $i; ?>">
                                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->getUnitPriceAfterDiscount2())); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="field" id="step3_<?php echo $i; ?>">
                        <div class="row collapse">
                            <div class="small-2 columns">
                                <label class="prefix">Step 3</label>

                            </div>
                            <div class="small-10 columns">
                                <div class="row">
                                    <div class="small-3 columns">
                                        <?php echo CHtml::activeDropDownList($detail, "[$i]discount3_type", array(
                                            '1' => 'Percent',
                                            '2' => 'Amount',
                                            '3' => 'Bonus'
                                        ), array('prompt' => '[--Select Discount Type--]')); ?>
                                    </div>
                                    <div class="small-3 columns">
                                        <?php echo CHtml::activeTextField($detail, "[$i]discount3_nominal", array(
                                            'onchange' => '
                                                $.ajax({
                                                    type: "POST",
                                                    dataType: "JSON",
                                                    url: "' . CController::createUrl('ajaxJsonTotal', array('id' => $purchaseOrder->header->id, 'index' => $i)) . '",
                                                    data: $("form").serialize(),
                                                    success: function(data) {
                                                        $("#discount_1_nominal_' . $i . '").html(data.discount1Nominal);
                                                        $("#discount_2_nominal_' . $i . '").html(data.discount2Nominal);
                                                        $("#discount_3_nominal_' . $i . '").html(data.discount3Nominal);
                                                        $("#discount_4_nominal_' . $i . '").html(data.discount4Nominal);
                                                        $("#discount_5_nominal_' . $i . '").html(data.discount5Nominal);
                                                        $("#price_after_discount_1_' . $i . '").html(data.priceAfterDiscount1);
                                                        $("#price_after_discount_2_' . $i . '").html(data.priceAfterDiscount2);
                                                        $("#price_after_discount_3_' . $i . '").html(data.priceAfterDiscount3);
                                                        $("#price_after_discount_4_' . $i . '").html(data.priceAfterDiscount4);
                                                        $("#price_after_discount_5_' . $i . '").html(data.priceAfterDiscount5);
                                                        $("#total_quantity_detail_' . $i . '").html(data.totalQuantityDetail);
                                                        $("#unit_price_detail_' . $i . '").html(data.unitPriceAfterDiscount);
                                                        $("#sub_total_detail_' . $i . '").html(data.subTotalDetail);
                                                        $("#total_discount_detail_' . $i . '").html(data.totalDiscountDetail);
                                                        $("#tax_detail_' . $i . '").html(data.taxDetail);
                                                        $("#grand_total_detail_' . $i . '").html(data.grandTotalDetail);
                                                        $("#sub_total_before_discount").html(data.subTotalBeforeDiscount);
                                                        $("#sub_total_discount").html(data.subTotalDiscount);
                                                        $("#sub_total").html(data.subTotal);
                                                        $("#total_quantity").html(data.totalQuantity);
                                                        $("#tax_value").html(data.taxValue);
                                                        $("#grand_total").html(data.grandTotal);
                                                    },
                                                });	
                                            ',
                                        )); ?>
                                        <?php /*echo CHtml::button('Count', array(
                                            'id' => 'count_step3_' . $i,
                                            'style' => 'display:none;',
                                            'onclick' => 'var quantity = +jQuery("#TransactionPurchaseOrderDetail_' . $i . '_quantity").val();
											var retail = +jQuery("#TransactionPurchaseOrderDetail_' . $i . '_retail_price").val();
											var discountType = +jQuery("#TransactionPurchaseOrderDetail_' . $i . '_discount3_type").val();
											var discountAmount = +jQuery("#TransactionPurchaseOrderDetail_' . $i . '_discount3_nominal").val();
											var price = +jQuery("#TransactionPurchaseOrderDetail_' . $i . '_discount2_temp_price").val();;

											$.ajax({
												type: "POST",

												url: "' . CController::createUrl('ajaxCountAmountStep', array()) . '/discountType/" +discountType+"/discountAmount/"+discountAmount+"/retail/" +retail+"/quantity/"+quantity+"/price/"+price,

												data: $("form").serialize(),
												dataType: "json",
												success: function(data) {
													console.log(data.subtotal);
													console.log(data.totalquantity);
													console.log(data.newPrice);
													console.log(data.discountAmount);
													$("#TransactionPurchaseOrderDetail_' . $i . '_discount3_temp_price").val(data.subtotal);
													$("#TransactionPurchaseOrderDetail_' . $i . '_discount3_temp_price").attr("rel",data.discountAmount);
													$("#TransactionPurchaseOrderDetail_' . $i . '_discount3_temp_price").attr("realPrice",data.oriPrice);
													$("#TransactionPurchaseOrderDetail_' . $i . '_discount3_temp_quantity").val(data.totalquantity);
												},});'

                                        ));*/ ?>
                                    </div>
                                    <div class="small-3 columns text-right">
                                        <span id="discount_3_nominal_<?php echo $i; ?>">
                                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->getDiscount3Amount())); ?>
                                        </span>
                                    </div>
                                    <div class="small-3 columns text-right">
                                        <span id="price_after_discount_3_<?php echo $i; ?>">
                                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->getUnitPriceAfterDiscount3())); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="field" id="step4_<?php echo $i; ?>">
                        <div class="row collapse">
                            <div class="small-2 columns">
                                <label class="prefix">Step 4</label>
                            </div>
                            <div class="small-10 columns">
                                <div class="row">
                                    <div class="small-3 columns">
                                        <?php echo CHtml::activeDropDownList($detail, "[$i]discount4_type", array(
                                            '1' => 'Percent',
                                            '2' => 'Amount',
                                            '3' => 'Bonus'
                                        ), array('prompt' => '[--Select Discount Type--]')); ?>
                                    </div>
                                    <div class="small-3 columns">
                                        <?php echo CHtml::activeTextField($detail, "[$i]discount4_nominal", array(
                                            'onchange' => '
                                                $.ajax({
                                                    type: "POST",
                                                    dataType: "JSON",
                                                    url: "' . CController::createUrl('ajaxJsonTotal', array('id' => $purchaseOrder->header->id, 'index' => $i)) . '",
                                                    data: $("form").serialize(),
                                                    success: function(data) {
                                                        $("#discount_1_nominal_' . $i . '").html(data.discount1Nominal);
                                                        $("#discount_2_nominal_' . $i . '").html(data.discount2Nominal);
                                                        $("#discount_3_nominal_' . $i . '").html(data.discount3Nominal);
                                                        $("#discount_4_nominal_' . $i . '").html(data.discount4Nominal);
                                                        $("#discount_5_nominal_' . $i . '").html(data.discount5Nominal);
                                                        $("#price_after_discount_1_' . $i . '").html(data.priceAfterDiscount1);
                                                        $("#price_after_discount_2_' . $i . '").html(data.priceAfterDiscount2);
                                                        $("#price_after_discount_3_' . $i . '").html(data.priceAfterDiscount3);
                                                        $("#price_after_discount_4_' . $i . '").html(data.priceAfterDiscount4);
                                                        $("#price_after_discount_5_' . $i . '").html(data.priceAfterDiscount5);
                                                        $("#total_quantity_detail_' . $i . '").html(data.totalQuantityDetail);
                                                        $("#unit_price_detail_' . $i . '").html(data.unitPriceAfterDiscount);
                                                        $("#sub_total_detail_' . $i . '").html(data.subTotalDetail);
                                                        $("#total_discount_detail_' . $i . '").html(data.totalDiscountDetail);
                                                        $("#tax_detail_' . $i . '").html(data.taxDetail);
                                                        $("#grand_total_detail_' . $i . '").html(data.grandTotalDetail);
                                                        $("#sub_total_before_discount").html(data.subTotalBeforeDiscount);
                                                        $("#sub_total_discount").html(data.subTotalDiscount);
                                                        $("#sub_total").html(data.subTotal);
                                                        $("#total_quantity").html(data.totalQuantity);
                                                        $("#tax_value").html(data.taxValue);
                                                        $("#grand_total").html(data.grandTotal);
                                                    },
                                                });	
                                            ',
                                        )); ?>
                                        <?php /*echo CHtml::button('Count', array(
                                            'id' => 'count_step4_' . $i,
                                            'style' => 'display:none;',
                                            'onclick' => 'var quantity = +jQuery("#TransactionPurchaseOrderDetail_' . $i . '_quantity").val();
											var retail = +jQuery("#TransactionPurchaseOrderDetail_' . $i . '_retail_price").val();
											var discountType = +jQuery("#TransactionPurchaseOrderDetail_' . $i . '_discount4_type").val();
											var discountAmount = +jQuery("#TransactionPurchaseOrderDetail_' . $i . '_discount4_nominal").val();
											var price = +jQuery("#TransactionPurchaseOrderDetail_' . $i . '_discount3_temp_price").val();;

											$.ajax({
												type: "POST",

												url: "' . CController::createUrl('ajaxCountAmountStep', array()) . '/discountType/" +discountType+"/discountAmount/"+discountAmount+"/retail/" +retail+"/quantity/"+quantity+"/price/"+price,


												data: $("form").serialize(),
												dataType: "json",
												success: function(data) {
													console.log(data.subtotal);
													console.log(data.totalquantity);
													console.log(data.newPrice);
													console.log(data.discountAmount);
													$("#TransactionPurchaseOrderDetail_' . $i . '_discount4_temp_price").val(data.subtotal);
													$("#TransactionPurchaseOrderDetail_' . $i . '_discount4_temp_price").attr("rel",data.discountAmount);
													$("#TransactionPurchaseOrderDetail_' . $i . '_discount4_temp_price").attr("realPrice",data.oriPrice);
													$("#TransactionPurchaseOrderDetail_' . $i . '_discount4_temp_quantity").val(data.totalquantity);
												},});'


                                        ));*/ ?>
                                    </div>
                                    <div class="small-3 columns text-right">
                                        <span id="discount_4_nominal_<?php echo $i; ?>">
                                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->getDiscount4Amount())); ?>
                                        </span>
                                    </div>
                                    <div class="small-3 columns text-right">
                                        <span id="price_after_discount_4_<?php echo $i; ?>">
                                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->getUnitPriceAfterDiscount4())); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="field" id="step5_<?php echo $i; ?>">
                        <div class="row collapse">
                            <div class="small-2 columns">
                                <label class="prefix">Step 5</label>
                            </div>
                            <div class="small-10 columns">
                                <div class="row">
                                    <div class="small-3 columns">
                                        <?php echo CHtml::activeDropDownList($detail, "[$i]discount5_type", array(
                                            '1' => 'Percent',
                                            '2' => 'Amount',
                                            '3' => 'Bonus'
                                        ), array('prompt' => '[--Select Discount Type--]')); ?>
                                    </div>
                                    <div class="small-3 columns">
                                        <?php echo CHtml::activeTextField($detail, "[$i]discount5_nominal", array(
                                            'onchange' => '
                                                $.ajax({
                                                    type: "POST",
                                                    dataType: "JSON",
                                                    url: "' . CController::createUrl('ajaxJsonTotal', array('id' => $purchaseOrder->header->id, 'index' => $i)) . '",
                                                    data: $("form").serialize(),
                                                    success: function(data) {
                                                        $("#discount_1_nominal_' . $i . '").html(data.discount1Nominal);
                                                        $("#discount_2_nominal_' . $i . '").html(data.discount2Nominal);
                                                        $("#discount_3_nominal_' . $i . '").html(data.discount3Nominal);
                                                        $("#discount_4_nominal_' . $i . '").html(data.discount4Nominal);
                                                        $("#discount_5_nominal_' . $i . '").html(data.discount5Nominal);
                                                        $("#price_after_discount_1_' . $i . '").html(data.priceAfterDiscount1);
                                                        $("#price_after_discount_2_' . $i . '").html(data.priceAfterDiscount2);
                                                        $("#price_after_discount_3_' . $i . '").html(data.priceAfterDiscount3);
                                                        $("#price_after_discount_4_' . $i . '").html(data.priceAfterDiscount4);
                                                        $("#price_after_discount_5_' . $i . '").html(data.priceAfterDiscount5);
                                                        $("#total_quantity_detail_' . $i . '").html(data.totalQuantityDetail);
                                                        $("#unit_price_detail_' . $i . '").html(data.unitPriceAfterDiscount);
                                                        $("#sub_total_detail_' . $i . '").html(data.subTotalDetail);
                                                        $("#total_discount_detail_' . $i . '").html(data.totalDiscountDetail);
                                                        $("#tax_detail_' . $i . '").html(data.taxDetail);
                                                        $("#grand_total_detail_' . $i . '").html(data.grandTotalDetail);
                                                        $("#sub_total_before_discount").html(data.subTotalBeforeDiscount);
                                                        $("#sub_total_discount").html(data.subTotalDiscount);
                                                        $("#sub_total").html(data.subTotal);
                                                        $("#total_quantity").html(data.totalQuantity);
                                                        $("#tax_value").html(data.taxValue);
                                                        $("#grand_total").html(data.grandTotal);
                                                    },
                                                });	
                                            ',
                                        )); ?>
                                        <?php /*echo CHtml::button('Count', array(
                                            'id' => 'count_step5_' . $i,
                                            'style' => 'display:none;',
                                            'onclick' => 'var quantity = +jQuery("#TransactionPurchaseOrderDetail_' . $i . '_quantity").val();
											var retail = +jQuery("#TransactionPurchaseOrderDetail_' . $i . '_retail_price").val();
											var discountType = +jQuery("#TransactionPurchaseOrderDetail_' . $i . '_discount5_type").val();
											var discountAmount = +jQuery("#TransactionPurchaseOrderDetail_' . $i . '_discount5_nominal").val();
											var price = +jQuery("#TransactionPurchaseOrderDetail_' . $i . '_discount4_temp_price").val();;

											$.ajax({
												type: "POST",

												url: "' . CController::createUrl('ajaxCountAmountStep', array()) . '/discountType/" +discountType+"/discountAmount/"+discountAmount+"/retail/" +retail+"/quantity/"+quantity+"/price/"+price,


												data: $("form").serialize(),
												dataType: "json",
												success: function(data) {
													console.log(data.subtotal);
													console.log(data.totalquantity);
													console.log(data.newPrice);
													console.log(data.discountAmount);
													$("#TransactionPurchaseOrderDetail_' . $i . '_discount5_temp_price").val(data.subtotal);
													$("#TransactionPurchaseOrderDetail_' . $i . '_discount5_temp_price").attr("rel",data.discountAmount);
													$("#TransactionPurchaseOrderDetail_' . $i . '_discount5_temp_price").attr("realPrice",data.oriPrice);
													$("#TransactionPurchaseOrderDetail_' . $i . '_discount5_temp_quantity").val(data.totalquantity);
												},});'
                                        ));*/ ?>
                                    </div>
                                    <div class="small-3 columns text-right">
                                        <span id="discount_5_nominal_<?php echo $i; ?>">
                                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->getDiscount5Amount())); ?>
                                        </span>
                                    </div>
                                    <div class="small-3 columns text-right">
                                        <span id="price_after_discount_5_<?php echo $i; ?>">
                                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->getUnitPriceAfterDiscount5())); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

<!--                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">Total Quantity</label>
                            </div>
                            <div class="small-8 columns text-right">
                                <span id="total_quantity_detail_<?php echo $i; ?>">
                                    <?php //echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'quantityAfterBonus'))); ?>
                                </span>
                                <?php /*echo CHtml::activeTextField($detail, "[$i]total_quantity",
                                    array('readonly' => true));*/ ?>

                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">Unit Price</label>

                            </div>
                            <div class="small-8 columns text-right">
                                <span id="unit_price_detail_<?php echo $i; ?>">
                                    <?php //echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'unitPrice'))); ?>
                                </span>
                                <?php /*echo CHtml::activeTextField($detail, "[$i]unit_price",
                                    array('readonly' => true, 'value' => intval($detail->unit_price)));*/ ?>

                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">Sub Total</label>

                            </div>
                            <div class="small-8 columns text-right">
                                <span id="sub_total_detail_<?php echo $i; ?>">
                                    <?php //echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'subTotal'))); ?>
                                </span>
                                <?php /*echo CHtml::activeTextField($detail, "[$i]subtotal",
                                    array('readonly' => true, 'value' => intval($detail->subtotal)));*/ ?>

                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">Total Discount</label>

                            </div>
                            <div class="small-8 columns text-right">
                                <span id="total_discount_detail_<?php echo $i; ?>">
                                    <?php //echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'totalDiscount'))); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">PPn</label>

                            </div>
                            <div class="small-8 columns text-right">
                                <span id="tax_detail_<?php echo $i; ?>">
                                    <?php //echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'tax_amount'))); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">Grand Total</label>
                            </div>
                            <div class="small-8 columns text-right">
                                <span id="grand_total_detail_<?php echo $i; ?>">
                                    <?php //echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'grandTotal'))); ?>
                                </span>
                            </div>
                        </div>
                    </div>-->
                </div>
            </div>

        </td>
    </tr>
    <tr>
        <td colspan="3">
            <table>
                <tr>
                    <td>Total Quantity</td>
                    <td>
                        <span id="total_quantity_detail_<?php echo $i; ?>">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'quantityAfterBonus'))); ?>
                        </span>
                    </td>
                    <td>Sub Total</td>
                    <td>
                        <span id="sub_total_detail_<?php echo $i; ?>">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'subTotal'))); ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>Unit Price</td>
                    <td>
                        <span id="unit_price_detail_<?php echo $i; ?>">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'unitPrice'))); ?>
                        </span>
                    </td>
                    <td>Total Discount</td>
                    <td>
                        <span id="total_discount_detail_<?php echo $i; ?>">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'totalDiscount'))); ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                    <td>PPn</td>
                    <td>
                        <span id="tax_detail_<?php echo $i; ?>">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'tax_amount'))); ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                    <td>Grand Total</td>
                    <td>
                        <span id="grand_total_detail_<?php echo $i; ?>">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'grandTotal'))); ?>
                        </span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>


<?php
Yii::app()->clientScript->registerScript('myjqueryCount' . $i, '

    function callme_stepbtn() {
        if (stepbtn' . $i . ' == 1 ) {
			$("#TransactionPurchaseOrderDetail_' . $i . '_quantity,#TransactionPurchaseOrderDetail_' . $i . '_discount1_nominal").keyup(function(event){
				$("#count_step1_' . $i . '").click();
			});
		}else if (stepbtn' . $i . ' == 2 ) {
			$("#TransactionPurchaseOrderDetail_' . $i . '_quantity,#TransactionPurchaseOrderDetail_' . $i . '_discount1_nominal,#TransactionPurchaseOrderDetail_' . $i . '_discount2_nominal").keyup(function(event){
				$("#count_step1_' . $i . '").click();
				$("#count_step2_' . $i . '").click();
			});
		}else if (stepbtn' . $i . ' == 3 ) {
			$("#TransactionPurchaseOrderDetail_' . $i . '_quantity,#TransactionPurchaseOrderDetail_' . $i . '_discount1_nominal,#TransactionPurchaseOrderDetail_' . $i . '_discount2_nominal,#TransactionPurchaseOrderDetail_' . $i . '_discount3_nominal").keyup(function(event){
				$("#count_step1_' . $i . '").click();
				$("#count_step2_' . $i . '").click();
				$("#count_step3_' . $i . '").click();
			});
		}else if (stepbtn' . $i . ' == 4 ) {
			$("#TransactionPurchaseOrderDetail_' . $i . '_quantity,#TransactionPurchaseOrderDetail_' . $i . '_discount1_nominal,#TransactionPurchaseOrderDetail_' . $i . '_discount2_nominal,#TransactionPurchaseOrderDetail_' . $i . '_discount3_nominal,#TransactionPurchaseOrderDetail_' . $i . '_discount4_nominal").keyup(function(event){
				$("#count_step1_' . $i . '").click();
				$("#count_step2_' . $i . '").click();
				$("#count_step3_' . $i . '").click();
				$("#count_step4_' . $i . '").click();
			});
		}else if (stepbtn' . $i . ' == 5) {
			$("#TransactionPurchaseOrderDetail_' . $i . '_quantity,#TransactionPurchaseOrderDetail_' . $i . '_discount1_nominal,#TransactionPurchaseOrderDetail_' . $i . '_discount2_nominal,#TransactionPurchaseOrderDetail_' . $i . '_discount3_nominal,#TransactionPurchaseOrderDetail_' . $i . '_discount4_nominal,#TransactionPurchaseOrderDetail_' . $i . '_discount5_nominal").keyup(function(event){
				$("#count_step1_' . $i . '").click();
				$("#count_step2_' . $i . '").click();
				$("#count_step3_' . $i . '").click();
				$("#count_step4_' . $i . '").click();
				$("#count_step5_' . $i . '").click();
			});
		}
		// $("#count_' . $i . '").click();
    }

	$("#TransactionPurchaseOrderDetail_' . $i . '_quantity,#TransactionPurchaseOrderDetail_' . $i . '_discount1_nominal,#TransactionPurchaseOrderDetail_' . $i . '_discount2_nominal,#TransactionPurchaseOrderDetail_' . $i . '_discount3_nominal,#TransactionPurchaseOrderDetail_' . $i . '_discount4_nominal,#TransactionPurchaseOrderDetail_' . $i . '_discount5_nominal,#TransactionPurchaseOrderDetail_' . $i . '_discount_step").keyup(function(event){
		callme_stepbtn();
	});

	$("#add' . $i . '").click(function() {
		callme_stepbtn();
	});
');
?>

<?php
// 	Yii::app()->clientScript->registerScript('myjavascript', '
// 		//$(".numbers").number( true,2, ".", ",");
//     ', CClientScript::POS_END);
// ?>