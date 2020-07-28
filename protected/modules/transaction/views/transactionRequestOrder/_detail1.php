<table>
    <thead>
        <tr>
            <td>Quantity</td>
            <td>Unit</td>
            <td>Estimate Arrival Date</td>
            <td>Last Buying Price</td>
            <td>Retail Price</td>
            <td>Unit Price</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <?php echo CHtml::activeTextField($detail, "[$i]quantity", array(
                    'onchange' => '
                        $.ajax({
                            type: "POST",
                            dataType: "JSON",
                            url: "' . CController::createUrl('ajaxJsonTotal', array('id' => $requestOrder->header->id, 'index' => $i)) . '",
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
                                $("#sub_total").html(data.subTotal);
                                $("#total_quantity").html(data.totalQuantity);
                            },
                        });	
                    ',
                )); ?>
            </td>
            <td style="text-align: right">
                <?php echo CHtml::activeHiddenField($detail, "[$i]unit_id"); ?>
                <span id="unit_name_<?php echo $i; ?>">
                    <?php echo CHtml::encode(CHtml::value($detail, 'unit.name')); ?>
                </span>
            </td>
            <td>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $detail,
                    'attribute' => "[$i]estimated_arrival_date",
                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                        'showAnim' => 'fold',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                    ),
                )); ?>
            </td>
            <td>
                <?php echo CHtml::activeTextField($detail, "[$i]last_buying_price", array()); ?>
                <?php echo CHtml::button('$$', array(
                    'rel' => $i,
                    'onclick' => '
                        currentPrice=$(this).attr("rel"); 
                        var productname = $("#TransactionRequestOrderDetail_' . $i . '_product_name").val();
                        var suppliername = $("#TransactionRequestOrderDetail_' . $i . '_supplier_name").val();
                        // console.log(myArray["S"+currentSupplier]);
                        // console.log(suppliername);
                        $.fn.yiiGridView.update("price-grid", {
                            data: {"ProductPrice[product_name]": productname, "ProductPrice[supplier_name]": suppliername}
                        });
                        $("#price-dialog").dialog("open");
                        return false;
                    ',
                )); ?>
            </td>
            <td>
                <?php echo CHtml::activeTextField($detail, "[$i]retail_price", array(
                    'value' => intval($detail->retail_price),
                    'onchange' => '
                        $.ajax({
                            type: "POST",
                            dataType: "JSON",
                            url: "' . CController::createUrl('ajaxJsonTotal', array('id' => $requestOrder->header->id, 'index' => $i)) . '",
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
                                $("#sub_total").html(data.subTotal);
                                $("#total_quantity").html(data.totalQuantity);
                            },
                        });	
                    ',
                )); ?>
            </td>
            <td>
                <?php //echo CHtml::activeHiddenField($detail, "[$i]unit_price"); ?>
                <span id="unit_price_detail_<?php echo $i; ?>">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'unitPrice'))); ?>
                </span>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <div class="medium-6 columns">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">Discount Step</label>
                            </div>
                            <div class="small-8 columns">
                                <div class="row">
                                    <div class="small-8 columns">
                                        <?php echo CHtml::activeDropDownList($detail, "[$i]discount_step",
                                            array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5'),
                                            array('prompt' => '[--Select Discount step--]')); ?>
                                    </div>
                                    <div class="small-4 columns">
                                        <?php echo CHtml::button('Add', array(
                                            'id' => 'add' . $i,
                                            'onclick' => '
                                                var step = +jQuery("#TransactionRequestOrderDetail_' . $i . '_discount_step").val();
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
                                                }
                                            '
                                        )); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
                <td colspan="3">
                    <!-- // step 1 -->
                    <div class="field" id="step1_<?php echo $i; ?>">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">Step 1</label>
                            </div>
                            <div class="small-8 columns">
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
                                                    url: "' . CController::createUrl('ajaxJsonTotal', array('id' => $requestOrder->header->id, 'index' => $i)) . '",
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
                                                        $("#sub_total").html(data.subTotal);
                                                        $("#total_quantity").html(data.totalQuantity);
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

                    <!-- // step 2 -->
                    <div class="field" id="step2_<?php echo $i; ?>">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">Step 2</label>
                            </div>
                            <div class="small-8 columns">
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
                                                    url: "' . CController::createUrl('ajaxJsonTotal', array('id' => $requestOrder->header->id, 'index' => $i)) . '",
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
                                                        $("#sub_total").html(data.subTotal);
                                                        $("#total_quantity").html(data.totalQuantity);
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

                    <!-- // step 3  -->
                    <div class="field" id="step3_<?php echo $i; ?>">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">Step 3</label>
                            </div>
                            <div class="small-8 columns">
                                <div class="row">
                                    <div class="small-3 columns">
                                        <?php echo CHtml::activeDropDownList($detail, "[$i]discount3_type",
                                            array('1' => 'Percent', '2' => 'Amount', '3' => 'Bonus'),
                                            array('prompt' => '[--Select Discount Type--]')); ?>
                                    </div>
                                    <div class="small-3 columns">
                                        <?php echo CHtml::activeTextField($detail, "[$i]discount3_nominal", array(
                                            'onchange' => '
                                                $.ajax({
                                                    type: "POST",
                                                    dataType: "JSON",
                                                    url: "' . CController::createUrl('ajaxJsonTotal', array('id' => $requestOrder->header->id, 'index' => $i)) . '",
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
                                                        $("#sub_total").html(data.subTotal);
                                                        $("#total_quantity").html(data.totalQuantity);
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

                    <!-- // step 4 -->
                    <div class="field" id="step4_<?php echo $i; ?>">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">Step 4</label>
                            </div>
                            <div class="small-8 columns">
                                <div class="row">
                                    <div class="small-3 columns">
                                        <?php echo CHtml::activeDropDownList($detail, "[$i]discount4_type",
                                            array('1' => 'Percent', '2' => 'Amount', '3' => 'Bonus'),
                                            array('prompt' => '[--Select Discount Type--]')); ?>
                                    </div>
                                    <div class="small-3 columns">
                                        <?php echo CHtml::activeTextField($detail, "[$i]discount4_nominal", array(
                                            'onchange' => '
                                                $.ajax({
                                                    type: "POST",
                                                    dataType: "JSON",
                                                    url: "' . CController::createUrl('ajaxJsonTotal', array('id' => $requestOrder->header->id, 'index' => $i)) . '",
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
                                                        $("#sub_total").html(data.subTotal);
                                                        $("#total_quantity").html(data.totalQuantity);
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

                    <!-- // step 5 -->
                    <div class="field" id="step5_<?php echo $i; ?>">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">Step 5</label>
                            </div>
                            <div class="small-8 columns">
                                <div class="row">
                                    <div class="small-3 columns">
                                        <?php echo CHtml::activeDropDownList($detail, "[$i]discount5_type",
                                            array('1' => 'Percent', '2' => 'Amount', '3' => 'Bonus'),
                                            array('prompt' => '[--Select Discount Type--]')); ?>
                                    </div>
                                    <div class="small-3 columns">
                                        <?php echo CHtml::activeTextField($detail, "[$i]discount5_nominal", array(
                                            'onchange' => '
                                                $.ajax({
                                                    type: "POST",
                                                    dataType: "JSON",
                                                    url: "' . CController::createUrl('ajaxJsonTotal', array('id' => $requestOrder->header->id, 'index' => $i)) . '",
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
                                                        $("#sub_total").html(data.subTotal);
                                                        $("#total_quantity").html(data.totalQuantity);
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
            <td colspan="2">Total Quantity</td>
            <td>
                <span id="total_quantity_detail_<?php echo $i; ?>">
                    <?php echo CHtml::activeHiddenField($detail, "[$i]total_quantity", array('readonly' => true)); ?>
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'quantityAfterBonus'))); ?>
                </span>
            </td>
            <td colspan="2">Sub Total</td>
            <td>
                <?php echo CHtml::activeHiddenField($detail, "[$i]total_price", array('readonly' => true,)); ?>
                <span id="sub_total_detail_<?php echo $i; ?>">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'subTotal'))); ?>
                </span>
            </td>
        </tr>
    </tfoot>
</table>

<?php Yii::app()->clientScript->registerScript('myjqueryCount' . $i, '

    function callme_stepbtn() {
        if (stepbtn' . $i . ' == 1 ) {
			$("#TransactionRequestOrderDetail_' . $i . '_quantity,#TransactionRequestOrderDetail_' . $i . '_discount1_nominal").keyup(function(event){
				$("#count_step1_' . $i . '").click();
			});
		}else if (stepbtn' . $i . ' == 2 ) {
			$("#TransactionRequestOrderDetail_' . $i . '_quantity,#TransactionRequestOrderDetail_' . $i . '_discount1_nominal,#TransactionRequestOrderDetail_' . $i . '_discount2_nominal").keyup(function(event){
				$("#count_step1_' . $i . '").click();
				$("#count_step2_' . $i . '").click();
			});
		}else if (stepbtn' . $i . ' == 3 ) {
			$("#TransactionRequestOrderDetail_' . $i . '_quantity,#TransactionRequestOrderDetail_' . $i . '_discount1_nominal,#TransactionRequestOrderDetail_' . $i . '_discount2_nominal,#TransactionRequestOrderDetail_' . $i . '_discount3_nominal").keyup(function(event){
				$("#count_step1_' . $i . '").click();
				$("#count_step2_' . $i . '").click();
				$("#count_step3_' . $i . '").click();
			});
		}else if (stepbtn' . $i . ' == 4 ) {
			$("#TransactionRequestOrderDetail_' . $i . '_quantity,#TransactionRequestOrderDetail_' . $i . '_discount1_nominal,#TransactionRequestOrderDetail_' . $i . '_discount2_nominal,#TransactionRequestOrderDetail_' . $i . '_discount3_nominal,#TransactionRequestOrderDetail_' . $i . '_discount4_nominal").keyup(function(event){
				$("#count_step1_' . $i . '").click();
				$("#count_step2_' . $i . '").click();
				$("#count_step3_' . $i . '").click();
				$("#count_step4_' . $i . '").click();
			});
		}else if (stepbtn' . $i . ' == 5) {
			$("#TransactionRequestOrderDetail_' . $i . '_quantity,#TransactionRequestOrderDetail_' . $i . '_discount1_nominal,#TransactionRequestOrderDetail_' . $i . '_discount2_nominal,#TransactionRequestOrderDetail_' . $i . '_discount3_nominal,#TransactionRequestOrderDetail_' . $i . '_discount4_nominal,#TransactionRequestOrderDetail_' . $i . '_discount5_nominal").keyup(function(event){
				$("#count_step1_' . $i . '").click();
				$("#count_step2_' . $i . '").click();
				$("#count_step3_' . $i . '").click();
				$("#count_step4_' . $i . '").click();
				$("#count_step5_' . $i . '").click();
			});
		}
    }

	$("#TransactionRequestOrderDetail_' . $i . '_quantity,#TransactionRequestOrderDetail_' . $i . '_discount1_nominal,#TransactionRequestOrderDetail_' . $i . '_discount2_nominal,#TransactionRequestOrderDetail_' . $i . '_discount3_nominal,#TransactionRequestOrderDetail_' . $i . '_discount4_nominal,#TransactionRequestOrderDetail_' . $i . '_discount5_nominal,#TransactionRequestOrderDetail_' . $i . '_discount_step").keyup(function(event){
		callme_stepbtn();
	});

	$("#add' . $i . '").click(function() {
		callme_stepbtn();
	});
');
?>

<?php
// Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/jquery.number.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScript('myjavascript', '
		//$(".numbers").number( true,2, ",", ".");
    ', CClientScript::POS_END);
?>