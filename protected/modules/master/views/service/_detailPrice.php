<table class="items">
			<thead>
			<tr>
				<th>Car Make</th>
				<th>Car Model</th>
				<th>Car Sub Model</th>
				<th>Diff</th>
				<th>Diff Calc</th>
				<th>Reg</th>
				<th>Lux</th>
				<th>Lux Value</th>
				<th>Lux Calc</th>
				<th>Standard FR/h</th>
				<th>FR hour</th>
				<th>Price</th>
				<th>Common Price</th>
				<th></th>
				<!-- <th><a href="#" class="sort-link">Level</a></th>
				<th><a href="#" class="sort-link"></a></th> -->
			</tr>
			</thead>
			<tbody >
			
			
				<?php foreach ($service->priceDetails as $i => $priceDetail): ?>
					<tr>
						<td width="180">
						<?php echo CHtml::activeDropDownList($priceDetail,"[$i]car_make_id", CHtml::listData(VehicleCarMake::model()->findAll(array('order'=>'name')),'id','name'),array(

									'prompt' => '[--Select Car Make--]',
				    			'onchange'=> 'jQuery.ajax({
									type: "POST",
									//dataType: "JSON",
									url: "' . CController::createUrl('ajaxGetModel',array()) . '/carmake/" + jQuery(this).val(),
									data: jQuery("form").serialize(),
									success: function(data){
			                        	console.log(data);
			                        	jQuery("#ServicePricelist_'.$i.'_car_model_id").html(data);

			                        	jQuery.ajax({
																type: "POST",
																url: "' . CController::createUrl('ajaxGetSubModel',array()) . '/carmake/" + jQuery("#ServicePricelist_'.$i.'_car_make_id").val()  + "/carmodel/" + jQuery("#ServicePricelist_'.$i.'_car_model_id").val(),
																data: jQuery("form").serialize(),
																success: function(data){
					                        	console.log(data);
					                        	jQuery("#ServicePricelist_'.$i.'_car_sub_detail_id").html(data);
					                        	if(jQuery("#ServicePricelist_'.$i.'_car_make_id").val() == ""){
					    											jQuery("#ServicePricelist_'.$i.'_car_model_id").html("<option value=\"\">[--Select Car Model--]</option>");}
	                        			}});
		                        	},
		                        	
								});'
					)); ?>
							<?php //echo CHtml::activeTextField($priceDetail,"[$i]car_make_id"); ?>
						</td>
						<td width="180">
						<?php echo CHtml::activeDropDownList($priceDetail,"[$i]car_model_id", $priceDetail->car_make_id != '' ?CHtml::listData(VehicleCarModel::model()->findAllByAttributes(array('car_make_id'=>$priceDetail->car_make_id),array('order'=>'name')),'id','name') : array() ,array(
										'prompt' => '[--Select Car Model--]',
					    			'onchange'=> '$.ajax({
										type: "POST",
										//dataType: "JSON",
										url: "' . CController::createUrl('ajaxGetSubModel',array()) . '/carmake/" + $("#ServicePricelist_'.$i.'_car_make_id").val()  + "/carmodel/" +  $(this).val(),
										
										data: $("form").serialize(),
										success: function(data){
				                        	console.log(data);
				                        	$("#ServicePricelist_'.$i.'_car_sub_detail_id").html(data);
			                        	},
									});'
								)) ?> 
							<?php //echo CHtml::activeTextField($priceDetail,"[$i]car_model_id"); ?>
						</td>
						<td width="100">
							<?php echo CHtml::activeDropDownList($priceDetail,"[$i]car_sub_detail_id", $priceDetail->car_model_id != ''?  CHtml::listData(VehicleCarSubModel::model()->findAllByAttributes(array('car_make_id'=>$priceDetail->car_make_id,'car_model_id'=>$priceDetail->car_model_id)),'id','name') : array() ,array('prompt' => '[--Select Car Sub Model--]',)); ?>

							<?php //echo CHtml::activeTextField($priceDetail,"[$i]car_sub_detail_id"); ?>
						</td>
						<td width="70">
							<?php echo CHtml::activeTextField($priceDetail,"[$i]difficulty"); ?>
						</td>
						<td width="70">
							<?php echo CHtml::activeTextField($priceDetail,"[$i]difficulty_value"); ?>
						</td>
						<td width="70">
							<?php echo CHtml::activeTextField($priceDetail,"[$i]regular"); ?>
						</td>
						<td width="70">
							<?php echo CHtml::activeTextField($priceDetail,"[$i]luxury"); ?>
						</td>
						<td width="70">
							<?php echo CHtml::activeTextField($priceDetail,"[$i]luxury_value"); ?>
						</td>
						<td width="70">
							<?php echo CHtml::activeTextField($priceDetail,"[$i]luxury_calc"); ?>
						</td>
						<td width="100">
							<?php echo CHtml::activeTextField($priceDetail,"[$i]standard_flat_rate_per_hour"); ?>
						</td>
						<td width="70">
							<?php echo CHtml::activeTextField($priceDetail,"[$i]flat_rate_hour",array(
										
							)); ?>
						</td>
						<td width="150">
								<?php
						    echo CHtml::button('Count', array(
						    	'id' => 'count_'.$i,
						     	'onclick' =>'
															var diff = +$("#ServicePricelist_'.$i.'_difficulty_value").val();
																	var lux = +$("#ServicePricelist_'.$i.'_luxury_calc").val();
																	var standard = +$("#ServicePricelist_'.$i.'_standard_flat_rate_per_hour").val();
																	var fr = +$("#ServicePricelist_'.$i.'_flat_rate_hour").val();
																	$.ajax({
                                    type: "POST",
                                   
                                    url: "' . CController::createUrl('ajaxGetPrice', array()) . '/diff/" +diff+"/lux/"+lux+"/standard/"+standard+"/fr/"+fr,
                                    data: $("form").serialize(),
                                    dataType: "json",
                                    success: function(data) {
                                    		console.log(data.diff);
                                    		console.log(data.lux);
                                    		console.log(data.standard);
                                    		console.log(data.fr);
                                        console.log(data.price);
                                        $("#ServicePricelist_'.$i.'_price").val(data.price);
                                    },

                                });
						     	',
						     )); ?>

							<?php echo CHtml::activeTextField($priceDetail,"[$i]price"); ?>
						</td>
						<td width="150">
							<?php echo CHtml::activeTextField($priceDetail,"[$i]common_price"); ?>
						</td>
						<td>
							<?php
						    echo CHtml::button('X', array(
						     	'onclick' => CHtml::ajax(array(
							       	'type' => 'POST',
							       	'url' => CController::createUrl('ajaxHtmlRemovePriceDetail', array('id' => $service->header->id, 'index' => $i)),
							       	'update' => '#price',
					      		)),
					     	));
				     	?>
						</td>

					</tr>
				<?php endforeach ?>
				
			</tbody>
			</table>