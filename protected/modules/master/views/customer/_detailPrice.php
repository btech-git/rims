<table class="items">
			<thead>
			<tr>
				<th>Service</th>
				<th>Vehicle</th>
				<!-- <th>Car Model</th>
				<th>Car Sub Model</th> -->
				<th>Rate</th>
				<th></th>
				<!-- <th><a href="#" class="sort-link">Level</a></th>
				<th><a href="#" class="sort-link"></a></th> -->
			</tr>
			</thead>
			<tbody >
			
			
				<?php foreach ($customer->serviceDetails as $i => $serviceDetail): ?>
					<tr>
						<td width="300">
							<?php echo CHtml::activeHiddenField($serviceDetail,"[$i]service_type_id"); ?>
							<?php echo CHtml::activeTextField($serviceDetail,"[$i]service_type_name",array('readonly'=>true,'value'=>$serviceDetail->service_type_id != "" ? $serviceDetail->serviceType->name : '')); ?>
							<?php echo CHtml::activeHiddenField($serviceDetail,"[$i]service_category_id"); ?>
							<?php echo CHtml::activeTextField($serviceDetail,"[$i]service_category_name",array('readonly'=>true,'value'=>$serviceDetail->service_type_id != "" ? $serviceDetail->serviceCategory->name : '')); ?>
							<?php echo CHtml::activeHiddenField($serviceDetail,"[$i]service_id"); ?>
							<?php echo CHtml::activeTextField($serviceDetail,"[$i]service_name",array('readonly'=>true,'value'=>$serviceDetail->service_type_id != "" ? $serviceDetail->service->name : '')); ?>

						</td>
						<td width="200">
						<?php echo CHtml::activeDropDownList($serviceDetail,"[$i]car_make_id", CHtml::listData(VehicleCarMake::model()->findAll(array('order'=>'name')),'id','name'),array(

									'prompt' => '[--Select Car Make--]',
				    			'onchange'=> 'jQuery.ajax({
									type: "POST",
									//dataType: "JSON",
									url: "' . CController::createUrl('ajaxGetModelPrice',array()) . '/carmake/" + jQuery(this).val(),
									data: jQuery("form").serialize(),
									success: function(data){
			                        	console.log(data);
			                        	jQuery("#CustomerServiceRate_'.$i.'_car_model_id").html(data);

			                        	jQuery.ajax({
																type: "POST",
																url: "' . CController::createUrl('ajaxGetSubModelPrice',array()) . '/carmake/" + jQuery("#CustomerServiceRate_'.$i.'_car_make_id").val()  + "/carmodel/" + jQuery("#CustomerServiceRate_'.$i.'_car_model_id").val(),
																data: jQuery("form").serialize(),
																success: function(data){
					                        	console.log(data);
					                        	jQuery("#CustomerServiceRate_'.$i.'_car_sub_model_id").html(data);
					                        	if(jQuery("#CustomerServiceRate_'.$i.'_car_make_id").val() == ""){
					    											jQuery("#CustomerServiceRate_'.$i.'_car_model_id").html("<option value=\"\">[--Select Car Model--]</option>");}
	                        			}});
		                        	},
		                        	
								});'
					)); ?>
							<?php //echo CHtml::activeTextField($priceDetail,"[$i]car_make_id"); ?>
						
						<?php echo CHtml::activeDropDownList($serviceDetail,"[$i]car_model_id", $serviceDetail->car_make_id != '' ?CHtml::listData(VehicleCarModel::model()->findAllByAttributes(array('car_make_id'=>$serviceDetail->car_make_id),array('order'=>'name')),'id','name') : array() ,array(
										'prompt' => '[--Select Car Model--]',
					    			'onchange'=> '$.ajax({
										type: "POST",
										//dataType: "JSON",
										url: "' . CController::createUrl('ajaxGetSubModelPrice',array()) . '/carmake/" + $("#CustomerServiceRate_'.$i.'_car_make_id").val()  + "/carmodel/" +  $(this).val(),
										
										data: $("form").serialize(),
										success: function(data){
				                        	console.log(data);
				                        	$("#CustomerServiceRate_'.$i.'_car_sub_model_id").html(data);
			                        	},
									});'
								)) ?> 
							<?php //echo CHtml::activeTextField($priceDetail,"[$i]car_model_id"); ?>
						
							<?php echo CHtml::activeDropDownList($serviceDetail,"[$i]car_sub_model_id", $serviceDetail->car_model_id != ''?  CHtml::listData(VehicleCarSubModel::model()->findAllByAttributes(array('car_make_id'=>$serviceDetail->car_make_id,'car_model_id'=>$serviceDetail->car_model_id)),'id','name') : array() ,array('prompt' => '[--Select Car Sub Model--]',)); ?>

							<?php //echo CHtml::activeTextField($priceDetail,"[$i]car_sub_detail_id"); ?>
						</td>
						
						<td width="200">
							<?php echo CHtml::activeTextField($serviceDetail,"[$i]rate"); ?>
						</td>
						
						<td width="50">
							<?php
						    echo CHtml::button('X', array(
						     	'onclick' => CHtml::ajax(array(
							       	'type' => 'POST',
							       	'url' => CController::createUrl('ajaxHtmlRemoveServiceDetail', array('id' => $customer->header->id, 'index' => $i)),
							       	'update' => '#price',
					      		)),
					     	));
				     	?>
						</td>

					</tr>
				<?php endforeach ?>
				
			</tbody>
			</table>