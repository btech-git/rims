<div class="form">
    <div class="row">
        <div class="small-12 medium-6 columns">
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
            <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix">Plate Number</label>
					</div>
					<div class="small-8 columns">
						<?php echo CHtml::activeTextField($model,'plate_number',array('size'=>30,'maxlength'=>30)); ?>
					</div>
				</div>
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix">Machine Number</label>
					</div>
					<div class="small-8 columns">
						<?php echo CHtml::activeTextField($model,'machine_number',array('size'=>30,'maxlength'=>30)); ?>
					</div>
				</div>
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix">Frame Number</label>
					</div>
					<div class="small-8 columns">
						<?php echo CHtml::activeTextField($model,'frame_number',array('size'=>30,'maxlength'=>30)); ?>
					</div>
				</div>
			</div>
            
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix">Color</label>
					</div>
					<div class="small-8 columns">
						<?php echo CHtml::activeDropDownList($model,'color_id', CHtml::listData(Colors::model()->findAll(array('order'=>'name')),'id','name'),  array('prompt'=>'[--Select Color--]')); ?>
					</div>
				</div>
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix">Notes</label>
					</div>
					<div class="small-8 columns">
						<?php echo CHtml::activeTextArea($model,'notes',array('rows'=>6,'cols'=>50)); ?>
					</div>
				</div>
			</div>
        </div>
        <div class="small-12 medium-6 columns">
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix">Year</label>
					</div>
					<div class="small-8 columns">
						<?php $range = range(date('Y'),1950); ?>
						<?php echo CHtml::activeDropDownList($model,'year',array_combine($range, $range),array(
							'prompt'=>'[--Select Year--]',
							'onchange'=>'jQuery.ajax({
								type: "POST",
								// url: "' . CController::createUrl('ajaxGetCarMake') . '",
								url: "' . CController::createUrl('ajaxGetCarMake',array()) . '/year/" + jQuery(this).val(),
								data: jQuery("form").serialize(),
								success: function(data){
		                        	console.log(data);
		                        	jQuery("#Vehicle_car_make_id").html(data);

		                        	jQuery("#Vehicle_car_model_id").html("<option value=\"\">[--Select Car Model--]</option>");
			                        jQuery("#Vehicle_car_sub_model_id").html("<option value=\"\">[--Select Car Sub Model--]</option>");
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
						<?php echo CHtml::activeDropDownList($model,'car_make_id', CHtml::listData(VehicleCarMake::model()->findAll(array('order'=>'name')),'id','name'),array(
                            'prompt' => '[--Select Car Make--]',
                            'onchange'=> 'jQuery.ajax({
                                type: "POST",
                                //dataType: "JSON",
                                // url: "' . CController::createUrl('ajaxGetModel',array()) . '/carmake/" + jQuery(this).val(),
                                url: "' . CController::createUrl('ajaxGetModel',array()) . '/year/" + $("#Vehicle_year").val()  + "/carmake/" +  $(this).val(),
                                data: jQuery("form").serialize(),
                                success: function(data){
                                    console.log(data);
                                    jQuery("#Vehicle_car_model_id").html(data);
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
                                url: "' . CController::createUrl('ajaxGetSubModel',array()) . '/year/"+$("#Vehicle_year").val()+ "/carmake/" + $("#Vehicle_car_make_id").val()  + "/carmodel/" +  $(this).val(),

                                data: jQuery("form").serialize(),
                                success: function(data){
                                    console.log(data);
                                    jQuery("#Vehicle_car_sub_model_id").html(data);
                                },
                            });'
                        )); ?>
					</div>
				</div>
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix">Car Sub Model</label>
					</div>
					<div class="small-8 columns">
						<?php echo CHtml::activeDropDownList($model,'car_sub_model_id', $model->car_model_id != '' ? CHtml::listData(VehicleCarSubModel::model()->findAllByAttributes(array('car_make_id'=>$model->car_make_id,'car_model_id'=>$model->car_model_id)),'id','name') : array() ,array(
                            'prompt' => '[--Select Car Sub Model--]',
                            'onchange'=> 'jQuery.ajax({
                                type: "POST",
                                dataType: "JSON",
                                url: "' . CController::createUrl('ajaxGetSubModelDetails',array()) . '/year/" + $("#Vehicle_year").val()  + "/carsubmodel/" +  $(this).val(),
                                //url: "' . CController::createUrl('ajaxGetTransmission') . '",
                                data: jQuery("form").serialize(),
                                success: function(data){
                                    //console.log(data.transmission);
                                    jQuery("#Vehicle_chasis_code").val(data.chasis);
                                    jQuery("#Vehicle_power").html(data.power);
                                    jQuery("#Vehicle_fuel_type").html(data.fuel_type);
                                    jQuery("#Vehicle_transmission").html(data.transmission);
                                    jQuery("#Vehicle_chasis_code").val(data.chasis_code);

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
                        <label class="prefix">Chasis Code</label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::activeTextField($model,'chasis_code',array('readonly'=>true)); ?>
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
                        <?php echo CHtml::activeDropDownList($model,'transmission', array($model->transmission=>$model->transmission) ,array('prompt' => '[--Select Transmission--]',
                            'onchange'=> 'jQuery.ajax({
                                type: "POST",
                                dataType: "JSON",
                                url: "' . CController::createUrl('ajaxGetFuelPower',array()) . '/carsubmodel/" + $("#Vehicle_car_sub_model_id").val()  + "/transmission/" +  $(this).val(),
                                data: jQuery("form").serialize(),
                                success: function(data){
                                    //console.log(data);
                                    if(jQuery("#Vehicle_transmission").val() == ""){
                                        jQuery("#Vehicle_transmission").html(data.transmission);
                                        jQuery("#Vehicle_fuel_type").html(data.fuel_type);
                                        jQuery("#Vehicle_power").html(data.power);
                                    }
                                    if(!jQuery("#Vehicle_fuel_type").val()){
                                        jQuery("#Vehicle_fuel_type").html(data.fuel_type);
                                    }
                                    if(!jQuery("#Vehicle_power").val()){
                                        jQuery("#Vehicle_power").html(data.power);
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
                        <?php echo CHtml::activeDropDownList($model,'fuel_type', array($model->fuel_type=>$model->fuel_type) ,array('prompt' => '[--Select Fuel Type--]',
                            'onchange'=> 'jQuery.ajax({
                                type: "POST",
                                dataType: "JSON",
                                url: "' . CController::createUrl('ajaxGetTransmissionPower',array()) . '/carsubmodel/" + $("#Vehicle_car_sub_model_id").val()  + "/fueltype/" +  $(this).val(),
                                data: jQuery("form").serialize(),
                                success: function(data){
                                    //console.log(data);
                                    if(jQuery("#Vehicle_fuel_type").val() == ""){
                                        jQuery("#Vehicle_transmission").html(data.transmission);
                                        jQuery("#Vehicle_fuel_type").html(data.fuel_type);
                                        jQuery("#Vehicle_power").html(data.power);
                                    }
                                    if(!jQuery("#Vehicle_transmission").val()){
                                        jQuery("#Vehicle_transmission").html(data.transmission);
                                    }
                                    if(!jQuery("#Vehicle_power").val()){
                                        jQuery("#Vehicle_power").html(data.power);
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
                        <label class="prefix">Power </label>
                    </div>
                    <div class="small-8 columns">
                        <?php //echo $form->textField($model,'power'); ?>
                        <?php echo CHtml::activeDropDownList($model,'power', array($model->power=>$model->power) ,array('prompt' => '[--Select Power--]',
                            'onchange'=> 'jQuery.ajax({
                                type: "POST",
                                dataType: "JSON",
                                url: "' . CController::createUrl('ajaxGetTransmissionFuel',array()) . '/carsubmodel/" + $("#Vehicle_car_sub_model_id").val()  + "/power/" +  $(this).val(),
                                data: jQuery("form").serialize(),
                                success: function(data){
                                    //console.log(data);
                                    if(jQuery("#Vehicle_power").val() == ""){
                                        jQuery("#Vehicle_transmission").html(data.transmission);
                                        jQuery("#Vehicle_fuel_type").html(data.fuel_type);
                                        jQuery("#Vehicle_power").html(data.power);
                                    }
                                    if(!jQuery("#Vehicle_transmission").val()){
                                        jQuery("#Vehicle_transmission").html(data.transmission);
                                    }
                                    if(!jQuery("#Vehicle_fuel_type").val()){
                                        jQuery("#Vehicle_fuel_type").html(data.fuel_type);
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
                        <label class="prefix">Drive Train</label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::activeTextField($model,'drivetrain',array('size'=>10,'maxlength'=>10)); ?>

                    </div>
                </div>			
            </div>

			<div class="field buttons text-center">
			  <?php echo CHtml::submitButton('Save', array('class'=>'button cbutton',)); ?>
			</div>
        </div>
    </div>
</div>