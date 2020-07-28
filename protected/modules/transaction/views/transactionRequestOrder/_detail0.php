<?php //echo $i; ?>
    <div class="row">
        <div class="medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix">Quantity</label>
                    </div>
                    <div class="small-7 columns">
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
                                        $("#unit_price_' . $i . '").html(data.unitPrice);
                                        $("#total_' . $i . '").html(data.total);
                                        $("#sub_total").html(data.subTotal);
                                        $("#total_quantity").html(data.totalQuantity);
                                        $("#tax_value").html(data.taxValue);
                                        $("#grand_total").html(data.grandTotal);
                                    },
                                });	
                            ',
                        )); ?>
                    </div>
                    <div class="small-1 columns">
                    </div>
                </div>
            </div>
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix">Retail Price</label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::activeTextField($detail, "[$i]retail_price",
                            array('value' => intval($detail->retail_price),
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
                                            $("#unit_price_' . $i . '").html(data.unitPrice);
                                            $("#total_' . $i . '").html(data.total);
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
                        <label class="prefix">Last Buying Price</label>
                    </div>
                    <div class="small-8 columns">
                        <div class="row">
                            <div class="small-10 columns">
                                <?php echo CHtml::activeTextField($detail, "[$i]last_buying_price", array()); ?>
                            </div>
                            <div class="small-2 columns">
                                <?php
                                echo CHtml::button('?', array(
                                    'rel' => $i,
                                    'onclick' =>
                                        'currentPrice=$(this).attr("rel"); 
						     		var productname = $("#TransactionRequestOrderDetail_' . $i . '_product_name").val();
						     		var suppliername = $("#TransactionRequestOrderDetail_' . $i . '_supplier_name").val();
						     		// console.log(myArray["S"+currentSupplier]);
						     		// console.log(suppliername);
									$.fn.yiiGridView.update("price-grid", {
									    data: {"ProductPrice[product_name]": productname, "ProductPrice[supplier_name]": suppliername}
									});
						     		$("#price-dialog").dialog("open");
						     		return false;',
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix">Estimate Arrival Date</label>
                    </div>
                    <div class="small-8 columns">
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model' => $detail,
                            'attribute' => "[$i]estimated_arrival_date",
                            'options' => array(
                                'dateFormat' => 'yy-mm-dd',
                                'showAnim' => 'fold',
        //                        'changeMonth' => 'true',
        //                        'changeYear' => 'true',
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
                            ),
                        )); ?>
                        <?php //echo CHtml::activeTextField($detail, "[$i]estimated_arrival_date"); ?>
                    </div>
                </div>
            </div>
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix">Unit</label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::activeHiddenField($detail, "[$i]unit_id", array('readonly' => true)); ?>
                        <?php //echo CHtml::activeDropDownList($detail, "[$i]unit_id", CHtml::listData(Unit::model()->findAll(), 'id', 'name'), array('empty' => '-- Pilih Satuan --')); ?>
                        <?php //$unit = empty($detail->unit_id) ? "" : Unit::model()->findByPk($detail->unit_id); ?>
                        <span id="unit_name_<?php echo $i; ?>">
                            <?php echo CHtml::encode(CHtml::value($detail, 'unit.name')); ?>
                        </span>
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
                                <?php echo CHtml::activeDropDownList($detail, "[$i]discount_step",
                                    array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5'),
                                    array('prompt' => '[--Select Discount step--]')); ?>
                            </div>
                            <div class="small-2 columns">
                                <?php
                                echo CHtml::button('Add', array(
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
                                ));
                                ?>
                            </div>

                            <div class="small-2 columns text-right">
                                <?php echo CHtml::button('Count', array(
                                    'id' => 'count_' . $i,
                                    'onclick' => 'var step = +jQuery("#TransactionRequestOrderDetail_' . $i . '_discount_step").val();
										     		switch (step) {
										     			case 1:
					     									$("#TransactionRequestOrderDetail_' . $i . '_total_quantity").val(jQuery("#TransactionRequestOrderDetail_' . $i . '_discount1_temp_quantity").val());
					     									var temp_price = parseInt(jQuery("#TransactionRequestOrderDetail_' . $i . '_discount1_temp_price").val());
										     				$("#TransactionRequestOrderDetail_' . $i . '_total_price").val(temp_price);
													        $("#' . $i . '_total_price").val(temp_price.toLocaleString(\'id\'));
															$.ajax({
													        	type: "POST",
													            url: "' . CController::createUrl('ajaxCountTotal', array()) . '/totalquantity/" +$("#TransactionRequestOrderDetail_' . $i . '_total_quantity").val()+"/totalprice/"+$("#TransactionRequestOrderDetail_' . $i . '_total_price").val(),
																data: $("form").serialize(),
												                dataType: "json",
												                success: function(data) {
												                	console.log(data.unitprice);
												                  	$("#TransactionRequestOrderDetail_' . $i . '_unit_price").val(data.unitprice);
													                $("#' . $i . '_unit_price").val(parseInt(data.unitprice, 10).toLocaleString(\'id\'));
												                },});
				     									break;
					     								case 2:
					     									$("#TransactionRequestOrderDetail_' . $i . '_total_quantity").val(jQuery("#TransactionRequestOrderDetail_' . $i . '_discount2_temp_quantity").val());
										     				var temp_price = parseInt(jQuery("#TransactionRequestOrderDetail_' . $i . '_discount2_temp_price").val());
										     				$("#TransactionRequestOrderDetail_' . $i . '_total_price").val(temp_price);
													        $("#' . $i . '_total_price").val(temp_price.toLocaleString(\'id\'));
															$.ajax({
													        	type: "POST",
													            url: "' . CController::createUrl('ajaxCountTotal', array()) . '/totalquantity/" +$("#TransactionRequestOrderDetail_' . $i . '_total_quantity").val()+"/totalprice/"+$("#TransactionRequestOrderDetail_' . $i . '_total_price").val(),
																data: $("form").serialize(),
													            dataType: "json",
													            success: function(data) {
													            	console.log(data.unitprice);
													                  	$("#TransactionRequestOrderDetail_' . $i . '_unit_price").val(data.unitprice);
													                $("#' . $i . '_unit_price").val(parseInt(data.unitprice, 10).toLocaleString(\'id\'));
													                },});
										     			break;
										     			case 3:
										     				$("#TransactionRequestOrderDetail_' . $i . '_total_quantity").val(jQuery("#TransactionRequestOrderDetail_' . $i . '_discount3_temp_quantity").val());
										     				var temp_price = parseInt(jQuery("#TransactionRequestOrderDetail_' . $i . '_discount_temp_price").val());
										     				$("#TransactionRequestOrderDetail_' . $i . '_total_price").val(temp_price);
													        $("#' . $i . '_total_price").val(temp_price.toLocaleString(\'id\'));
															$.ajax({
													            type: "POST",
													            url: "' . CController::createUrl('ajaxCountTotal', array()) . '/totalquantity/" +$("#TransactionRequestOrderDetail_' . $i . '_total_quantity").val()+"/totalprice/"+$("#TransactionRequestOrderDetail_' . $i . '_total_price").val(),
															    data: $("form").serialize(),
													        	dataType: "json",
													            success: function(data) {
													            	console.log(data.unitprice);
													                $("#TransactionRequestOrderDetail_' . $i . '_unit_price").val(data.unitprice);
													                $("#' . $i . '_unit_price").val(parseInt(data.unitprice, 10).toLocaleString(\'id\'));
													            },});
										     			break;
										     			case 4:
										     				$("#TransactionRequestOrderDetail_' . $i . '_total_quantity").val(jQuery("#TransactionRequestOrderDetail_' . $i . '_discount4_temp_quantity").val());
										     				var temp_price = parseInt(jQuery("#TransactionRequestOrderDetail_' . $i . '_discount4_temp_price").val());
										     				$("#TransactionRequestOrderDetail_' . $i . '_total_price").val(temp_price);
													        $("#' . $i . '_total_price").val(temp_price.toLocaleString(\'id\'));
															$.ajax({
													            type: "POST",
													            url: "' . CController::createUrl('ajaxCountTotal', array()) . '/totalquantity/" +$("#TransactionRequestOrderDetail_' . $i . '_total_quantity").val()+"/totalprice/"+$("#TransactionRequestOrderDetail_' . $i . '_total_price").val(),
																data: $("form").serialize(),
                                                                dataType: "json",
                                                                success: function(data) {
                                                                    console.log(data.unitprice);
                                                                    $("#TransactionRequestOrderDetail_' . $i . '_unit_price").val(data.unitprice);
                                                                    $("#' . $i . '_unit_price").val(parseInt(data.unitprice, 10).toLocaleString(\'id\'));
                                                                }
													        });
										     			break;
										     			case 5:
										     				$("#TransactionRequestOrderDetail_' . $i . '_total_quantity").val(jQuery("#TransactionRequestOrderDetail_' . $i . '_discount5_temp_quantity").val());
										     				var temp_price = parseInt(jQuery("#TransactionRequestOrderDetail_' . $i . '_discount5_temp_price").val());
										     				$("#TransactionRequestOrderDetail_' . $i . '_total_price").val(temp_price);
													        $("#' . $i . '_total_price").val(temp_price.toLocaleString(\'id\'));
															$.ajax({
													            type: "POST",
													            url: "' . CController::createUrl('ajaxCountTotal', array()) . '/totalquantity/" +$("#TransactionRequestOrderDetail_' . $i . '_total_quantity").val()+"/totalprice/"+$("#TransactionRequestOrderDetail_' . $i . '_total_price").val(),
																data: $("form").serialize(),
													            dataType: "json",
													            success: function(data) {
													                console.log(data.unitprice);
													                $("#TransactionRequestOrderDetail_' . $i . '_unit_price").val(data.unitprice);
													                $("#' . $i . '_unit_price").val(parseInt(data.unitprice, 10).toLocaleString(\'id\'));
																},});
										     			break;
									     				default:
															$("#TransactionRequestOrderDetail_' . $i . '_total_quantity").val(jQuery("#TransactionRequestOrderDetail_' . $i . '_quantity").val());
										     				$("#TransactionRequestOrderDetail_' . $i . '_total_price").val(jQuery("#TransactionRequestOrderDetail_' . $i . '_retail_price").val());
															$.ajax({
													            type: "POST",
													            url: "' . CController::createUrl('ajaxCountTotalNonDiscount', array()) . '/totalquantity/" +$("#TransactionRequestOrderDetail_' . $i . '_total_quantity").val()+"/totalprice/"+$("#TransactionRequestOrderDetail_' . $i . '_total_price").val(),
																data: $("form").serialize(),
													            dataType: "json",
													            success: function(data) {
													                console.log(data.unitprice);
													                $("#TransactionRequestOrderDetail_' . $i . '_unit_price").val(data.unitprice);
													                $("#TransactionRequestOrderDetail_' . $i . '_total_price").val(data.price);
													                $("#' . $i . '_unit_price").val(parseInt(data.unitprice, 10).toLocaleString(\'id\'));
													                $("#' . $i . '_total_price").val(data.price.toLocaleString(\'id\'));
																},});
														break;
										     		}'
                                )); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
                            <div class="small-9 columns">
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
                                                $("#unit_price_' . $i . '").html(data.unitPrice);
                                                $("#total_' . $i . '").html(data.total);
                                                $("#sub_total").html(data.subTotal);
                                                $("#total_quantity").html(data.totalQuantity);
                                            },
                                        });	
                                    ',
                                )); ?>
                                <?php /*
                                echo CHtml::button('Count', array(
                                    'style' => 'display:none;',
                                    'id' => 'count_step1_' . $i,
                                    'onclick' => 'var quantity = +jQuery("#TransactionRequestOrderDetail_' . $i . '_quantity").val();
								var retail = +jQuery("#TransactionRequestOrderDetail_' . $i . '_retail_price").val();
								var discountType = +jQuery("#TransactionRequestOrderDetail_' . $i . '_discount1_type").val();
								var discountAmount = +jQuery("#TransactionRequestOrderDetail_' . $i . '_discount1_nominal").val();
								//var price = 0;

								$.ajax({
			                  type: "POST",
			                 
			                 url: "' . CController::createUrl('ajaxCountAmount', array()) . '/discountType/"+discountType+"/discountAmount/"+discountAmount+"/retail/" +retail+"/quantity/"+quantity,
												

			                  data: $("form").serialize(),
			                  dataType: "json",
			                  success: function(data) {
			                  	console.log(data.subtotal);
			                  	console.log(data.totalquantity);
			                  	console.log(data.newPrice);
			                  	$("#TransactionRequestOrderDetail_' . $i . '_discount1_temp_price").val(data.subtotal);
			                  	$("#TransactionRequestOrderDetail_' . $i . '_discount1_temp_quantity").val(data.totalquantity);

			                  },});'
                                )); ?>
                            </div>
                            <div class="small-3 columns">
                                <?php echo CHtml::activeTextField($detail, "[$i]discount1_temp_price",
                                    array('readonly' => true,)); ?>
                            </div>
                            <div class="small-3 columns">
                                <?php echo CHtml::activeTextField($detail, "[$i]discount1_temp_quantity",
                                    array('readonly' => true));*/ ?>
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
                            <div class="small-9 columns">
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
                                                $("#unit_price_' . $i . '").html(data.unitPrice);
                                                $("#total_' . $i . '").html(data.total);
                                                $("#sub_total").html(data.subTotal);
                                                $("#total_quantity").html(data.totalQuantity);
                                            },
                                        });	
                                    ',
                                )); ?>
                                <?php /*
                                echo CHtml::button('Count', array(
                                    'style' => 'display:none;',
                                    'id' => 'count_step2_' . $i,
                                    'onclick' => 'var quantity = +jQuery("#TransactionRequestOrderDetail_' . $i . '_quantity").val();
							var retail = +jQuery("#TransactionRequestOrderDetail_' . $i . '_retail_price").val();
							var discountType = +jQuery("#TransactionRequestOrderDetail_' . $i . '_discount2_type").val();
							var discountAmount = +jQuery("#TransactionRequestOrderDetail_' . $i . '_discount2_nominal").val();
							var price = +jQuery("#TransactionRequestOrderDetail_' . $i . '_discount1_temp_price").val();;
							$.ajax({
							type: "POST",

							url: "' . CController::createUrl('ajaxCountAmountStep', array()) . '/discountType/" +discountType+"/discountAmount/"+discountAmount+"/retail/" +retail+"/quantity/"+quantity+"/price/"+price,
							data: $("form").serialize(),
							dataType: "json",
							success: function(data) {
							// console.log(data.subtotal);
							// console.log(data.totalquantity);
							// console.log(data.newPrice);
							$("#TransactionRequestOrderDetail_' . $i . '_discount2_temp_price").val(data.subtotal);
							$("#TransactionRequestOrderDetail_' . $i . '_discount2_temp_quantity").val(data.totalquantity);
							},});'
                                )); ?>
                            </div>
                            <div class="small-3 columns">
                                <?php echo CHtml::activeTextField($detail, "[$i]discount2_temp_price",
                                    array('readonly' => true,)); ?>
                            </div>
                            <div class="small-3 columns">
                                <?php echo CHtml::activeTextField($detail, "[$i]discount2_temp_quantity",
                                    array('readonly' => true));*/ ?>
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
                            <div class="small-9 columns">
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
                                                $("#unit_price_' . $i . '").html(data.unitPrice);
                                                $("#total_' . $i . '").html(data.total);
                                                $("#sub_total").html(data.subTotal);
                                                $("#total_quantity").html(data.totalQuantity);
                                            },
                                        });	
                                    ',
                                )); ?>
                                <?php /*
                                echo CHtml::button('Count', array(
                                    'style' => 'display:none;',
                                    'id' => 'count_step3_' . $i,
                                    'onclick' => 'var quantity = +jQuery("#TransactionRequestOrderDetail_' . $i . '_quantity").val();
								var retail = +jQuery("#TransactionRequestOrderDetail_' . $i . '_retail_price").val();
								var discountType = +jQuery("#TransactionRequestOrderDetail_' . $i . '_discount3_type").val();
								var discountAmount = +jQuery("#TransactionRequestOrderDetail_' . $i . '_discount3_nominal").val();
								var price = +jQuery("#TransactionRequestOrderDetail_' . $i . '_discount2_temp_price").val();;

								$.ajax({
								type: "POST",

								url: "' . CController::createUrl('ajaxCountAmountStep', array()) . '/discountType/" +discountType+"/discountAmount/"+discountAmount+"/retail/" +retail+"/quantity/"+quantity+"/price/"+price,


								data: $("form").serialize(),
								dataType: "json",
								success: function(data) {
								// console.log(data.subtotal);
								// console.log(data.totalquantity);
								// console.log(data.newPrice);
								$("#TransactionRequestOrderDetail_' . $i . '_discount3_temp_price").val(data.subtotal);
								$("#TransactionRequestOrderDetail_' . $i . '_discount3_temp_quantity").val(data.totalquantity);
								},});'

                                )); ?>
                            </div>
                            <div class="small-3 columns">
                                <?php echo CHtml::activeTextField($detail, "[$i]discount3_temp_price",
                                    array('readonly' => true,)); ?>
                            </div>
                            <div class="small-3 columns">
                                <?php echo CHtml::activeTextField($detail, "[$i]discount3_temp_quantity",
                                    array('readonly' => true));*/ ?>
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
                            <div class="small-9 columns">
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
                                                $("#unit_price_' . $i . '").html(data.unitPrice);
                                                $("#total_' . $i . '").html(data.total);
                                                $("#sub_total").html(data.subTotal);
                                                $("#total_quantity").html(data.totalQuantity);
                                            },
                                        });	
                                    ',
                                )); ?>
                                <?php /*
                                echo CHtml::button('Count', array(
                                    'style' => 'display:none;',
                                    'id' => 'count_step4_' . $i,
                                    'onclick' => 'var quantity = +jQuery("#TransactionRequestOrderDetail_' . $i . '_quantity").val();
								var retail = +jQuery("#TransactionRequestOrderDetail_' . $i . '_retail_price").val();
								var discountType = +jQuery("#TransactionRequestOrderDetail_' . $i . '_discount4_type").val();
								var discountAmount = +jQuery("#TransactionRequestOrderDetail_' . $i . '_discount4_nominal").val();
								var price = +jQuery("#TransactionRequestOrderDetail_' . $i . '_discount3_temp_price").val();;

								$.ajax({
								type: "POST",

								url: "' . CController::createUrl('ajaxCountAmountStep', array()) . '/discountType/" +discountType+"/discountAmount/"+discountAmount+"/retail/" +retail+"/quantity/"+quantity+"/price/"+price,


								data: $("form").serialize(),
								dataType: "json",
								success: function(data) {
								// console.log(data.subtotal);
								// console.log(data.totalquantity);
								// console.log(data.newPrice);
								$("#TransactionRequestOrderDetail_' . $i . '_discount4_temp_price").val(data.subtotal);
								$("#TransactionRequestOrderDetail_' . $i . '_discount4_temp_quantity").val(data.totalquantity);
								},});'
                                )); ?>
                            </div>
                            <div class="small-3 columns">
                                <?php echo CHtml::activeTextField($detail, "[$i]discount4_temp_price",
                                    array('readonly' => true,)); ?>
                            </div>
                            <div class="small-3 columns">
                                <?php echo CHtml::activeTextField($detail, "[$i]discount4_temp_quantity",
                                    array('readonly' => true));*/ ?>
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
                            <div class="small-9 columns">
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
                                                $("#unit_price_' . $i . '").html(data.unitPrice);
                                                $("#total_' . $i . '").html(data.total);
                                                $("#sub_total").html(data.subTotal);
                                                $("#total_quantity").html(data.totalQuantity);
                                            },
                                        });	
                                    ',
                                )); ?>
                                <?php /*
                                echo CHtml::button('Count', array(
                                    'style' => 'display:none;',
                                    'id' => 'count_step5_' . $i,
                                    'onclick' => 'var quantity = +jQuery("#TransactionRequestOrderDetail_' . $i . '_quantity").val();
								var retail = +jQuery("#TransactionRequestOrderDetail_' . $i . '_retail_price").val();
								var discountType = +jQuery("#TransactionRequestOrderDetail_' . $i . '_discount5_type").val();
								var discountAmount = +jQuery("#TransactionRequestOrderDetail_' . $i . '_discount5_nominal").val();
								var price = +jQuery("#TransactionRequestOrderDetail_' . $i . '_discount4_temp_price").val();;

								$.ajax({
								type: "POST",

								url: "' . CController::createUrl('ajaxCountAmountStep', array()) . '/discountType/" +discountType+"/discountAmount/"+discountAmount+"/retail/" +retail+"/quantity/"+quantity+"/price/"+price,


								data: $("form").serialize(),
								dataType: "json",
								success: function(data) {
								// console.log(data.subtotal);
								// console.log(data.totalquantity);
								// console.log(data.newPrice);
								$("#TransactionRequestOrderDetail_' . $i . '_discount5_temp_price").val(data.subtotal);
								$("#TransactionRequestOrderDetail_' . $i . '_discount5_temp_quantity").val(data.totalquantity);
								},});'
                                )); ?>
                            </div>
                            <div class="small-3 columns">
                                <?php echo CHtml::activeTextField($detail, "[$i]discount5_temp_price",
                                    array('readonly' => true,)); ?>
                            </div>
                            <div class="small-3 columns">
                                <?php echo CHtml::activeTextField($detail, "[$i]discount5_temp_quantity",
                                    array('readonly' => true));*/ ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix">Total Quantity</label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::activeTextField($detail, "[$i]total_quantity", array('readonly' => true)); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix">Unit Price</label>
                    </div>
                    <div class="small-8 columns">
                        <span id="unit_price_<?php echo $i; ?>">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'unitPrice'))); ?>
                        </span>
                        <?php /*echo CHtml::activeTextField($detail, "", array(
                            'readonly' => true,
                            'value' => AppHelper::formatMoney($detail->unit_price),
                            'id' => "{$i}_unit_price",
                            'name' => ""
                        ));*/ ?>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]unit_price", array('readonly' => true)); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix">Sub Total</label>
                    </div>
                    <div class="small-8 columns">
                        <span id="total_<?php echo $i; ?>">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'total'))); ?>
                        </span>
                        <?php /*echo CHtml::activeTextField($detail, "", array(
                            'readonly' => true,
                            'value' => AppHelper::formatMoney($detail->total_price),
                            'id' => "{$i}_total_price",
                            'name' => ""
                        ));*/ ?>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]total_price", array('readonly' => true,)); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php
Yii::app()->clientScript->registerScript('myjqueryCount' . $i, '

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