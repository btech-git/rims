<script type="text/javascript">
	

</script>

<table class="items" >
	<thead>
		<tr>
			<th>Request Order</th>
			<th>Branch Addressed to </th>
			<th>Product*</th>
			<th>Unit</th>
			<th>Discount step</th>
			<th>Discounts</th>
			<th>Request Quantity</th>
			<th>RQ Rest</th>
			<th>Purchase Quantity</th>
			<th>Total Quantity</th>
			<th>Retail Price</th>
			<th>Last Buying Price</th>
			<th>Request Price</th>
			<th>Price</th>
			<th>Subtotal</th>
			<th>Notes</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($purchaseOrder->details as $i => $detail): ?>

			<tr>
				<td><?php echo CHtml::activeHiddenField($detail, "[$i]request_order_detail_id"); ?>
						<?php echo CHtml::activeHiddenField($detail, "[$i]request_order_id"); ?>
					<?php $requestOrder = TransactionRequestOrder::model()->findByPK($detail->request_order_id); ?>
						<?php echo CHtml::activeTextField($detail, "[$i]request_order_no",array('value'=>!empty($requestOrder)?$requestOrder->request_order_no:"")); ?>
				</td>
				<td>
					<?php $branch = Branch::Model()->findByPK($detail->branch_addressed_to) ?>
					<?php echo CHtml::activeHiddenField($detail, "[$i]branch_addressed_to"); ?>
					<?php echo CHtml::activeTextField($detail, "[$i]branch_name",array('value'=>$detail->branch_addressed_to!=""?$branch->name:"")); ?>
				</td>
				<td>
					<?php $product = Product::model()->findByPK($detail->product_id); ?>
					<?php echo CHtml::activeHiddenField($detail, "[$i]product_id"); ?>
					<?php echo CHtml::activeTextField($detail, "[$i]product_name",array('value'=>$detail->product_id!=""?$product->name:"")); ?>
				</td>
				<td><?php echo CHtml::activeTextField($detail, "[$i]unit_id"); ?></td>
				<td><?php echo CHtml::activeDropDownList($detail, "[$i]discount_step", array('1' => '1',
											'2' => '2','3'=>'3','4'=>'4','5'=>'5'),array(
											'prompt'=>'[--Select Discount step--]',
											'onchange'=> '
																		var step = +$("#TransactionPurchaseOrderDetail_'.$i.'_discount_step").val();
																		switch (step) {
																			case 0:
																					
																					jQuery(".'.$i.'_1discount").hide();
																					jQuery(".'.$i.'_2discount").hide();
																					jQuery(".'.$i.'_3discount").hide();
																					jQuery(".'.$i.'_4discount").hide();
																					jQuery(".'.$i.'_5discount").hide();
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount1_nominal").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount2_nominal").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount3_nominal").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount4_nominal").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount5_nominal").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount1_type").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount2_type").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount3_type").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount4_type").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount5_type").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_price").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_subtotal").val("");
																				break;
																			case 1:
																					
																					jQuery(".'.$i.'_1discount").show();
																					jQuery(".'.$i.'_2discount").hide();
																					jQuery(".'.$i.'_3discount").hide();
																					jQuery(".'.$i.'_4discount").hide();
																					jQuery(".'.$i.'_5discount").hide();
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount1_nominal").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount2_nominal").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount3_nominal").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount4_nominal").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount5_nominal").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount1_type").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount2_type").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount3_type").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount4_type").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount5_type").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_price").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_subtotal").val("");
																				break;
																			case 2:
																					jQuery(".'.$i.'_2discount").show();
																					
																					jQuery(".'.$i.'_1discount").show();
																					jQuery(".'.$i.'_3discount").hide();
																					jQuery(".'.$i.'_4discount").hide();
																					jQuery(".'.$i.'_5discount").hide();
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount1_nominal").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount2_nominal").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount3_nominal").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount4_nominal").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount5_nominal").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount1_type").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount2_type").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount3_type").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount4_type").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount5_type").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_price").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_subtotal").val("");
																				break;
																			case 3:
																					
																					jQuery(".'.$i.'_3discount").show();
																					jQuery(".'.$i.'_1discount").show();
																					jQuery(".'.$i.'_2discount").show();
																					jQuery(".'.$i.'_4discount").hide();
																					jQuery(".'.$i.'_5discount").hide();
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount1_nominal").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount2_nominal").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount3_nominal").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount4_nominal").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount5_nominal").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount1_type").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount2_type").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount3_type").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount4_type").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount5_type").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_price").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_subtotal").val("");
																				break;
																			case 4:
																					
																					jQuery(".'.$i.'_4discount").show();
																					jQuery(".'.$i.'_1discount").show();
																					jQuery(".'.$i.'_2discount").show();
																					jQuery(".'.$i.'_3discount").show();
																					jQuery(".'.$i.'_5discount").hide();
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount1_nominal").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount2_nominal").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount3_nominal").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount4_nominal").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount5_nominal").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount1_type").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount2_type").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount3_type").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount4_type").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount5_type").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_price").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_subtotal").val("");
																				break;
																			case 5:
																					
																					jQuery(".'.$i.'_5discount").show();
																					jQuery(".'.$i.'_1discount").show();
																					jQuery(".'.$i.'_2discount").show();
																					jQuery(".'.$i.'_3discount").show();
																					jQuery(".'.$i.'_4discount").show();
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount1_nominal").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount2_nominal").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount3_nominal").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount4_nominal").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discobunt5_nominal").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount1_type").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount2_type").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount3_type").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount4_type").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount5_type").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_price").val("");
																					jQuery("#TransactionPurchaseOrderDetail_'.$i.'_subtotal").val("");
																					
																				break;
																			
																		}
												

											')); ?></td>

				
				<td >	

							<div class="<?php echo $i; ?>_1discount" >
					<?php echo CHtml::activeDropDownList($detail, "[$i]discount1_type", array('1' => 'Percent',
											'2' => 'Amount','3'=>'Bonus'),array('prompt'=>'[--Select Discount Type--]')); ?>
						<?php echo CHtml::activeTextField($detail,"[$i]discount1_nominal"); ?>
				</div>
				<div class="<?php echo $i; ?>_2discount" >
						<?php echo CHtml::activeDropDownList($detail, "[$i]discount2_type", array('1' => 'Percent',
											'2' => 'Amount','3'=>'Bonus'),array('prompt'=>'[--Select Discount Type--]')); ?>
						<?php echo CHtml::activeTextField($detail,"[$i]discount2_nominal"); ?>
				</div>
				<div class="<?php echo $i; ?>_3discount" >
						<?php echo CHtml::activeDropDownList($detail, "[$i]discount3_type", array('1' => 'Percent',
											'2' => 'Amount','3'=>'Bonus'),array('prompt'=>'[--Select Discount Type--]')); ?>
						<?php echo CHtml::activeTextField($detail,"[$i]discount3_nominal"); ?>
				</div>
				<div class="<?php echo $i; ?>_4discount" >
						<?php echo CHtml::activeDropDownList($detail, "[$i]discount4_type", array('1' => 'Percent',
											'2' => 'Amount','3'=>'Bonus'),array('prompt'=>'[--Select Discount Type--]')); ?>
						<?php echo CHtml::activeTextField($detail,"[$i]discount4_nominal"); ?>
				</div>
				<div class="<?php echo $i; ?>_5discount">
						<?php echo CHtml::activeDropDownList($detail, "[$i]discount5_type", array('1' => 'Percent',
											'2' => 'Amount','3'=>'Bonus'),array('prompt'=>'[--Select Discount Type--]')); ?>
						<?php echo CHtml::activeTextField($detail,"[$i]discount5_nominal"); ?>
				</div>
						
				</td>
				<?php $requestOrderDetail = TransactionRequestOrderDetail::model()->findByPK($detail->request_order_detail_id); ?>
				<td><?php echo CHtml::activeTextField($detail, "[$i]request_quantity",array('readonly'=>true,'value'=>$requestOrderDetail->quantity!=""?$requestOrderDetail->quantity:"")); ?></td>
				<td><?php echo CHtml::activeTextField($detail, "[$i]request_order_quantity_rest",array('readonly'=>true)); ?></td>
				<td><?php echo CHtml::activeTextField($detail, "[$i]quantity"); ?></td>
				<td><?php echo CHtml::activeTextField($detail, "[$i]total_quantity"); ?></td>
				<td><?php echo CHtml::activeTextField($detail, "[$i]retail_price", array('size'=>10,'maxlength'=>10,'readonly'=>true)); ?></td>
				<td><?php echo CHtml::activeTextField($detail, "[$i]last_buying_price", array('size'=>10,'maxlength'=>10,'readonly'=>true)); ?></td>
				<td><?php echo CHtml::activeTextField($detail, "[$i]request_price", array('size'=>10,'maxlength'=>10,'readonly'=>true,'value'=>$requestOrderDetail->price!=""?$requestOrderDetail->price:"")); ?></td>
				<td><?php echo CHtml::activeTextField($detail, "[$i]price", array('size'=>10,'maxlength'=>10)); ?></td>
				<td>
				<?php echo CHtml::activeTextField($detail,"[$i]subtotal",array('size'=>10,'maxlength'=>10)); ?>
					<?php
						    echo CHtml::button('Count', array(
						     	'onclick' => 'var quantity = +jQuery("#TransactionPurchaseOrderDetail_'.$i.'_quantity").val();
										var quantity = +jQuery("#TransactionPurchaseOrderDetail_'.$i.'_quantity").val();
										var step = +jQuery("#TransactionPurchaseOrderDetail_'.$i.'_discount_step").val();
										var disc1type = +$("#TransactionPurchaseOrderDetail_'.$i.'_discount1_type").val();
										var disc1nom = +$("#TransactionPurchaseOrderDetail_'.$i.'_discount1_nominal").val();
										var disc2type = +$("#TransactionPurchaseOrderDetail_'.$i.'_discount2_type").val();
										var disc2nom = +$("#TransactionPurchaseOrderDetail_'.$i.'_discount2_nominal").val();
										var disc3type = +$("#TransactionPurchaseOrderDetail_'.$i.'_discount3_type").val();
										var disc3nom = +$("#TransactionPurchaseOrderDetail_'.$i.'_discount3_nominal").val();
										var disc4type = +$("#TransactionPurchaseOrderDetail_'.$i.'_discount4_type").val();
										var disc4nom = +$("#TransactionPurchaseOrderDetail_'.$i.'_discount4_nominal").val();
										var disc5type = +$("#TransactionPurchaseOrderDetail_'.$i.'_discount5_type").val();
										var disc5nom = +$("#TransactionPurchaseOrderDetail_'.$i.'_discount5_nominal").val();
										var retail = +$("#TransactionPurchaseOrderDetail_'.$i.'_retail_price").val();
						$.ajax({
                  type: "POST",
                 
                 url: "' . CController::createUrl('ajaxGetSubtotal', array()) . '/step/" +step+"/disc1type/"+disc1type+"/disc1nom/"+disc1nom+"/disc2type/"+disc2type+"/disc2nom/"+disc2nom+"/disc3type/"+disc3type+"/disc3nom/"+disc3nom+"/disc4type/"+disc4type+"/disc4nom/"+disc4nom+"/disc5type/"+disc5type+"/disc5nom/"+disc5nom+"/quantity/"+quantity+"/retail/"+retail,
									

                  data: $("form").serialize(),
                  dataType: "json",
                  success: function(data) {
                  		
                    
                    
                		console.log(data.subtotal);
                		console.log(data.newPrice);
                    //$("#TransactionPurchaseOrderDetail_'.$i.'_retail_price").val(data.retail);
                    $("#TransactionPurchaseOrderDetail_'.$i.'_price").val(data.newPrice);
                    $("#TransactionPurchaseOrderDetail_'.$i.'_subtotal").val(data.subtotal);
                    $("#TransactionPurchaseOrderDetail_'.$i.'_total_quantity").val(data.totalquantity);
			                  
                	},
								});'
					     	));?>
				     	
					
				</td>
				<td><?php echo CHtml::activeTextField($detail, "[$i]notes", array('size'=>20,'maxlength'=>20)); ?></td>
				<td>
							<?php
						    echo CHtml::button('X', array(
						     	'onclick' => CHtml::ajax(array(
							       	'type' => 'POST',
							       	'url' => CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $purchaseOrder->header->id, 'index' => $i)),
							       	'update' => '#detail',
					      		)),
					     	));
				     	?>
						</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>