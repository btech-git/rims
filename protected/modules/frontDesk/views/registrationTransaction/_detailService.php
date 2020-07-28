<?php if (count($registrationTransaction->serviceDetails) > 0): ?>
	<table>
		<thead>
			<tr>
				<th>Service name</th>
				<th>Claim</th>
				<th>Price</th>
				<th>Discount Type</th>
				<th>Discount Price</th>
				<th>Total Price</th>
				<th>Hour</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($registrationTransaction->serviceDetails as $i => $serviceDetail): ?>
				<?php if($serviceDetail->is_body_repair == 0) :?>
				<tr>
					<td><?php echo CHtml::activeHiddenField($serviceDetail,"[$i]service_id"); ?>
							<?php echo CHtml::activeTextField($serviceDetail,"[$i]service_name",array('readonly'=>true,'value'=>$serviceDetail->service_id != "" ? $serviceDetail->service->name : '')); ?>
						<?php echo CHtml::activeHiddenField($serviceDetail,"[$i]is_quick_service"); ?>
					</td>
					<td><?php echo  CHtml::activeTextField($serviceDetail, "[$i]claim",array('readonly'=>true)); ?>
					</td>
					<td><?php echo CHtml::activeTextField($serviceDetail,"[$i]price", array(
                            'onchange'=>CHtml::ajax(array(
                                'type'=>'POST',
                                'dataType'=>'JSON',
                                'url'=>CController::createUrl('ajaxJsonTotalService', array('id'=>$registrationTransaction->header->id, 'index'=>$i)),
                                'success'=>'function(data) {
                                    $("#total_amount_' . $i . '").html(data.totalAmount);
                                    $("#total_quantity_service").html(data.totalQuantityService);
                                    $("#sub_total_service").html(data.subTotalService);
                                    $("#total_discount_service").html(data.totalDiscountService);
                                    $("#grand_total_service").html(data.grandTotalService);
                                    $("#sub_total_transaction").html(data.subTotalTransaction);
                                    $("#tax_item_amount").html(data.taxItemAmount);
                                    $("#tax_service_amount").html(data.taxServiceAmount);
                                    $("#grand_total_transaction").html(data.grandTotalTransaction);
                                }',
                            )),
                            'class' => "form-control is-valid",
                        )); ?>
						<?php echo CHtml::button('!', array(
					     'onclick'=>'
                            var serviceId = $("#RegistrationService_'.$i.'_service_id").val();
                            var customerId = $("#RegistrationTransaction_customer_id").val();
                            var vehicleId = $("#RegistrationTransaction_vehicle_id").val();
                            var insuranceId = $("#RegistrationTransaction_insurance_company_id").val();
                             $.ajax({
                                type: "POST",
                                //dataType: "JSON",


                                url: "' . CController::createUrl('ajaxShowPricelist', array('index'=>$i)).'&serviceId="+serviceId+"&customerId="+customerId+"&vehicleId="+vehicleId+"&insuranceId="+insuranceId,
                                data:$("form").serialize(),
                                success: function(html) {
                                    $("#price_'.$i.'_div").html(html);
                                    $("#service_price'.$i.'-dialog").dialog("open"); return false;

                                },
                            });',

				     	)); ?>
                        <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                            'id' => 'service_price'.$i.'-dialog',
                            // additional javascript options for the dialog plugin
                            'options' => array(
                                'title' => 'Price',
                                'autoOpen' => false,
                                'width' => 'auto',
                                'modal' => true,
                            ),));
                             //echo $this->renderPartial('_price-dialog',array('serviceId'=>$serviceDetail->service_id));
                        ?>
                            <div id="price_<?php echo $i ?>_div"></div>
                            <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

                    </td>
					<td><?php echo CHtml::activeDropDownList($serviceDetail,"[$i]discount_type", array('Nominal' => 'Nominal',
                            'Percent' => 'Percent'), array('prompt'=>'[--Select Discount Type--]')); ?></td>
					<td><?php echo CHtml::activeTextField($serviceDetail,"[$i]discount_price", array('readonly'=>$serviceDetail->is_quick_service == 1 ? true : false,
							/*'onchange'=> '
                                var price = +$("#RegistrationService_'.$i.'_price").val();
                                var discount = +$("#RegistrationService_'.$i.'_discount_price").val();
                                var type = $("#RegistrationService_'.$i.'_discount_type").val();
                                var total = 0;
                                if(type == "Nominal")
                                {
                                    total = price - discount;
                                }
                                else{
                                    var disc = discount / 100 * price;
                                    total = price - disc;
                                }

                                if(total < 0)
                                {
                                    alert("Total Price could not be minus!");
                                    $("#RegistrationService_'.$i.'_discount_price").val("");
                                    $("#RegistrationService_'.$i.'_discount_price").focus();
                                }
                                else{
                                    $("#RegistrationService_'.$i.'_total_price").val(total);
                                }
							'*/
                            'onchange'=>CHtml::ajax(array(
                                'type'=>'POST',
                                'dataType'=>'JSON',
                                'url'=>CController::createUrl('ajaxJsonTotalService', array('id'=>$registrationTransaction->header->id, 'index'=>$i)),
                                'success'=>'function(data) {
                                    $("#total_amount_' . $i . '").html(data.totalAmount);
                                    $("#total_quantity_service").html(data.totalQuantityService);
                                    $("#sub_total_service").html(data.subTotalService);
                                    $("#total_discount_service").html(data.totalDiscountService);
                                    $("#grand_total_service").html(data.grandTotalService);
                                    $("#sub_total_transaction").html(data.subTotalTransaction);
                                    $("#tax_item_amount").html(data.taxItemAmount);
                                    $("#tax_service_amount").html(data.taxServiceAmount);
                                    $("#grand_total_transaction").html(data.grandTotalTransaction);
                                }',
                            )),
                            'class' => "form-control is-valid",
					)); ?></td>
					<td>
                        <?php echo CHtml::activeHiddenField($serviceDetail,"[$i]total_price",array('readonly'=>true)); ?>
                        <span id="total_amount_<?php echo $i; ?>">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($serviceDetail, 'totalAmount'))); ?>
                        </span>
                    </td>
					<?php $service = Service::model()->findByPk($serviceDetail->service_id); ?>
					<td><?php echo CHtml::activeTextField($serviceDetail,"[$i]hour",array('readonly'=>true,'value'=>$serviceDetail->service_id != "" ? $service->flat_rate_hour : '')); ?></td>			
					<td><?php
					    echo CHtml::button('X', array(
					     	'onclick' => CHtml::ajax(array(
						       	'type' => 'POST',
						       	'url' => CController::createUrl('ajaxHtmlRemoveServiceDetail', array('id' => $registrationTransaction->header->id, 'index' => $i)),
						       	'update' => '#service',
				      		)),
				     	));
			     	?></td>
				</tr>
				<?php endif ?>
			<?php endforeach ?>
		</tbody>
	</table>
<?php endif ?>
