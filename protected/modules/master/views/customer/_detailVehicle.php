
<?php foreach ($customer->vehicleDetails as $i => $vehicleDetail): ?>
	<?php //echo $i; ?>
	<div class="clearfix"></div>
		<div class="clearfix"></div>
		<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix">Plate Number</label>
					</div>
					<div class="small-8 columns">
						<?php echo CHtml::activeTextField($vehicleDetail,"[$i]plate_number",array('size'=>30,'maxlength'=>30)); ?>
					</div>
				</div>
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix">Machine Number</label>
					</div>
					<div class="small-8 columns">
						<?php echo CHtml::activeTextField($vehicleDetail,"[$i]machine_number",array('size'=>30,'maxlength'=>30)); ?>
					</div>
				</div>
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix">Frame Number</label>
					</div>
					<div class="small-8 columns">
		
						<?php echo CHtml::activeTextField($vehicleDetail,"[$i]frame_number",array('size'=>30,'maxlength'=>30)); ?>
						
					</div>
				</div>
			</div>

				<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix">Year</label>
					</div>
					<div class="small-8 columns">
						<?php $range = range(date('Y'), 1950); ?>
			
						<?php echo CHtml::activeDropDownList($vehicleDetail,"[$i]year",array_combine($range, $range), array(
								'prompt'=>'[--Select Year--]',
								'onchange'=>'jQuery.ajax({
									type: "POST",
									url: "' . CController::createUrl('ajaxGetCarMake',array()) . '/year/" + jQuery(this).val(),
									data: jQuery("form").serialize(),
									success: function(data){
			                        	console.log(data);
			                        	jQuery("#Vehicle_'.$i.'_car_make_id").html(data);
			                        	
			                        	jQuery("#Vehicle_'.$i.'_car_model_id").html("<option value=\"\">[--Select Car Model--]</option>");
			                        	jQuery("#Vehicle_'.$i.'_car_sub_model_id").html("<option value=\"\">[--Select Car Sub Model--]</option>");

			                    	},
								});'
							)); ?>
						
					</div>
				</div>
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix">Car Make</label>
					</div>
					<div class="small-8 columns">
		
						<?php //echo CHtml::activeDropDownList($vehicleDetail,"[$i]car_make_id", CHtml::listData(VehicleCarMake::model()->findAll(array('order'=>'name')),'id','name'),  array('prompt' => 'Select',)); ?>
						<?php echo CHtml::activeDropDownList($vehicleDetail,"[$i]car_make_id", CHtml::listData(VehicleCarMake::model()->findAll(array('order'=>'name')),'id','name'),array(
                            'prompt' => '[--Select Car Make--]',
                            'onchange'=> 'jQuery.ajax({
                                type: "POST",
                                //dataType: "JSON",
                                url: "' . CController::createUrl('ajaxGetModel',array()) . '/year/" + $("#Vehicle_'.$i.'_year").val()  + "/carmake/" +  $(this).val(),
                                data: jQuery("form").serialize(),
                                success: function(data){
                                    console.log(data);
                                    jQuery("#Vehicle_'.$i.'_car_model_id").html(data);
                                    jQuery("#Vehicle_'.$i.'_car_sub_model_id").html("<option value=\"\">[--Select Car Sub Model--]</option>");
                                },

                            });'
                        )); ?>
					</div>
				</div>
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix">Car Model</label>
					</div>
					<div class="small-8 columns">
						
								<?php echo CHtml::activeDropDownList($vehicleDetail,"[$i]car_model_id", $vehicleDetail->car_make_id != '' ?CHtml::listData(VehicleCarModel::model()->findAllByAttributes(array('car_make_id'=>$vehicleDetail->car_make_id),array('order'=>'name')),'id','name') : array() ,array(
										'prompt' => '[--Select Car Model--]',
					    			'onchange'=> '$.ajax({
										type: "POST",
										//dataType: "JSON",
										url: "' . CController::createUrl('ajaxGetSubModel',array()) . '/year/"+$("#Vehicle_'.$i.'_year").val()+ "/carmake/" + $("#Vehicle_'.$i.'_car_make_id").val()  + "/carmodel/" +  $(this).val(),
										
										data: $("form").serialize(),
										success: function(data){
				                        	console.log(data);
				                        	$("#Vehicle_'.$i.'_car_sub_model_id").html(data);
			                        	},
									});'
								)) ?> 
							
						<?php //echo CHtml::activeDropDownList($vehicleDetail,"[$i]car_model_id", CHtml::listData(VehicleCarModel::model()->findAll(array('order'=>'name')),'id','name'),  array('prompt' => 'Select',)); ?>
						
					</div>
				</div>
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix">Car Sub Model</label>
					</div>
					<div class="small-8 columns">
						
						<?php echo CHtml::activeDropDownList($vehicleDetail,"[$i]car_sub_model_id", $vehicleDetail->car_model_id != ''?  CHtml::listData(VehicleCarSubModel::model()->findAllByAttributes(array('car_make_id'=>$vehicleDetail->car_make_id,'car_model_id'=>$vehicleDetail->car_model_id)),'id','name') : array() ,array(
								'prompt' => '[--Select Car Sub Model--]',
								'onchange'=> 'jQuery.ajax({
									type: "POST",
									dataType: "JSON",
									url: "' . CController::createUrl('ajaxGetSubModelDetails',array()) . '/year/" + $("#Vehicle_'.$i.'_year").val()  + "/carsubmodel/" +  $(this).val(),
									//url: "' . CController::createUrl('ajaxGetTransmission') . '",
									data: jQuery("form").serialize(),
									success: function(data){
			                        	//console.log(data.transmission);
			                        	jQuery("#Vehicle_'.$i.'_chasis_code").val(data.chasis);
			                        	jQuery("#Vehicle_'.$i.'_power").html(data.power);
			                        	jQuery("#Vehicle_'.$i.'_fuel_type").html(data.fuel_type);
			                        	jQuery("#Vehicle_'.$i.'_transmission").html(data.transmission);
			                        	jQuery("#Vehicle_'.$i.'_chasis_code").val(data.chasis_code);
			                        	
			                        	//jQuery("#sub_model_detail").slideDown();
			                        	//jQuery("#Vehicle_car_sub_model_detail_id").html(data);
			                    	},
								});'
						,)); ?>
						
						
						
					</div>
				</div>
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix">Color</label>
					</div>
					<div class="small-8 columns">
		
						<?php echo CHtml::activeDropDownList($vehicleDetail,"[$i]color_id", CHtml::listData(Colors::model()->findAll(array('order'=>'name')),'id','name'),  array('prompt' => '[--Select Color--]',)); ?>
						
					</div>
				</div>
			</div>

		

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix">Chasis Code</label>
					</div>
					<div class="small-8 columns">

						<?php echo CHtml::activeTextField($vehicleDetail,"[$i]chasis_code",array('size'=>30,'maxlength'=>30)); ?>
						
					</div>
				</div>
			</div>

			<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<label class="prefix">Transmission</label>
			</div>
			<div class="small-8 columns">
				<?php //echo $form->textField($model,'transmission',array('size'=>30,'maxlength'=>30)); ?>
				<?php echo CHtml::activeDropDownList($vehicleDetail,"[$i]transmission", array($vehicleDetail->transmission=>$vehicleDetail->transmission) ,array('prompt' => '[--Select Transmission--]',
					'onchange'=> 'jQuery.ajax({
						type: "POST",
						dataType: "JSON",
						url: "' . CController::createUrl('ajaxGetFuelPower',array()) . '/carsubmodel/" + $("#Vehicle_'.$i.'_car_sub_model_id").val()  + "/transmission/" +  $(this).val(),
						data: jQuery("form").serialize(),
						success: function(data){
                        	//console.log(data);
                        	if(jQuery("#Vehicle_'.$i.'_transmission").val() == ""){
                        		jQuery("#Vehicle_'.$i.'_transmission").html(data.transmission);
                        		jQuery("#Vehicle_'.$i.'_fuel_type").html(data.fuel_type);
                        		jQuery("#Vehicle_'.$i.'_power").html(data.power);
                        	}
                        	if(!jQuery("#Vehicle_'.$i.'_fuel_type").val()){
                        		jQuery("#Vehicle_'.$i.'_fuel_type").html(data.fuel_type);
                        	}
                        	if(!jQuery("#Vehicle_'.$i.'_power").val()){
                        		jQuery("#Vehicle_'.$i.'_power").html(data.power);
                        	}
                    	},
					});'
				)); ?>
				
			</div>
		</div>			
	</div>

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<label class="prefix">Fuel Type</label>
			</div>
			<div class="small-8 columns">
				<?php //echo $form->textField($model,'fuel_type',array('size'=>30,'maxlength'=>30)); ?>
				<?php echo CHtml::activeDropDownList($vehicleDetail,"[$i]fuel_type", array($vehicleDetail->fuel_type=>$vehicleDetail->fuel_type) ,array('prompt' => '[--Select Fuel Type--]',
					'onchange'=> 'jQuery.ajax({
						type: "POST",
						dataType: "JSON",
						url: "' . CController::createUrl('ajaxGetTransmissionPower',array()) . '/carsubmodel/" + $("#Vehicle_'.$i.'_car_sub_model_id").val()  + "/fueltype/" +  $(this).val(),
						data: jQuery("form").serialize(),
						success: function(data){
                        	//console.log(data);
                        	if(jQuery("#Vehicle_'.$i.'_fuel_type").val() == ""){
                        		jQuery("#Vehicle_'.$i.'_transmission").html(data.transmission);
                        		jQuery("#Vehicle_'.$i.'_fuel_type").html(data.fuel_type);
                        		jQuery("#Vehicle_'.$i.'_power").html(data.power);
                        	}
                        	if(!jQuery("#Vehicle_'.$i.'_transmission").val()){
                        		jQuery("#Vehicle_'.$i.'_transmission").html(data.transmission);
                        	}
                        	if(!jQuery("#Vehicle_'.$i.'_power").val()){
                        		jQuery("#Vehicle_'.$i.'_power").html(data.power);
                        	}
                    	},
					});'
				)); ?>
				
			</div>
		</div>			
	</div>

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<label class="prefix">Power CC</label>
			</div>
			<div class="small-8 columns">
				<?php //echo $form->textField($model,'power'); ?>
				<?php echo CHtml::activeDropDownList($vehicleDetail,"[$i]power", array($vehicleDetail->power=>$vehicleDetail->power) ,array('prompt' => '[--Select Power--]',
					'onchange'=> 'jQuery.ajax({
						type: "POST",
						dataType: "JSON",
						url: "' . CController::createUrl('ajaxGetTransmissionFuel',array()) . '/carsubmodel/" + $("#Vehicle_'.$i.'_car_sub_model_id").val()  + "/power/" +  $(this).val(),
						data: jQuery("form").serialize(),
						success: function(data){
                        	//console.log(data);
                        	if(jQuery("#Vehicle_'.$i.'_power").val() == ""){
                        		jQuery("#Vehicle_'.$i.'_transmission").html(data.transmission);
                        		jQuery("#Vehicle_'.$i.'_fuel_type").html(data.fuel_type);
                        		jQuery("#Vehicle_'.$i.'_power").html(data.power);
                        	}
                        	if(!jQuery("#Vehicle_'.$i.'_transmission").val()){
                        		jQuery("#Vehicle_'.$i.'_transmission").html(data.transmission);
                        	}
                        	if(!jQuery("#Vehicle_'.$i.'_fuel_type").val()){
                        		jQuery("#Vehicle_'.$i.'_fuel_type").html(data.fuel_type);
                        	}
                    	},
					});'
				)); ?>
				
			</div>
		</div>			
	</div>

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<label class="prefix">Drivetrain</label>
			</div>
			<div class="small-8 columns">
				<?php echo CHtml::activeTextField($vehicleDetail,"[$i]drivetrain",array('size'=>10,'maxlength'=>10)); ?>
				
			</div>
		</div>			
	</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix">Notes</label>
					</div>
					<div class="small-8 columns">

						<?php echo CHtml::activeTextArea($vehicleDetail,"[$i]notes",array('rows'=>6,'cols'=>50)); ?>
						
					</div>
				</div>
			</div>
			
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						
					</div>
					<div class="small-8 columns">

						<?php
				    echo CHtml::button('X', array(
				    	'class' =>'button extra right',
				     	'onclick' => CHtml::ajax(array(
					       	'type' => 'POST',
					       	'url' => CController::createUrl('ajaxHtmlRemoveVehicleDetail', array('id' => $customer->header->id, 'index' => $i)),
					       	'update' => '#vehicle',
			      		)),
			     	));
		     	?>
						
					</div>
				</div>
			</div>
			
			
		
			

			
			 

	<?php endforeach; ?>

			

			