
<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix">Customer Name</label>
					</div>
					<div class="small-8 columns">
						<?php $customers = Customer::model()->findbyPk($model->customer_id); ?>
						<?php echo CHtml::activeHiddenField($model,'customer_id',array('size'=>30,'maxlength'=>30,'readonly'=>true)); ?>
						<?php echo CHtml::activeTextField($model,'customer_name',array('value'=>$customers->name,'readonly'=>true)); ?>
					</div>
				</div>
			</div>
	<div class="clearfix"></div>
		<div class="clearfix"></div>
		<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix">Service Type</label>
					</div>
					<div class="small-8 columns">
		
						<?php echo CHtml::activeDropDownList($model,"service_type_id",CHtml::listData(ServiceType::model()->findAll(array('order'=>'name')),'id','name'),array(

									'prompt' => '[--Select Service Type--]',
				    			'onchange'=> 'jQuery.ajax({
									type: "POST",
									//dataType: "JSON",
									url: "' . CController::createUrl('ajaxGetServiceCategory',array()) . '/serviceType/" + jQuery(this).val(),
									data: jQuery("form").serialize(),
									success: function(data){
			                        	console.log(data);
			                        	jQuery("#CustomerServiceRate_service_category_id").html(data);

			                        	jQuery.ajax({
																type: "POST",
																url: "' . CController::createUrl('ajaxGetService',array()) . '/serviceType/" + jQuery("#CustomerServiceRate_service_type_id").val()  + "/serviceCategory/" + jQuery("#CustomerServiceRate_service_category_id").val(),
																data: jQuery("form").serialize(),
																success: function(data){
					                        	console.log(data);
					                        	jQuery("#CustomerServiceRate_service_id").html(data);
					                        	if(jQuery("#CustomerServiceRate_service_type_id").val() == ""){
					    											jQuery("#CustomerServiceRate_service_category_id").html("<option value=\"\">[--Select Service Category--]</option>");}
	                        			}});
		                        	},
		                        	
								});'
					)); ?>
						
					</div>
				</div>
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix">Service Category </label>
					</div>
					<div class="small-8 columns">
		
						<?php echo CHtml::activeDropDownList($model,"service_category_id",$model->service_type_id != '' ? CHtml::listData(ServiceCategory::model()->findAll(array('order'=>'name')),'id','name'): array(), array(
								'prompt' => '[--Select Service Category--]',
					    			'onchange'=> '$.ajax({
										type: "POST",	
										//dataType: "JSON",
											url: "' . CController::createUrl('ajaxGetService',array()) . '/serviceType/" + jQuery("#CustomerServiceRate_service_type_id").val()  + "/serviceCategory/" + jQuery("#CustomerServiceRate_service_category_id").val(),
											data: jQuery("form").serialize(),
											success: function(data){
				                        	console.log(data);
				                        	jQuery("#CustomerServiceRate_service_id").html(data);
			                        	},
									});'
								)) ?> 
						
					</div>
				</div>
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix">Service</label>
					</div>
					<div class="small-8 columns">
		
						<?php echo CHtml::activeDropDownList($model, "service_id",$model->service_category_id != ''? CHtml::listData(Service::model()->findAll(array('order'=>'name')),'id','name') : array(),array('prompt' => '[--Select Service--]',)); ?>
						
					</div>
				</div>
			</div>
 
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix">Car Make</label>
					</div>
					<div class="small-8 columns">
		
						<?php //echo CHtml::activeDropDownList($model,"[$i]car_make_id", CHtml::listData(VehicleCarMake::model()->findAll(array('order'=>'name')),'id','name'),  array('prompt' => 'Select',)); ?>
						<?php echo CHtml::activeDropDownList($model,'car_make_id', CHtml::listData(VehicleCarMake::model()->findAll(array('order'=>'name')),'id','name'),array(
									'prompt' => '[--Select Car Make--]',
				    			'onchange'=> 'jQuery.ajax({
									type: "POST",
									//dataType: "JSON",
									url: "' . CController::createUrl('ajaxGetModel',array()) . '/carmake/" + jQuery(this).val(),
									data: jQuery("form").serialize(),
									success: function(data){
			                        	console.log(data);
			                        	jQuery("#CustomerServiceRate_car_model_id").html(data);

			                        	jQuery.ajax({
																type: "POST",
																url: "' . CController::createUrl('ajaxGetSubModel',array()) . '/carmake/" + jQuery("#CustomerServiceRate_car_make_id").val()  + "/carmodel/" + jQuery("#CustomerServiceRate_car_model_id").val(),
																data: jQuery("form").serialize(),
																success: function(data){
					                        	console.log(data);
					                        	jQuery("#CustomerServiceRate_car_sub_model_id").html(data);
					                        		if(jQuery("#CustomerServiceRate_car_make_id").val() == ""){
					    											jQuery("#CustomerServiceRate_car_model_id").html("<option value=\"\">[--Select Car Model--]</option>");}
	                        			}});
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
						
						<?php echo CHtml::activeDropDownList($model,'car_model_id', $model->car_make_id != '' ? CHtml::listData(VehicleCarModel::model()->findAllByAttributes(array('car_make_id'=>$model->car_make_id,)),'id','name') : array(),array(
									'prompt' => '[--Select Car Model--]',
				    			'onchange'=> 'jQuery.ajax({
									type: "POST",
									//dataType: "JSON",
									url: "' . CController::createUrl('ajaxGetSubModel',array()) . '/carmake/" + jQuery("#CustomerServiceRate_car_make_id").val()  + "/carmodel/" +  jQuery(this).val(),
									
									data: jQuery("form").serialize(),
									success: function(data){
			                        	console.log(data);
			                        	jQuery("#CustomerServiceRate_car_sub_model_id").html(data);
		                        	},
								});'
					)); ?>
					
						<?php //echo CHtml::activeDropDownList($model,"[$i]car_model_id", CHtml::listData(VehicleCarModel::model()->findAll(array('order'=>'name')),'id','name'),  array('prompt' => 'Select',)); ?>
						
					</div>
				</div>
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix">Car Sub Model</label>
					</div>
					<div class="small-8 columns">
						
						<?php echo CHtml::activeDropDownList($model,'car_sub_model_id', $model->car_model_id != '' ? CHtml::listData(VehicleCarSubModel::model()->findAllByAttributes(array('car_make_id'=>$model->car_make_id,'car_model_id'=>$model->car_model_id)),'id','name') : array() ,array('prompt' => '[--Select Car Sub Model--]',)); ?>
						
					</div>
				</div>
			</div>

			

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix">Rate</label>
					</div>
					<div class="small-8 columns">

						<?php echo CHtml::activeTextField($model,'rate',array('size'=>30,'maxlength'=>30)); ?>
						
					</div>
				</div>
			</div>

			

			
			<div class="field buttons text-center">
				
			  <?php echo CHtml::submitButton('Save', array('class'=>'button cbutton',)); ?>
			 
			  <?php //echo "test"; ?>
			</div>
			
			
			
		
			
			