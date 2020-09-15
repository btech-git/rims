<?php $this->breadcrumbs=array(
 	'Customers'=>array('admin'),
	'Create',
); ?>

<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'vehicle-form',
    )); ?>
	<div class="row">
        <?php echo $form->errorSummary($model); ?>
        <div id="maincontent">
            <h2>Customer</h2>
            <div id="customer">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Address</th>
                            <th>Email</th>
                            <th>Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo CHtml::encode(CHtml::value($customer, 'name')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($customer, 'customer_type')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($customer, 'address')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($customer, 'email')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($customer, 'note')); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h2>Vehicle</h2>
            <div id="vehicle">
                <div class="small-12 medium-6 columns">
                    <div class="clearfix"></div>
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">Plate Number</label>
                            </div>
                            <div class="small-2 columns">
                                <?php echo CHtml::activeDropDownList($model, "plate_number_prefix_id", CHtml::listData(VehiclePlateNumberPrefix::model()->findAll(array('order'=>'code')),'id','code'),  array('prompt' => '[--Select Code--]',)); ?>
                                <?php echo $form->error($model, 'plate_number_prefix_id'); ?>
                            </div>
                            <div class="small-3 columns">
                                <?php echo CHtml::activeTextField($model, "plate_number_ordinal", array('size'=>10,'maxlength'=>4)); ?>
                                <?php echo $form->error($model, 'plate_number_ordinal'); ?>
                            </div>
                            <div class="small-3 columns">
                                <?php echo CHtml::activeTextField($model, "plate_number_suffix", array('size'=>5,'maxlength'=>3, 'style' => 'text-transform: uppercase')); ?>
                                <?php echo $form->error($model, 'plate_number_suffix'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">Machine Number</label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo CHtml::activeTextField($model,"machine_number",array('size'=>30,'maxlength'=>30)); ?>
                                <?php echo $form->error($model, 'machine_number'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">Frame Number</label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo CHtml::activeTextField($model,"frame_number",array('size'=>30,'maxlength'=>30)); ?>
                                <?php echo $form->error($model, 'frame_number'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">Color</label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo CHtml::activeDropDownList($model,"color_id", CHtml::listData(Colors::model()->findAll(array('order'=>'name')),'id','name'),  array('prompt' => '[--Select Color--]',)); ?>
                                <?php echo $form->error($model, 'color_id'); ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">Drivetrain</label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo CHtml::activeTextField($model,"drivetrain",array('size'=>10,'maxlength'=>10)); ?>
                                <?php echo $form->error($model, 'drivetrain'); ?>
                            </div>
                        </div>			
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">Notes</label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo CHtml::activeTextArea($model,"notes",array('rows'=>6,'cols'=>50)); ?>
                                <?php echo $form->error($model, 'notes'); ?>
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
                                <?php $range = range(date('Y'), 1950); ?>

                                <?php echo CHtml::activeDropDownList($model,"year",array_combine($range, $range), array(
                                    'prompt'=>'[--Select Year--]',
                                    'onchange'=>'jQuery.ajax({
                                        type: "POST",
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
                                <?php echo $form->error($model, 'year'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">Car Make</label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo CHtml::activeDropDownList($model,"car_make_id", CHtml::listData(VehicleCarMake::model()->findAll(array('order'=>'name')),'id','name'),array(
                                    'prompt' => '[--Select Car Make--]',
                                    'onchange'=> 'jQuery.ajax({
                                        type: "POST",
                                        //dataType: "JSON",
                                        url: "' . CController::createUrl('ajaxGetModel',array()) . '/year/" + $("#Vehicle_year").val()  + "/carmake/" +  $(this).val(),
                                        data: jQuery("form").serialize(),
                                        success: function(data){
                                            console.log(data);
                                            jQuery("#Vehicle_car_model_id").html(data);
                                            jQuery("#Vehicle_car_sub_model_id").html("<option value=\"\">[--Select Car Sub Model--]</option>");
                                        },

                                    });'
                                )); ?>
                                <?php echo $form->error($model, 'car_make_id'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">Car Model</label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo CHtml::activeDropDownList($model,"car_model_id", $model->car_make_id != '' ?CHtml::listData(VehicleCarModel::model()->findAllByAttributes(array('car_make_id'=>$model->car_make_id),array('order'=>'name')),'id','name') : array() ,array(
                                        'prompt' => '[--Select Car Model--]',
                                    'onchange'=> '$.ajax({
                                        type: "POST",
                                        //dataType: "JSON",
                                        url: "' . CController::createUrl('ajaxGetSubModel',array()) . '/year/"+$("#Vehicle_year").val()+ "/carmake/" + $("#Vehicle_car_make_id").val()  + "/carmodel/" +  $(this).val(),

                                        data: $("form").serialize(),
                                        success: function(data){
                                            console.log(data);
                                            $("#Vehicle_car_sub_model_id").html(data);
                                        },
                                    });'
                                )); ?> 
                                <?php echo $form->error($model, 'car_model_id'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">Car Sub Model</label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo CHtml::activeDropDownList($model,"car_sub_model_id", $model->car_model_id != ''?  CHtml::listData(VehicleCarSubModel::model()->findAllByAttributes(array('car_make_id'=>$model->car_make_id,'car_model_id'=>$model->car_model_id)),'id','name') : array() ,array(
                                    'prompt' => '[--Select Car Sub Model--]',
                                    'onchange'=> 'jQuery.ajax({
                                        type: "POST",
                                        dataType: "JSON",
                                        url: "' . CController::createUrl('ajaxGetSubModelDetails',array()) . '/year/" + $("#Vehicle_year").val()  + "/carsubmodel/" +  $(this).val(),
                                        data: jQuery("form").serialize(),
                                        success: function(data){
                                            //console.log(data.transmission);
                                            jQuery("#Vehicle_chasis_code").val(data.chasis);
                                            jQuery("#Vehicle_power").html(data.power);
                                            jQuery("#Vehicle_fuel_type").html(data.fuel_type);
                                            jQuery("#Vehicle_transmission").html(data.transmission);
                                            jQuery("#Vehicle_chasis_code").val(data.chasis_code);
                                        },
                                    });'
                                ,)); ?>
                                <?php echo $form->error($model, 'car_sub_model_id'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">Chasis Code</label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo CHtml::activeTextField($model,"chasis_code",array('size'=>30,'maxlength'=>30)); ?>
                                <?php echo $form->error($model, 'chasis_code'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">Transmission</label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo CHtml::activeDropDownList($model,"transmission", array($model->transmission=>$model->transmission) ,array('prompt' => '[--Select Transmission--]',
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
                                <?php echo $form->error($model, 'transmission'); ?>
                            </div>
                        </div>			
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">Fuel Type</label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo CHtml::activeDropDownList($model,"fuel_type", array($model->fuel_type=>$model->fuel_type) ,array('prompt' => '[--Select Fuel Type--]',
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
                                <?php echo $form->error($model, 'fuel_type'); ?>
                            </div>
                        </div>			
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">Power CC</label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo CHtml::activeDropDownList($model,"power", array($model->power=>$model->power) ,array('prompt' => '[--Select Power--]',
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
                                <?php echo $form->error($model, 'power'); ?>
                            </div>
                        </div>			
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <hr />
    
    <div class="field buttons text-center">
        <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'class'=>'button alert', 'confirm' => 'Are you sure you want to cancel?')); ?>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Save + Exit' : 'Update + Exit', array('name' => 'Submit', 'class'=>'button primary', 'confirm' => 'Are you sure you want to save?')); ?>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Save + Add' : 'Update + Add', array('name' => 'Add', 'class'=>'button success', 'confirm' => 'Are you sure you want to save?')); ?>
	</div>

    <?php $this->endWidget(); ?>
</div>
