<table>
    <thead>
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Unit</th>
            <th>Selling Price</th>
            <th>Rec Sell Price</th>
            <th>Unit Price</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <?php echo CHtml::activeHiddenField($detail, "[$i]product_id", array('size'=>20,'maxlength'=>20)); ?>
                <?php echo CHtml::activeTextField($detail,"[$i]product_name",array(
                    'size'=>15,
                    'maxlength'=>10,
                    'readonly'=>true,
                    'value' => $detail->product_id == "" ? '': Product::model()->findByPk($detail->product_id)->name
                    )
                ); ?>
                <?php echo CHtml::error($detail, 'product_id'); ?>
            </td>
            <td>
                <?php echo CHtml::activeTextField($detail,"[$i]quantity", array('size' => 5,
                    'onchange' => '
                        $.ajax({
                            type: "POST",
                            dataType: "JSON",
                            url: "' . CController::createUrl('ajaxJsonTotal', array('id' => $salesOrder->header->id, 'index' => $i)) . '",
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
                <?php echo CHtml::error($detail, 'quantity'); ?>
            </td>
            <td>
                <?php $unit = Unit::model()->findByPk($detail->unit_id); ?>
                <?php echo CHtml::activeHiddenField($detail, "[$i]unit_id"); ?>
                <?php echo CHtml::encode(CHtml::value($unit, 'name')); ?>
                <?php echo CHtml::error($detail, 'unit_id'); ?>
            </td>
            <td>
                <?php echo CHtml::activeTextField($detail,"[$i]retail_price", array('size' => 5,
                    'onchange' => '
                        $.ajax({
                            type: "POST",
                            dataType: "JSON",
                            url: "' . CController::createUrl('ajaxJsonTotal', array('id' => $salesOrder->header->id, 'index' => $i)) . '",
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
            </td>
            <td>
                <?php echo CHtml::activeHiddenField($detail,"[$i]hpp",array('readonly'=>true, 'value'=>$detail->product_id !="" ? Product::model()->findByPk($detail->product_id)->hpp:'0')); ?>
                <?php $product = Product::model()->findByPk($detail->product_id); ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($product, 'recommended_selling_price'))); ?>
            </td>
            <td>
                <?php echo CHtml::activeHiddenField($detail,"[$i]unit_price",array('readonly'=>true, ));?>
                <span id="unit_price_detail_<?php echo $i; ?>">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'unitPrice'))); ?>
                </span>
            </td>
            <td width="5%">
                <?php echo CHtml::button('X', array(
                    'onclick' => CHtml::ajax(array(
                        'type' => 'POST',
                        'url' => CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $salesOrder->header->id, 'index' => $i)),
                        'update' => '#detail',
                    )),
                )); ?>
            </td>
        </tr>
        <tr>
            <td colspan="7">
                Manufacture Code: <?php echo CHtml::Encode(CHtml::value($detail, 'product.manufacturer_code')); ?> ||
                Brand: <?php echo CHtml::Encode(CHtml::value($detail, 'product.brand.name')); ?> ||
                Sub Brand: <?php echo CHtml::Encode(CHtml::value($detail, 'product.subBrand.name')); ?> ||
                Brand Series: <?php echo CHtml::Encode(CHtml::value($detail, 'product.subBrandSeries.name')); ?>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="medium-6 columns">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-8 columns">
                                <?php echo CHtml::activeDropDownList($detail, "[$i]discount_step", array(
                                    '1' => '1', '2' => '2','3'=>'3','4'=>'4','5'=>'5'
                                ),array(
                                    'prompt'=>'[--Select Discount step--]')
                                ); ?>
                            </div>
                            <div class="small-2 columns">
                                <?php echo CHtml::button('Add', array(
                                    'id'=>'add'.$i,
                                    'onclick' => '
                                        var step = +jQuery("#TransactionSalesOrderDetail_'.$i.'_discount_step").val();
                                        stepbtn'.$i.' = step;
                                        switch (step) {
                                            case 1:
                                            $("#step1_'.$i.'").show();
                                            $("#step2_'.$i.'").hide();
                                            $("#step3_'.$i.'").hide();
                                            $("#step4_'.$i.'").hide();
                                            $("#step5_'.$i.'").hide();
                                            break;
                                            case 2:
                                            $("#step1_'.$i.'").show();
                                            $("#step2_'.$i.'").show();
                                            $("#step3_'.$i.'").hide();
                                            $("#step4_'.$i.'").hide();
                                            $("#step5_'.$i.'").hide();
                                            break;
                                            case 3:
                                            $("#step1_'.$i.'").show();
                                            $("#step2_'.$i.'").show();
                                            $("#step3_'.$i.'").show();
                                            $("#step4_'.$i.'").hide();
                                            $("#step5_'.$i.'").hide();
                                            break;
                                            case 4:
                                            $("#step1_'.$i.'").show();
                                            $("#step2_'.$i.'").show();
                                            $("#step3_'.$i.'").show();
                                            $("#step4_'.$i.'").show();
                                            $("#step5_'.$i.'").hide();
                                            break;
                                            case 5:
                                            $("#step1_'.$i.'").show();
                                            $("#step2_'.$i.'").show();
                                            $("#step3_'.$i.'").show();
                                            $("#step4_'.$i.'").show();
                                            $("#step5_'.$i.'").show();
                                            break;

                                            default:
                                            $("#step1_'.$i.'").hide();
                                            $("#step2_'.$i.'").hide();
                                            $("#step3_'.$i.'").hide();
                                            $("#step4_'.$i.'").hide();
                                            $("#step5_'.$i.'").hide();

                                            break;
                                        }
                                    '
                                )); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
            <td colspan="5">
                <!-- //step1 -->
                <div class="field" id="step1_<?php echo $i; ?>">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix">Step 1</label>
                        </div>
                        <div class="small-8 columns">
                            <div class="row">
                                <div class="small-3 columns">
                                    <?php echo CHtml::activeDropDownList($detail, "[$i]discount1_type", array('1' => '%','2' => 'Amount','3'=>'Bonus'),array('prompt'=>'[--Select Discount Type--]'));?>
                                </div>
                                <div class="small-3 columns">
                                    <?php echo CHtml::activeTextField($detail,"[$i]discount1_nominal", array(
                                        'onchange' => '
                                            $.ajax({
                                                type: "POST",
                                                dataType: "JSON",
                                                url: "' . CController::createUrl('ajaxJsonTotal', array('id' => $salesOrder->header->id, 'index' => $i)) . '",
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
                                </div>
                                <div class="small-3 columns">
                                    <?php echo CHtml::activeHiddenField($detail,"[$i]discount1_temp_price",array('readonly'=>true)); ?>
                                    <span id="discount_1_nominal_<?php echo $i; ?>">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->getDiscount1Amount())); ?>
                                    </span>
                                </div>
                                <div class="small-3 columns">
                                    <?php echo CHtml::activeHiddenField($detail,"[$i]discount1_temp_quantity",array('readonly'=>true)); ?>
                                    <span id="price_after_discount_1_<?php echo $i; ?>">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->getUnitPriceAfterDiscount1())); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- //step2 -->
                <div class="field" id="step2_<?php echo $i; ?>">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix">Step 2</label>
                        </div>
                        <div class="small-8 columns">
                            <div class="row">
                                <div class="small-3 columns">
                                    <?php echo CHtml::activeDropDownList($detail, "[$i]discount2_type", array('1' => '%', '2' => 'Amount','3'=>'Bonus'),array('prompt'=>'[--Select Discount Type--]'));?>
                                </div>
                                <div class="small-3 columns">
                                    <?php echo CHtml::activeTextField($detail,"[$i]discount2_nominal", array(
                                        'onchange' => '
                                            $.ajax({
                                                type: "POST",
                                                dataType: "JSON",
                                                url: "' . CController::createUrl('ajaxJsonTotal', array('id' => $salesOrder->header->id, 'index' => $i)) . '",
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
                                </div>
                                <div class="small-3 columns">
                                    <?php echo CHtml::activeHiddenField($detail,"[$i]discount2_temp_price",array('readonly'=>true)); ?>
                                    <span id="discount_2_nominal_<?php echo $i; ?>">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->getDiscount2Amount())); ?>
                                    </span>
                                </div>
                                <div class="small-3 columns">
                                    <?php echo CHtml::activeHiddenField($detail,"[$i]discount2_temp_quantity",array('readonly'=>true)); ?>
                                    <span id="price_after_discount_2_<?php echo $i; ?>">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->getUnitPriceAfterDiscount2())); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- //step3 -->
                <div class="field" id="step3_<?php echo $i; ?>">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix">Step 3</label>
                        </div>
                        <div class="small-8 columns">
                            <div class="row">
                                <div class="small-3 columns">
                                    <?php echo CHtml::activeDropDownList($detail, "[$i]discount3_type", array('1' => '%', '2' => 'Amount','3'=>'Bonus'),array('prompt'=>'[--Select Discount Type--]'));?>
                                </div>
                                <div class="small-3 columns">
                                    <?php echo CHtml::activeTextField($detail,"[$i]discount3_nominal", array(
                                        'onchange' => '
                                            $.ajax({
                                                type: "POST",
                                                dataType: "JSON",
                                                url: "' . CController::createUrl('ajaxJsonTotal', array('id' => $salesOrder->header->id, 'index' => $i)) . '",
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
                                </div>
                                <div class="small-3 columns">
                                    <?php echo CHtml::activeHiddenField($detail,"[$i]discount3_temp_price",array('readonly'=>true, )); ?>
                                    <span id="discount_3_nominal_<?php echo $i; ?>">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->getDiscount3Amount())); ?>
                                    </span>
                                </div>
                                <div class="small-3 columns">
                                    <?php echo CHtml::activeHiddenField($detail,"[$i]discount3_temp_quantity",array('readonly'=>true)); ?>
                                    <span id="price_after_discount_3_<?php echo $i; ?>">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->getUnitPriceAfterDiscount3())); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- //step4 -->
                <div class="field" id="step4_<?php echo $i; ?>">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix">Step 4</label>
                        </div>
                        <div class="small-8 columns">
                            <div class="row">
                                <div class="small-3 columns">
                                    <?php echo CHtml::activeDropDownList($detail, "[$i]discount4_type", array('1' => '%','2' => 'Amount','3'=>'Bonus'),array('prompt'=>'[--Select Discount Type--]'));?>
                                </div>
                                <div class="small-3 columns">
                                    <?php echo CHtml::activeTextField($detail,"[$i]discount4_nominal", array(
                                        'onchange' => '
                                            $.ajax({
                                                type: "POST",
                                                dataType: "JSON",
                                                url: "' . CController::createUrl('ajaxJsonTotal', array('id' => $salesOrder->header->id, 'index' => $i)) . '",
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
                                </div>
                                <div class="small-3 columns">
                                    <?php echo CHtml::activeHiddenField($detail,"[$i]discount4_temp_price",array('readonly'=>true, )); ?>
                                    <span id="discount_4_nominal_<?php echo $i; ?>">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->getDiscount4Amount())); ?>
                                    </span>
                                </div>
                                <div class="small-3 columns">
                                    <?php echo CHtml::activeHiddenField($detail,"[$i]discount4_temp_quantity",array('readonly'=>true)); ?>
                                    <span id="price_after_discount_4_<?php echo $i; ?>">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->getUnitPriceAfterDiscount4())); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- //spte 5 -->
                <div class="field" id="step5_<?php echo $i; ?>">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix">Step 5</label>
                        </div>
                        <div class="small-8 columns">
                            <div class="row">
                                <div class="small-3 columns">
                                    <?php echo CHtml::activeDropDownList($detail, "[$i]discount5_type", array('1' => '%','2' => 'Amount','3'=>'Bonus'),array('prompt'=>'[--Select Discount Type--]'));?>
                                </div>
                                <div class="small-3 columns">
                                    <?php echo CHtml::activeTextField($detail,"[$i]discount5_nominal", array(
                                        'onchange' => '
                                            $.ajax({
                                                type: "POST",
                                                dataType: "JSON",
                                                url: "' . CController::createUrl('ajaxJsonTotal', array('id' => $salesOrder->header->id, 'index' => $i)) . '",
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
                                </div>
                                <div class="small-3 columns">
                                    <?php echo CHtml::activeHiddenField($detail,"[$i]discount5_temp_price",array('readonly'=>true, )); ?>
                                    <span id="discount_5_nominal_<?php echo $i; ?>">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->getDiscount5Amount())); ?>
                                    </span>
                                </div>
                                <div class="small-3 columns">
                                    <?php echo CHtml::activeHiddenField($detail,"[$i]discount5_temp_quantity",array('readonly'=>true)); ?>
                                    <span id="price_after_discount_5_<?php echo $i; ?>">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->getUnitPriceAfterDiscount5())); ?>
                                    </span>
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
            <td>Total Qty</td>
            <td>
                <span id="total_quantity_detail_<?php echo $i; ?>">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'totalQuantity'))); ?>
                </span>
            </td>
            <td colspan="3">Sub Total</td>
            <td style="text-align:right">
                <span id="sub_total_detail_<?php echo $i; ?>">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'subTotal'))); ?>
                </span>
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Total Disc</td>
            <td>
                <span id="total_discount_detail_<?php echo $i; ?>">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'totalDiscount'))); ?>
                </span>
            </td>
            <td colspan="3">PPn</td>
            <td style="text-align:right">
                <span id="tax_detail_<?php echo $i; ?>">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->tax_amount)); ?>
                </span>
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
            <td colspan="3">Grand Total</td>
            <td style="text-align:right">
                <span id="grand_total_detail_<?php echo $i; ?>">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'grandTotal'))); ?>
                </span>
            </td>
            <td>&nbsp;</td>
        </tr>
    </tfoot>
</table>

<?php Yii::app()->clientScript->registerScript('myjqueryCount'.$i,'

    function callme_stepbtn() {
        if (stepbtn'.$i.' == 1 ) {
			$("#TransactionSalesOrderDetail_'.$i.'_quantity,#TransactionSalesOrderDetail_'.$i.'_discount1_nominal").keyup(function(event){
				$("#count_step1_'.$i.'").click();
			});
		}else if (stepbtn'.$i.' == 2 ) {
			$("#TransactionSalesOrderDetail_'.$i.'_quantity,#TransactionSalesOrderDetail_'.$i.'_discount1_nominal,#TransactionSalesOrderDetail_'.$i.'_discount2_nominal").keyup(function(event){
				$("#count_step1_'.$i.'").click();
				$("#count_step2_'.$i.'").click();
			});
		}else if (stepbtn'.$i.' == 3 ) {
			$("#TransactionSalesOrderDetail_'.$i.'_quantity,#TransactionSalesOrderDetail_'.$i.'_discount1_nominal,#TransactionSalesOrderDetail_'.$i.'_discount2_nominal,#TransactionSalesOrderDetail_'.$i.'_discount3_nominal").keyup(function(event){
				$("#count_step1_'.$i.'").click();
				$("#count_step2_'.$i.'").click();
				$("#count_step3_'.$i.'").click();
			});
		}else if (stepbtn'.$i.' == 4 ) {
			$("#TransactionSalesOrderDetail_'.$i.'_quantity,#TransactionSalesOrderDetail_'.$i.'_discount1_nominal,#TransactionSalesOrderDetail_'.$i.'_discount2_nominal,#TransactionSalesOrderDetail_'.$i.'_discount3_nominal,#TransactionSalesOrderDetail_'.$i.'_discount4_nominal").keyup(function(event){
				$("#count_step1_'.$i.'").click();
				$("#count_step2_'.$i.'").click();
				$("#count_step3_'.$i.'").click();
				$("#count_step4_'.$i.'").click();
			});
		}else if (stepbtn'.$i.' == 5) {
			$("#TransactionSalesOrderDetail_'.$i.'_quantity,#TransactionSalesOrderDetail_'.$i.'_discount1_nominal,#TransactionSalesOrderDetail_'.$i.'_discount2_nominal,#TransactionSalesOrderDetail_'.$i.'_discount3_nominal,#TransactionSalesOrderDetail_'.$i.'_discount4_nominal,#TransactionSalesOrderDetail_'.$i.'_discount5_nominal").keyup(function(event){
				$("#count_step1_'.$i.'").click();
				$("#count_step2_'.$i.'").click();
				$("#count_step3_'.$i.'").click();
				$("#count_step4_'.$i.'").click();
				$("#count_step5_'.$i.'").click();
			});
		}
		// $("#count_'.$i.'").click();
    }

	$("#TransactionSalesOrderDetail_'.$i.'_quantity,#TransactionSalesOrderDetail_'.$i.'_discount1_nominal,#TransactionSalesOrderDetail_'.$i.'_discount2_nominal,#TransactionSalesOrderDetail_'.$i.'_discount3_nominal,#TransactionSalesOrderDetail_'.$i.'_discount4_nominal,#TransactionSalesOrderDetail_'.$i.'_discount5_nominal,#TransactionSalesOrderDetail_'.$i.'_discount_step").keyup(function(event){
		callme_stepbtn();
	});

	$("#add'.$i.'").click(function() {
		callme_stepbtn();
	});
' ); ?>


<?php Yii::app()->clientScript->registerScript(
    'myjavascript', 
    '$(".numbers").number( true,2, ".", ",");', 
    CClientScript::POS_END
); ?>