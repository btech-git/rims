<table>
    <thead>
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Unit</th>
            <th>HPP</th>
            <th>Price List</th>
            <th>Memo</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <?php echo CHtml::activeHiddenField($detail, "[$i]product_id"); ?>
                <?php echo CHtml::activeTextField($detail, "[$i]product_name", array(
                    'size' => 15,
                    'maxlength' => 10,
                    'readonly' => true,
                    'value' => $detail->product_id == "" ? '' : Product::model()->findByPk($detail->product_id)->name
                )); ?>
                <?php echo CHtml::error($detail, "product_id"); ?>
            </td>
            <td>
                <?php echo CHtml::activeTextField($detail, "[$i]quantity", array('size' => 3,
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
                                $("#unit_price_after_discount_' . $i . '").html(data.unitPriceAfterDiscountFormatted);
                                $("#' . CHtml::activeId($detail, "[$i]unit_price") . '").val(data.unitPriceAfterDiscount);
                                $("#sub_total_detail_' . $i . '").html(data.subTotalDetailFormatted);
                                $("#' . CHtml::activeId($detail, "[$i]total_price") . '").val(data.subTotalDetail);
                                $("#tax_detail_' . $i . '").html(data.taxAmountFormatted);
                                $("#' . CHtml::activeId($detail, "[$i]tax_amount") . '").val(data.taxAmount);
                                $("#price_before_tax_' . $i . '").html(data.priceBeforeTaxFormatted);
                                $("#' . CHtml::activeId($detail, "[$i]price_before_tax") . '").val(data.priceBeforeTax);
                                $("#total_before_tax_' . $i . '").html(data.totalPriceBeforeTaxFormatted);
                                $("#' . CHtml::activeId($detail, "[$i]total_before_tax") . '").val(data.totalPriceBeforeTax);
                                $("#total_quantity_detail_' . $i . '").html(data.totalQuantityDetailFormatted);
                                $("#' . CHtml::activeId($detail, "[$i]total_quantity") . '").val(data.totalQuantityDetail);
                                $("#total_discount_detail_' . $i . '").html(data.totalDiscountDetailFormatted);
                                $("#' . CHtml::activeId($detail, "[$i]discount") . '").val(data.totalDiscountDetail);
                                $("#sub_total_before_discount").html(data.subTotalBeforeDiscountFormatted);
                                $("#' . CHtml::activeId($purchaseOrder->header, "price_before_discount") . '").val(data.subTotalBeforeDiscount);
                                $("#sub_total_discount").html(data.subTotalDiscountFormatted);
                                $("#' . CHtml::activeId($purchaseOrder->header, "discount") . '").val(data.subTotalDiscount);
                                $("#sub_total").html(data.subTotalFormatted);
                                $("#' . CHtml::activeId($purchaseOrder->header, "subtotal") . '").val(data.subTotal);
                                $("#total_quantity").html(data.totalQuantityFormatted);
                                $("#' . CHtml::activeId($purchaseOrder->header, "total_quantity") . '").val(data.totalQuantity);
                                $("#tax_value").html(data.taxValueFormatted);
                                $("#' . CHtml::activeId($purchaseOrder->header, "ppn_price") . '").val(data.taxValue);
                                $("#grand_total").html(data.grandTotalFormatted);
                                $("#' . CHtml::activeId($purchaseOrder->header, "total_price") . '").val(data.grandTotal);
                            },
                        });	
                    ',
                )); ?>
            </td>
            <td>
                <?php echo CHtml::activeDropDownList($detail, "[$i]unit_id", CHtml::listData(Unit::model()->findAll(), 'id', 'name'), array('prompt'=>'[--Select Unit --]')); ?>
                <?php echo CHtml::encode(CHtml::value($unit, 'name')); ?>
            </td>
            <td>
                <?php echo CHtml::activeHiddenField($detail, "[$i]hpp"); ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'product.hpp'))); ?>
            </td>
            <td>
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
                                $("#unit_price_after_discount_' . $i . '").html(data.unitPriceAfterDiscountFormatted);
                                $("#' . CHtml::activeId($detail, "[$i]unit_price") . '").val(data.unitPriceAfterDiscount);
                                $("#sub_total_detail_' . $i . '").html(data.subTotalDetailFormatted);
                                $("#' . CHtml::activeId($detail, "[$i]total_price") . '").val(data.subTotalDetail);
                                $("#tax_detail_' . $i . '").html(data.taxAmountFormatted);
                                $("#' . CHtml::activeId($detail, "[$i]tax_amount") . '").val(data.taxAmount);
                                $("#price_before_tax_' . $i . '").html(data.priceBeforeTaxFormatted);
                                $("#' . CHtml::activeId($detail, "[$i]price_before_tax") . '").val(data.priceBeforeTax);
                                $("#total_before_tax_' . $i . '").html(data.totalPriceBeforeTaxFormatted);
                                $("#' . CHtml::activeId($detail, "[$i]total_before_tax") . '").val(data.totalPriceBeforeTax);
                                $("#total_quantity_detail_' . $i . '").html(data.totalQuantityDetailFormatted);
                                $("#' . CHtml::activeId($detail, "[$i]total_quantity") . '").val(data.totalQuantityDetail);
                                $("#total_discount_detail_' . $i . '").html(data.totalDiscountDetailFormatted);
                                $("#' . CHtml::activeId($detail, "[$i]discount") . '").val(data.totalDiscountDetail);
                                $("#sub_total_before_discount").html(data.subTotalBeforeDiscountFormatted);
                                $("#' . CHtml::activeId($purchaseOrder->header, "price_before_discount") . '").val(data.subTotalBeforeDiscount);
                                $("#sub_total_discount").html(data.subTotalDiscountFormatted);
                                $("#' . CHtml::activeId($purchaseOrder->header, "discount") . '").val(data.subTotalDiscount);
                                $("#sub_total").html(data.subTotalFormatted);
                                $("#' . CHtml::activeId($purchaseOrder->header, "subtotal") . '").val(data.subTotal);
                                $("#total_quantity").html(data.totalQuantityFormatted);
                                $("#' . CHtml::activeId($purchaseOrder->header, "total_quantity") . '").val(data.totalQuantity);
                                $("#tax_value").html(data.taxValueFormatted);
                                $("#' . CHtml::activeId($purchaseOrder->header, "ppn_price") . '").val(data.taxValue);
                                $("#grand_total").html(data.grandTotalFormatted);
                                $("#' . CHtml::activeId($purchaseOrder->header, "total_price") . '").val(data.grandTotal);
                            },
                        });	
                    ',
                )); ?>
            </td>
            <td>
                <?php echo CHtml::activeTextField($detail, "[$i]memo"); ?>
                <?php echo CHtml::error($detail, "memo"); ?>
            </td>
            
            <td width="5%">
                <?php echo CHtml::button('X', array(
                    'onclick' => CHtml::ajax(array(
                        'type' => 'POST',
                        'url' => CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $purchaseOrder->header->id, 'index' => $i)),
                        'update' => '#detail',
                    )),
                )); ?>
            </td>
        </tr>
        <tr>
            <td colspan="7">
                Manufacture Code: <?php echo CHtml::encode(CHtml::value($detail, 'product.manufacturer_code')); ?> ||
                Category: <?php echo CHtml::encode(CHtml::value($detail, 'product.masterSubCategoryCode')); ?> ||
                Brand: <?php echo CHtml::encode(CHtml::value($detail, 'product.brand.name')); ?> ||
                Sub Brand: <?php echo CHtml::encode(CHtml::value($detail, 'product.subBrand.name')); ?> ||
                Brand Series: <?php echo CHtml::encode(CHtml::value($detail, 'product.subBrandSeries.name')); ?> ||
                <?php echo CHtml::activeHiddenField($detail, "[$i]last_buying_price", array('size' => 5, 'readOnly' => true)); ?>
                <?php echo CHtml::button('Last Buying Price', array(
                    'rel' => $i,
                    'onclick' => '
                        var productId = $("#' . CHtml::activeId($detail, "[$i]product_id") . '").val();
//                        var supplierId = $("#' . CHtml::activeId($purchaseOrder->header, "supplier_id") . '").val();
                        $.fn.yiiGridView.update("product-price-grid", {
                            data: {"ProductPrice[product_id]": productId}
                        });
                        $("#product-price-dialog").dialog("open");
                        $("#DetailIndex").val(' . $i . ');
                        return false;
                    ',
                )); ?>
            </td> 
        </tr>
        <tr>
            <td colspan="2">
                <div class="medium-9 columns">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">Disc Step</label>
                            </div>
                            <div class="small-8 columns">
                                <div class="row">
                                    <div class="small-8 columns">
                                        <?php echo CHtml::activeDropDownList($detail, "[$i]discount_step",
                                            array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5'),
                                            array('prompt' => '[--Select Discount step--]')
                                        ); ?>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
                <td colspan="5">
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
                                            array('prompt' => '[--Select Discount Type--]')
                                        ); ?>
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
                                                        $("#unit_price_after_discount_' . $i . '").html(data.unitPriceAfterDiscountFormatted);
                                                        $("#' . CHtml::activeId($detail, "[$i]unit_price") . '").val(data.unitPriceAfterDiscount);
                                                        $("#sub_total_detail_' . $i . '").html(data.subTotalDetailFormatted);
                                                        $("#' . CHtml::activeId($detail, "[$i]total_price") . '").val(data.subTotalDetail);
                                                        $("#tax_detail_' . $i . '").html(data.taxAmountFormatted);
                                                        $("#' . CHtml::activeId($detail, "[$i]tax_amount") . '").val(data.taxAmount);
                                                        $("#price_before_tax_' . $i . '").html(data.priceBeforeTaxFormatted);
                                                        $("#' . CHtml::activeId($detail, "[$i]price_before_tax") . '").val(data.priceBeforeTax);
                                                        $("#total_before_tax_' . $i . '").html(data.totalPriceBeforeTaxFormatted);
                                                        $("#' . CHtml::activeId($detail, "[$i]total_before_tax") . '").val(data.totalPriceBeforeTax);
                                                        $("#total_quantity_detail_' . $i . '").html(data.totalQuantityDetailFormatted);
                                                        $("#' . CHtml::activeId($detail, "[$i]total_quantity") . '").val(data.totalQuantityDetail);
                                                        $("#total_discount_detail_' . $i . '").html(data.totalDiscountDetailFormatted);
                                                        $("#' . CHtml::activeId($detail, "[$i]discount") . '").val(data.totalDiscountDetail);
                                                        $("#sub_total_before_discount").html(data.subTotalBeforeDiscountFormatted);
                                                        $("#' . CHtml::activeId($purchaseOrder->header, "price_before_discount") . '").val(data.subTotalBeforeDiscount);
                                                        $("#sub_total_discount").html(data.subTotalDiscountFormatted);
                                                        $("#' . CHtml::activeId($purchaseOrder->header, "discount") . '").val(data.subTotalDiscount);
                                                        $("#sub_total").html(data.subTotalFormatted);
                                                        $("#' . CHtml::activeId($purchaseOrder->header, "subtotal") . '").val(data.subTotal);
                                                        $("#total_quantity").html(data.totalQuantityFormatted);
                                                        $("#' . CHtml::activeId($purchaseOrder->header, "total_quantity") . '").val(data.totalQuantity);
                                                        $("#tax_value").html(data.taxValueFormatted);
                                                        $("#' . CHtml::activeId($purchaseOrder->header, "ppn_price") . '").val(data.taxValue);
                                                        $("#grand_total").html(data.grandTotalFormatted);
                                                        $("#' . CHtml::activeId($purchaseOrder->header, "total_price") . '").val(data.grandTotal);
                                                    },
                                                });	
                                            ',
                                        )); ?>
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
                                                        $("#unit_price_after_discount_' . $i . '").html(data.unitPriceAfterDiscountFormatted);
                                                        $("#' . CHtml::activeId($detail, "[$i]unit_price") . '").val(data.unitPriceAfterDiscount);
                                                        $("#sub_total_detail_' . $i . '").html(data.subTotalDetailFormatted);
                                                        $("#' . CHtml::activeId($detail, "[$i]total_price") . '").val(data.subTotalDetail);
                                                        $("#tax_detail_' . $i . '").html(data.taxAmountFormatted);
                                                        $("#' . CHtml::activeId($detail, "[$i]tax_amount") . '").val(data.taxAmount);
                                                        $("#price_before_tax_' . $i . '").html(data.priceBeforeTaxFormatted);
                                                        $("#' . CHtml::activeId($detail, "[$i]price_before_tax") . '").val(data.priceBeforeTax);
                                                        $("#total_before_tax_' . $i . '").html(data.totalPriceBeforeTaxFormatted);
                                                        $("#' . CHtml::activeId($detail, "[$i]total_before_tax") . '").val(data.totalPriceBeforeTax);
                                                        $("#total_quantity_detail_' . $i . '").html(data.totalQuantityDetailFormatted);
                                                        $("#' . CHtml::activeId($detail, "[$i]total_quantity") . '").val(data.totalQuantityDetail);
                                                        $("#total_discount_detail_' . $i . '").html(data.totalDiscountDetailFormatted);
                                                        $("#' . CHtml::activeId($detail, "[$i]discount") . '").val(data.totalDiscountDetail);
                                                        $("#sub_total_before_discount").html(data.subTotalBeforeDiscountFormatted);
                                                        $("#' . CHtml::activeId($purchaseOrder->header, "price_before_discount") . '").val(data.subTotalBeforeDiscount);
                                                        $("#sub_total_discount").html(data.subTotalDiscountFormatted);
                                                        $("#' . CHtml::activeId($purchaseOrder->header, "discount") . '").val(data.subTotalDiscount);
                                                        $("#sub_total").html(data.subTotalFormatted);
                                                        $("#' . CHtml::activeId($purchaseOrder->header, "subtotal") . '").val(data.subTotal);
                                                        $("#total_quantity").html(data.totalQuantityFormatted);
                                                        $("#' . CHtml::activeId($purchaseOrder->header, "total_quantity") . '").val(data.totalQuantity);
                                                        $("#tax_value").html(data.taxValueFormatted);
                                                        $("#' . CHtml::activeId($purchaseOrder->header, "ppn_price") . '").val(data.taxValue);
                                                        $("#grand_total").html(data.grandTotalFormatted);
                                                        $("#' . CHtml::activeId($purchaseOrder->header, "total_price") . '").val(data.grandTotal);
                                                    },
                                                });	
                                            ',
                                        )); ?>
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
                                                        $("#unit_price_after_discount_' . $i . '").html(data.unitPriceAfterDiscountFormatted);
                                                        $("#' . CHtml::activeId($detail, "[$i]unit_price") . '").val(data.unitPriceAfterDiscount);
                                                        $("#sub_total_detail_' . $i . '").html(data.subTotalDetailFormatted);
                                                        $("#' . CHtml::activeId($detail, "[$i]total_price") . '").val(data.subTotalDetail);
                                                        $("#tax_detail_' . $i . '").html(data.taxAmountFormatted);
                                                        $("#' . CHtml::activeId($detail, "[$i]tax_amount") . '").val(data.taxAmount);
                                                        $("#price_before_tax_' . $i . '").html(data.priceBeforeTaxFormatted);
                                                        $("#' . CHtml::activeId($detail, "[$i]price_before_tax") . '").val(data.priceBeforeTax);
                                                        $("#total_before_tax_' . $i . '").html(data.totalPriceBeforeTaxFormatted);
                                                        $("#' . CHtml::activeId($detail, "[$i]total_before_tax") . '").val(data.totalPriceBeforeTax);
                                                        $("#total_quantity_detail_' . $i . '").html(data.totalQuantityDetailFormatted);
                                                        $("#' . CHtml::activeId($detail, "[$i]total_quantity") . '").val(data.totalQuantityDetail);
                                                        $("#total_discount_detail_' . $i . '").html(data.totalDiscountDetailFormatted);
                                                        $("#' . CHtml::activeId($detail, "[$i]discount") . '").val(data.totalDiscountDetail);
                                                        $("#sub_total_before_discount").html(data.subTotalBeforeDiscountFormatted);
                                                        $("#' . CHtml::activeId($purchaseOrder->header, "price_before_discount") . '").val(data.subTotalBeforeDiscount);
                                                        $("#sub_total_discount").html(data.subTotalDiscountFormatted);
                                                        $("#' . CHtml::activeId($purchaseOrder->header, "discount") . '").val(data.subTotalDiscount);
                                                        $("#sub_total").html(data.subTotalFormatted);
                                                        $("#' . CHtml::activeId($purchaseOrder->header, "subtotal") . '").val(data.subTotal);
                                                        $("#total_quantity").html(data.totalQuantityFormatted);
                                                        $("#' . CHtml::activeId($purchaseOrder->header, "total_quantity") . '").val(data.totalQuantity);
                                                        $("#tax_value").html(data.taxValueFormatted);
                                                        $("#' . CHtml::activeId($purchaseOrder->header, "ppn_price") . '").val(data.taxValue);
                                                        $("#grand_total").html(data.grandTotalFormatted);
                                                        $("#' . CHtml::activeId($purchaseOrder->header, "total_price") . '").val(data.grandTotal);
                                                    },
                                                });	
                                            ',
                                        )); ?>
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
                                                        $("#unit_price_after_discount_' . $i . '").html(data.unitPriceAfterDiscountFormatted);
                                                        $("#' . CHtml::activeId($detail, "[$i]unit_price") . '").val(data.unitPriceAfterDiscount);
                                                        $("#sub_total_detail_' . $i . '").html(data.subTotalDetailFormatted);
                                                        $("#' . CHtml::activeId($detail, "[$i]total_price") . '").val(data.subTotalDetail);
                                                        $("#tax_detail_' . $i . '").html(data.taxAmountFormatted);
                                                        $("#' . CHtml::activeId($detail, "[$i]tax_amount") . '").val(data.taxAmount);
                                                        $("#price_before_tax_' . $i . '").html(data.priceBeforeTaxFormatted);
                                                        $("#' . CHtml::activeId($detail, "[$i]price_before_tax") . '").val(data.priceBeforeTax);
                                                        $("#total_before_tax_' . $i . '").html(data.totalPriceBeforeTaxFormatted);
                                                        $("#' . CHtml::activeId($detail, "[$i]total_before_tax") . '").val(data.totalPriceBeforeTax);
                                                        $("#total_quantity_detail_' . $i . '").html(data.totalQuantityDetailFormatted);
                                                        $("#' . CHtml::activeId($detail, "[$i]total_quantity") . '").val(data.totalQuantityDetail);
                                                        $("#total_discount_detail_' . $i . '").html(data.totalDiscountDetailFormatted);
                                                        $("#' . CHtml::activeId($detail, "[$i]discount") . '").val(data.totalDiscountDetail);
                                                        $("#sub_total_before_discount").html(data.subTotalBeforeDiscountFormatted);
                                                        $("#' . CHtml::activeId($purchaseOrder->header, "price_before_discount") . '").val(data.subTotalBeforeDiscount);
                                                        $("#sub_total_discount").html(data.subTotalDiscountFormatted);
                                                        $("#' . CHtml::activeId($purchaseOrder->header, "discount") . '").val(data.subTotalDiscount);
                                                        $("#sub_total").html(data.subTotalFormatted);
                                                        $("#' . CHtml::activeId($purchaseOrder->header, "subtotal") . '").val(data.subTotal);
                                                        $("#total_quantity").html(data.totalQuantityFormatted);
                                                        $("#' . CHtml::activeId($purchaseOrder->header, "total_quantity") . '").val(data.totalQuantity);
                                                        $("#tax_value").html(data.taxValueFormatted);
                                                        $("#' . CHtml::activeId($purchaseOrder->header, "ppn_price") . '").val(data.taxValue);
                                                        $("#grand_total").html(data.grandTotalFormatted);
                                                        $("#' . CHtml::activeId($purchaseOrder->header, "total_price") . '").val(data.grandTotal);
                                                    },
                                                });	
                                            ',
                                        )); ?>
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
                                                        $("#unit_price_after_discount_' . $i . '").html(data.unitPriceAfterDiscountFormatted);
                                                        $("#' . CHtml::activeId($detail, "[$i]unit_price") . '").val(data.unitPriceAfterDiscount);
                                                        $("#sub_total_detail_' . $i . '").html(data.subTotalDetailFormatted);
                                                        $("#' . CHtml::activeId($detail, "[$i]total_price") . '").val(data.subTotalDetail);
                                                        $("#tax_detail_' . $i . '").html(data.taxAmountFormatted);
                                                        $("#' . CHtml::activeId($detail, "[$i]tax_amount") . '").val(data.taxAmount);
                                                        $("#price_before_tax_' . $i . '").html(data.priceBeforeTaxFormatted);
                                                        $("#' . CHtml::activeId($detail, "[$i]price_before_tax") . '").val(data.priceBeforeTax);
                                                        $("#total_before_tax_' . $i . '").html(data.totalPriceBeforeTaxFormatted);
                                                        $("#' . CHtml::activeId($detail, "[$i]total_before_tax") . '").val(data.totalPriceBeforeTax);
                                                        $("#total_quantity_detail_' . $i . '").html(data.totalQuantityDetailFormatted);
                                                        $("#' . CHtml::activeId($detail, "[$i]total_quantity") . '").val(data.totalQuantityDetail);
                                                        $("#total_discount_detail_' . $i . '").html(data.totalDiscountDetailFormatted);
                                                        $("#' . CHtml::activeId($detail, "[$i]discount") . '").val(data.totalDiscountDetail);
                                                        $("#sub_total_before_discount").html(data.subTotalBeforeDiscountFormatted);
                                                        $("#' . CHtml::activeId($purchaseOrder->header, "price_before_discount") . '").val(data.subTotalBeforeDiscount);
                                                        $("#sub_total_discount").html(data.subTotalDiscountFormatted);
                                                        $("#' . CHtml::activeId($purchaseOrder->header, "discount") . '").val(data.subTotalDiscount);
                                                        $("#sub_total").html(data.subTotalFormatted);
                                                        $("#' . CHtml::activeId($purchaseOrder->header, "subtotal") . '").val(data.subTotal);
                                                        $("#total_quantity").html(data.totalQuantityFormatted);
                                                        $("#' . CHtml::activeId($purchaseOrder->header, "total_quantity") . '").val(data.totalQuantity);
                                                        $("#tax_value").html(data.taxValueFormatted);
                                                        $("#' . CHtml::activeId($purchaseOrder->header, "ppn_price") . '").val(data.taxValue);
                                                        $("#grand_total").html(data.grandTotalFormatted);
                                                        $("#' . CHtml::activeId($purchaseOrder->header, "total_price") . '").val(data.grandTotal);
                                                    },
                                                });	
                                            ',
                                        )); ?>
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
                </div>
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td style="text-align:right">Price After Discount</td>
            <td style="text-align:right">
                <?php echo CHtml::activeHiddenField($detail, "[$i]unit_price"); ?>
                <span id="unit_price_after_discount_<?php echo $i; ?>">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'unit_price'))); ?>
                </span>
            </td>
            <td colspan="2" style="text-align:right">DPP</td>
            <td style="text-align:right">
                <?php echo CHtml::activeHiddenField($detail, "[$i]price_before_tax"); ?>
                <span id="price_before_tax_<?php echo $i; ?>">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->price_before_tax)); ?>
                </span>
            </td>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
            <td  colspan="2" style="text-align:right">Total DPP</td>
            <td style="text-align:right">
                <?php echo CHtml::activeHiddenField($detail, "[$i]total_before_tax"); ?>
                <span id="total_before_tax_<?php echo $i; ?>">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->total_before_tax)); ?>
                </span>
            </td>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td style="text-align:right">Total Discount</td>
            <td style="text-align:right">
                <?php echo CHtml::activeHiddenField($detail, "[$i]discount"); ?>
                <span id="total_discount_detail_<?php echo $i; ?>">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'discount'))); ?>
                </span>
            </td>
            <td colspan="2" style="text-align:right">PPN</td>
            <td style="text-align:right">
                <?php echo CHtml::activeHiddenField($detail, "[$i]tax_amount"); ?>
                <span id="tax_detail_<?php echo $i; ?>">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->getTaxAmount($purchaseOrder->header->ppn, $purchaseOrder->header->tax_percentage))); ?>
                </span>
            </td>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td style="text-align:right">Total Quantity</td>
            <td style="text-align:right">
                <?php echo CHtml::activeHiddenField($detail, "[$i]total_quantity"); ?>
                <span id="total_quantity_detail_<?php echo $i; ?>">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'total_quantity'))); ?>
                </span>
            </td>
            <td colspan="2" style="text-align:right">Sub Total (DPP + PPN)</td>
            <td style="text-align:right">
                <?php echo CHtml::activeHiddenField($detail, "[$i]total_price"); ?>
                <span id="sub_total_detail_<?php echo $i; ?>">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->total_price)); ?>
                </span>
            </td>
            <td colspan="2">&nbsp;</td>
        </tr>
    </tfoot>
</table>

<?php Yii::app()->clientScript->registerScript('myjqueryCount' . $i, '
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
        } else if (stepbtn' . $i . ' == 3 ) {
            $("#TransactionPurchaseOrderDetail_' . $i . '_quantity,#TransactionPurchaseOrderDetail_' . $i . '_discount1_nominal,#TransactionPurchaseOrderDetail_' . $i . '_discount2_nominal,#TransactionPurchaseOrderDetail_' . $i . '_discount3_nominal").keyup(function(event){
                $("#count_step1_' . $i . '").click();
                $("#count_step2_' . $i . '").click();
                $("#count_step3_' . $i . '").click();
            });
        } else if (stepbtn' . $i . ' == 4 ) {
            $("#TransactionPurchaseOrderDetail_' . $i . '_quantity,#TransactionPurchaseOrderDetail_' . $i . '_discount1_nominal,#TransactionPurchaseOrderDetail_' . $i . '_discount2_nominal,#TransactionPurchaseOrderDetail_' . $i . '_discount3_nominal,#TransactionPurchaseOrderDetail_' . $i . '_discount4_nominal").keyup(function(event){
                $("#count_step1_' . $i . '").click();
                $("#count_step2_' . $i . '").click();
                $("#count_step3_' . $i . '").click();
                $("#count_step4_' . $i . '").click();
            });
        } else if (stepbtn' . $i . ' == 5) {
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
'); ?>