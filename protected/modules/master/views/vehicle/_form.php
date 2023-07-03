<?php
/* @var $this VehicleController */
/* @var $model Vehicle */
/* @var $form CActiveForm */
?>

<div class="clearfix page-action">
    <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl . '/master/vehicle/admin'; ?>"><span class="fa fa-th-list"></span>Manage Customer Vehicles</a>
    <h1>
        <?php if ($model->isNewRecord) {
            echo "New Vehicle";
        } else {
            echo "Update Vehicle";
        } ?>
    </h1>

    <!-- begin FORM -->
    <div class="form">

        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'vehicle-form',
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
            'enableAjaxValidation' => false,
        )); ?>
        <hr />
        <p class="note">Fields with <span class="required">*</span> are required.</p>
        <?php echo $form->errorSummary($model); ?>

        <div class="row">
            <div class="small-12 medium-6 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($model, 'customer_id', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-6 columns">
                            <?php echo $form->hiddenField($model, 'customer_id'); ?>
                            <?php echo $form->textField($model, 'customer_name', array(
                                'onclick' => 'jQuery("#customer-dialog").dialog("open"); return false;',
                                'value' => $model->customer_id != Null ? $model->customer->name : '',
                            )); ?>

                            <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                                'id' => 'customer-dialog',
                                // additional javascript options for the dialog plugin
                                'options' => array(
                                    'title' => 'Customer',
                                    'autoOpen' => false,
                                    'width' => 'auto',
                                    'modal' => true,
                                ),
                            )); ?>

                            <?php $this->widget('zii.widgets.grid.CGridView', array(
                                'id' => 'customer-grid',
                                'dataProvider' => $customerDataProvider,
                                'filter' => $customer,
                                // 'summaryText'=>'',
                                'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                                'pager' => array(
                                    'cssFile' => false,
                                    'header' => '',
                                ),
                                'selectionChanged' => 'js:function(id){
                                    $("#Vehicle_customer_id").val($.fn.yiiGridView.getSelection(id));
                                    $("#customer-dialog").dialog("close");
                                    $.ajax({
                                        type: "POST",
                                        dataType: "JSON",
                                        url: "' . CController::createUrl('ajaxCustomer', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
                                        data: $("form").serialize(),
                                        success: function(data) {
                                            $("#Vehicle_customer_name").val(data.name);
                                            jQuery.ajax({
                                                type: "POST",
                                                url: "' . CController::createUrl('ajaxGetCustomerPic', array()) . '",
                                                data: jQuery("form").serialize(),
                                                success: function(data){
                                                    console.log(data);
                                                    jQuery("#Vehicle_customer_pic_id").html(data);
                                                    if (jQuery("#Vehicle_customer_id").val() == "") {
                                                        jQuery("#Vehicle_customer_pic_id").html("<option value=\"\">[--Select Customer Pic--]</option>");
                                                    }
                                                }
                                            });
                                        },
                                    });

                                    $("#customer-grid").find("tr.selected").each(function(){
		                   	$(this).removeClass( "selected" );
                                    });
                                }',
                                'columns' => array(
                                    'id',
                                    'name',
                                    'customer_type',
                                    'email',
                                    'address',
                                ),
                            )); ?>

                            <?php $this->endWidget(); ?>

                            <?php echo $form->error($model, 'customer_id'); ?>
                        </div>
                        <div class="small-2 columns"><a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->baseUrl . '/master/customer/create'; ?>"><span class="fa fa-plus"></span>Add</a></div>
                    </div>			
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($model, 'customer_pic_id', array('class' => 'prefix')); ?>
                        </div>
                        
                        <div class="small-8 columns">
                            <?php echo $form->dropDownList($model, 'customer_pic_id', $model->customer_id != '' ? CHtml::listData(CustomerPic::model()->findAllByAttributes(array('customer_id' => $model->customer_id), array('order' => 'name')), 'id', 'name') : array(), array('prompt' => '[--Select PIC--]',)); ?>
                            <?php echo $form->error($model, 'customer_pic_id'); ?>
                        </div>

                    </div>			
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($model, 'plate_number', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-2 columns">
                            <?php echo CHtml::activeDropDownList($model, "plate_number_prefix_id", CHtml::listData(VehiclePlateNumberPrefix::model()->findAll(array('order'=>'code')),'id','code'),  array('prompt' => '[--Select Code--]',)); ?>
                            <?php echo $form->error($model, 'plate_number_prefix_id'); ?>
                        </div>
                        <div class="small-3 columns">
                            <?php echo CHtml::activeTextField($model, "plate_number_ordinal", array('size'=>10,'maxlength'=>20)); ?>
                            <?php echo $form->error($model, 'plate_number_ordinal'); ?>
                        </div>
                        <div class="small-3 columns">
                            <?php echo CHtml::activeTextField($model, "plate_number_suffix", array('size'=>5,'maxlength'=>10, 'style' => 'text-transform: uppercase')); ?>
                            <?php echo $form->error($model, 'plate_number_suffix'); ?>
                        </div>
                    </div>			
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($model, 'machine_number', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($model, 'machine_number', array('size' => 30, 'maxlength' => 30)); ?>
                            <?php echo $form->error($model, 'machine_number'); ?>
                        </div>
                    </div>			
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($model, 'frame_number', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($model, 'frame_number', array('size' => 30, 'maxlength' => 30)); ?>
                            <?php echo $form->error($model, 'frame_number'); ?>
                        </div>
                    </div>			
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($model, 'color_id', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->dropDownList($model, 'color_id', CHtml::listData(Colors::model()->findAll(array('order' => 'name')), 'id', 'name'), array('prompt' => '[--Select Color--]',)); ?>
                            <?php echo $form->error($model, 'color_id'); ?>
                        </div>
                    </div>			
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($model, 'drivetrain', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($model, 'drivetrain', array('size' => 10, 'maxlength' => 10)); ?>
                            <?php echo $form->error($model, 'drivetrain'); ?>
                        </div>
                    </div>			
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($model, 'notes', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textArea($model, 'notes', array('rows' => 6, 'cols' => 50)); ?>
                            <?php echo $form->error($model, 'notes'); ?>
                        </div>
                    </div>			
                </div>
            </div>
            
            <div class="small-12 medium-6 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($model, 'year', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php $range = range(date('Y'), 1950); ?>
                            <?php echo $form->dropDownList($model, 'year', array_combine($range, $range), array(
                                'prompt' => '[--Select Year--]',
                                'onchange' => 'jQuery.ajax({
                                    type: "POST",
                                    url: "' . CController::createUrl('ajaxGetCarMake') . '",
                                    data: jQuery("form").serialize(),
                                    success: function(data) {
                                        console.log(data);
                                        jQuery("#Vehicle_car_make_id").html(data);
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
                            <?php echo $form->labelEx($model, 'car_make_id', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::activeDropDownList($model, 'car_make_id', CHtml::listData(VehicleCarMake::model()->findAll(array('order' => 'name')), 'id', 'name'), array(
                                'prompt' => '[--Select Car Make--]',
                                'onchange' => 'jQuery.ajax({
                                    type: "POST",
                                    //dataType: "JSON",
                                    url: "' . CController::createUrl('ajaxGetModel') . '",
                                    data: jQuery("form").serialize(),
                                    success: function(data) {
                                        console.log(data);
                                        jQuery("#Vehicle_car_model_id").html(data);
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
                            <?php echo $form->labelEx($model, 'car_model_id', array('class' => 'prefix')); ?>
                        </div>
                        
                        <div class="small-8 columns">
                            <?php echo CHtml::activeDropDownList($model, 'car_model_id', $model->car_make_id != '' ? CHtml::listData(VehicleCarModel::model()->findAllByAttributes(array('car_make_id' => $model->car_make_id,)), 'id', 'name') : array(), array(
                                'prompt' => '[--Select Car Model--]',
                                'onchange' => 'jQuery.ajax({
                                    type: "POST",
                                    //dataType: "JSON",
                                    url: "' . CController::createUrl('ajaxGetSubModel') . '",
                                    data: jQuery("form").serialize(),
                                    success: function(data){
                                        //console.log(data);
                                        jQuery("#Vehicle_car_sub_model_id").html(data);
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
                            <?php echo $form->labelEx($model, 'car_sub_model_id', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-6 columns">
                            <?php echo CHtml::activeDropDownList($model, 'car_sub_model_id', $model->car_model_id != '' ? CHtml::listData(VehicleCarSubModel::model()->findAllByAttributes(array('car_make_id' => $model->car_make_id, 'car_model_id' => $model->car_model_id)), 'id', 'name') : array(), array(
                                'prompt' => '[--Select Car Sub Model--]',
                                'onchange' => 'jQuery.ajax({
                                    type: "POST",
                                    dataType: "JSON",
                                    url: "' . CController::createUrl('ajaxGetSubModelDetails') . '",
                                    data: jQuery("form").serialize(),
                                    success: function(data){
                                        //console.log(data.transmission);
                                        jQuery("#Vehicle_power").html(data.power);
                                        jQuery("#Vehicle_fuel_type").html(data.fuel_type);
                                        jQuery("#Vehicle_transmission").html(data.transmission);
                                        jQuery("#Vehicle_chasis_code").val(data.chasis_code);
                                        jQuery("#Vehicle_car_sub_model_detail_id").html(data.model_detail);

                                        //jQuery("#sub_model_detail").slideDown();
                                    },
                                });',
                            )); ?>
                            <div id="sub_model_detail" style="display: none;">
                                <p class="note" id='fuel'></p>
                                <p class="note" id='transmission'></p>
                            </div>

                            <?php echo $form->error($model, 'car_sub_model_id'); ?>
                        </div>
                        <div class="small-2 columns"><a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->baseUrl . '/master/vehicleCarSubModel/create'; ?>"><span class="fa fa-plus"></span>Add</a>
                        </div>
                    </div>			
                </div>
                
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($model, 'car_sub_model_detail_id', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::activeDropDownList($model, 'car_sub_model_detail_id', CHtml::listData(VehicleCarSubModelDetail::model()->findAll(), 'id', 'name'), array(
                                'prompt' => '[--Select Car Sub Model--]', 'order' => 't.name ASC',
                            )); ?>
                            <?php //echo CHtml::activeTextField($model, 'car_sub_model_detail_id', array('readonly' => true)); ?>
                            <?php echo $form->error($model, 'car_sub_model_detail_id'); ?>
                        </div>
                    </div>			
                </div>
                
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($model, 'chasis_code', array('class' => 'prefix')); ?>
                        </div>
                        
                        <div class="small-8 columns">
                            <?php echo $form->textField($model, 'chasis_code', array('readonly' => true)); ?>
                            <?php echo $form->error($model, 'chasis_code'); ?>
                        </div>
                    </div>			
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($model, 'transmission', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php //echo $form->textField($model,'transmission',array('size'=>30,'maxlength'=>30)); ?>
                            <?php echo CHtml::activeDropDownList($model, 'transmission', array($model->transmission => $model->transmission), array('prompt' => '[--Select Transmission--]',
                                'onchange' => 'jQuery.ajax({
                                    type: "POST",
                                    dataType: "JSON",
                                    url: "' . CController::createUrl('ajaxGetFuelPower') . '",
                                    data: jQuery("form").serialize(),
                                    success: function(data) {
                                        //console.log(data);
                                        if (jQuery("#Vehicle_transmission").val() == "") {
                                            jQuery("#Vehicle_transmission").html(data.transmission);
                                            jQuery("#Vehicle_fuel_type").html(data.fuel_type);
                                            jQuery("#Vehicle_power").html(data.power);
                                        }
                                        if (!jQuery("#Vehicle_fuel_type").val()) {
                                            jQuery("#Vehicle_fuel_type").html(data.fuel_type);
                                        }
                                        if (!jQuery("#Vehicle_power").val()) {
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
                            <?php echo $form->labelEx($model, 'fuel_type', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::activeDropDownList($model, 'fuel_type', array($model->fuel_type => $model->fuel_type), array(
                                'prompt' => '[--Select Fuel Type--]',
                                'onchange' => 'jQuery.ajax({
                                    type: "POST",
                                    dataType: "JSON",
                                    url: "' . CController::createUrl('ajaxGetTransmissionPower') . '",
                                    data: jQuery("form").serialize(),
                                    success: function(data){
                                        //console.log(data);
                                        if (jQuery("#Vehicle_fuel_type").val() == "") {
                                            jQuery("#Vehicle_transmission").html(data.transmission);
                                            jQuery("#Vehicle_fuel_type").html(data.fuel_type);
                                            jQuery("#Vehicle_power").html(data.power);
                                        }
                                        if (!jQuery("#Vehicle_transmission").val()) {
                                            jQuery("#Vehicle_transmission").html(data.transmission);
                                        }
                                        if (!jQuery("#Vehicle_power").val()) {
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
                            <?php echo $form->labelEx($model, 'power', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::activeDropDownList($model, 'power', array($model->power => $model->power), array(
                                'prompt' => '[--Select Power--]',
                                'onchange' => 'jQuery.ajax({
                                    type: "POST",
                                    dataType: "JSON",
                                    url: "' . CController::createUrl('ajaxGetTransmissionFuel') . '",
                                    data: jQuery("form").serialize(),
                                    success: function(data){
                                        //console.log(data);
                                        if (jQuery("#Vehicle_power").val() == "") {
                                            jQuery("#Vehicle_transmission").html(data.transmission);
                                            jQuery("#Vehicle_fuel_type").html(data.fuel_type);
                                            jQuery("#Vehicle_power").html(data.power);
                                        }
                                        if (!jQuery("#Vehicle_transmission").val()) {
                                            jQuery("#Vehicle_transmission").html(data.transmission);
                                        }
                                        if (!jQuery("#Vehicle_fuel_type").val()) {
                                            jQuery("#Vehicle_fuel_type").html(data.fuel_type);
                                        }
                                    },
                                });'
                            )); ?>
                            <?php echo $form->error($model, 'power'); ?>
                        </div>
                    </div>			
                </div>
                
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($model, 'insurance_company_id', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::activeDropDownList($model, 'insurance_company_id', CHtml::listData(InsuranceCompany::model()->findAll(), 'id', 'name'), array(
                                'prompt' => '[--Select Insurance Company--]',
                            )); ?>
                            <?php echo $form->error($model, 'insurance_company_id'); ?>
                        </div>
                    </div>		
                </div>
                
            </div>
        </div>
        <hr />
        <div class="field buttons text-center">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'button cbutton')); ?>
        </div>

        <?php $this->endWidget(); ?>

    </div><!-- form -->
</div>	