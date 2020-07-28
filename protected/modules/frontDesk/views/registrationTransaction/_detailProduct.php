<?php if (count($registrationTransaction->productDetails)>0): ?>
	<table>
		<thead>
			<tr>
				<th>Product name</th>
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
				<tr>
					<td>
                        <?php echo CHtml::activeHiddenField($productDetail,"[$i]product_id"); ?>
                        <?php echo CHtml::activeTextField($productDetail,"[$i]product_name",array('readonly'=>true,'value'=>$productDetail->product_id != "" ? $productDetail->product->name : '')); ?>
					</td>
					<td>
                        <?php echo CHtml::activeTextField($productDetail,"[$i]quantity",array(
                            'onchange'=>CHtml::ajax(array(
                                'type'=>'POST',
                                'dataType'=>'JSON',
                                'url'=>CController::createUrl('ajaxJsonTotalProduct', array('id'=>$registrationTransaction->header->id, 'index'=>$i)),
                                'success'=>'function(data) {
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
							/*'onchange'=> '
                                var quantity = +$("#RegistrationProduct_'.$i.'_quantity").val();
                                var sale = +$("#RegistrationProduct_'.$i.'_sale_price").val();
                                $.ajax({
                                      type: "POST",

                                     url: "' . CController::createUrl('ajaxCountProduct', array()) . '/quantity/" +quantity+"/sale/"+sale,


                                      data: $("form").serialize(),
                                      dataType: "json",
                                      success: function(data) {
                                        //console.log(data.unitprice);
                                      $("#RegistrationProduct_'.$i.'_total_price").val(data.total);
                                      },});
                                '*/
                        )); ?>
					</td>
                    <td><?php echo CHtml::encode(CHtml::value($productInfo, "unit.name")); ?></td>
					<td><?php echo CHtml::activeTextField($productDetail,"[$i]retail_price",array('readonly'=>true,)); ?></td>
					<td><?php echo CHtml::activeTextField($productDetail,"[$i]recommended_selling_price",array('readonly'=>true,)); ?></td>
					<td>
                        <?php echo CHtml::activeTextField($productDetail,"[$i]sale_price",array(
                            'onchange'=>CHtml::ajax(array(
                                'type'=>'POST',
                                'dataType'=>'JSON',
                                'url'=>CController::createUrl('ajaxJsonTotalProduct', array('id'=>$registrationTransaction->header->id, 'index'=>$i)),
                                'success'=>'function(data) {
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
                            /*'onchange'=> '
                                var quantity = +$("#RegistrationProduct_'.$i.'_quantity").val();
                                var sale = +$("#RegistrationProduct_'.$i.'_sale_price").val();
                                $.ajax({
                                      type: "POST",

                                     url: "' . CController::createUrl('ajaxCountProduct', array()) . '/quantity/" +quantity+"/sale/"+sale,


                                      data: $("form").serialize(),
                                      dataType: "json",
                                      success: function(data) {
                                        //console.log(data.unitprice);
                                      $("#RegistrationProduct_'.$i.'_total_price").val(data.total);
                                      },});
                            '*/
                        )); ?>
                    </td>
					<td>
                        <?php echo CHtml::activeDropDownList($productDetail,"[$i]discount_type", array(
                            'Nominal' => 'Nominal',
                            'Percent' => 'Percent'
                        ),array('prompt'=>'[--Select Discount Type --]')); ?>
                    </td>
					<td><?php echo CHtml::activeTextField($productDetail,"[$i]discount",array(
                            'onchange'=>CHtml::ajax(array(
                                'type'=>'POST',
                                'dataType'=>'JSON',
                                'url'=>CController::createUrl('ajaxJsonTotalProduct', array('id'=>$registrationTransaction->header->id, 'index'=>$i)),
                                'success'=>'function(data) {
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
                        
                            /*'onchange'=> '
                                var discount = +$("#RegistrationProduct_'.$i.'_discount").val();
                                var sale = +$("#RegistrationProduct_'.$i.'_sale_price").val();
                                var total = 0;
                                var type = $("#RegistrationProduct_'.$i.'_discount_type").val();
                                var total = 0;
                                if(type == "Nominal")
                                {
                                    total = sale - discount;
                                }
                                else{
                                    var disc = discount / 100 * sale;
                                     total = sale - disc;
                                }
                                if(total < 0){
                                    alert("Total Price could not be minus!");
                                    $("#RegistrationProduct_'.$i.'_discount").focus();
                                    $("#RegistrationProduct_'.$i.'_discount").val(0.00);

                                }
                                else{
                                    $("#RegistrationProduct_'.$i.'_total_price").val(total);
                                }
                        '*/
					)); ?></td>
					<td>
                    <?php echo CHtml::activeHiddenField($productDetail,"[$i]total_price",array('readonly'=>true,)); ?>
                    <?php //echo CHtml::encode(CHtml::value($productDetail, "total_price")); ?>
                        <span id="total_amount_product_<?php echo $i; ?>">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($productDetail, 'totalAmountProduct'))); ?>
                        </span>
                    </td>
					<td>
                        <?php echo CHtml::button('X', array(
					     	'onclick' => CHtml::ajax(array(
						       	'type' => 'POST',
						       	'url' => CController::createUrl('ajaxHtmlRemoveProductDetail', array('id' => $registrationTransaction->header->id, 'index' => $i)),
						       	'update' => '#product',
				      		)),
				     	)); ?>
                    </td>
				</tr>
                <tr>
                    <td colspan="9">
                        Code: <?php echo CHtml::encode(CHtml::value($productInfo, "manufacturer_code")); ?> ||
                        Kategori: <?php echo CHtml::encode(CHtml::value($productInfo, "masterSubCategoryCode")); ?> ||
                        Brand: <?php echo CHtml::encode(CHtml::value($productInfo, "brand.name")); ?> ||
                        Sub Brand: <?php echo CHtml::encode(CHtml::value($productInfo, "subBrand.name")); ?> ||
                        Sub Brand Series: <?php echo CHtml::encode(CHtml::value($productInfo, "subBrandSeries.name")); ?> 
                    </td>
                </tr>
			<?php endforeach ?>
		</tbody>
	</table>
<?php endif ?>
