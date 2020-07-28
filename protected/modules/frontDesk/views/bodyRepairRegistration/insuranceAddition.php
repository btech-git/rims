<div class="clearfix page-action">
	<div class="form">
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'registration-transaction-form',
			'htmlOptions' => array('enctype' => 'multipart/form-data'),
			'enableAjaxValidation'=>false,
        )); ?>
        <h1>Customer's Insurance Information Detail</h1>
		<p class="note">Fields with <span class="required">*</span> are required.</p>

		<?php echo $form->errorSummary($registrationInsuranceData); ?>
		<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
		<?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
		<div class="row">
            <div class="medium-12 columns">
                <div class="row">
                    <h2>Customer</h2>
                    <table>
                        <thead>
                            <tr>
                                <td>Name</td>
                                <td>Type</td>
                                <td>Address</td>
                                <td>Email</td>
                                <td>Rate</td>
                                <td>Birth Date</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo CHtml::encode(CHtml::value($customer, 'name')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($customer, 'customer_type')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($customer, 'email')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($customer, 'address')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($customer, 'flat_rate')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($customer, 'birthdate')); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <h2>Vehicle</h2>
                    <table>
                        <thead>
                            <tr>
                                <td>Plate #</td>
                                <td>Machine #</td>
                                <td>Car Make</td>
                                <td>Model</td>
                                <td>Sub Model</td>
                                <td>Color</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <?php echo $form->hiddenField($registrationTransaction, 'vehicle_id'); ?>
                                    <?php echo CHtml::encode(CHtml::value($vehicle, 'plate_number')); ?>
                                    <?php echo $form->error($registrationTransaction,'vehicle_id'); ?>
                                </td>
                                <td><?php echo CHtml::encode(CHtml::value($vehicle, 'machine_number')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($vehicle, 'carMake.name')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($vehicle, 'carModel.name')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($vehicle, 'carSubModel.name')); ?></td>
                                <td>
                                    <?php $color = Colors::model()->findByPk($vehicle->color_id); ?>
                                    <?php echo CHtml::encode(CHtml::value($color, 'name')); ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="detail">
                    <div class="field" id="insurance">
                        <div class="row collapse">
                            <div class="small-12 columns">
                                  <?php 
                                    $insuranceRates = InsuranceCompanyPricelist::model()->findAllByAttributes(array('insurance_company_id'=>$registrationTransaction->insurance_company_id));
                                    if (count($insuranceRates)> 0) : ?>
                                    <table>
                                      <caption><?php echo CHtml::encode(CHtml::value($insuranceCompany, 'name')); ?> Service Exception Rate</caption>
                                      <thead>
                                        <tr>
                                          <th>Service Name</th>
                                          <th>Damage</th>
                                          <th>Vehicle Type</th>
                                          <th>Price</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <?php foreach ($insuranceRates as $key => $insuranceRate): ?>
                                          <tr>
                                            <td><?php echo $insuranceRate->service->name; ?></td>
                                            <td><?php echo $insuranceRate->damage_type; ?></td>
                                            <td><?php echo $insuranceRate->vehicle_type; ?></td>
                                            <td style="text-align: right"><?php echo number_format($insuranceRate->price, 2); ?></td>
                                          </tr>
                                        <?php endforeach ?>
                                      </tbody>
                                    </table>
                                  <?php endif ?>
                                  <h3>Insurance Data</h3>
                                    <?php /*echo CHtml::button('X', array(
                                        'onclick' => CHtml::ajax(array(
                                          'type' => 'POST',
                                          'url' => CController::createUrl('ajaxHtmlRemoveInsuranceDetail', array('id' => $registrationTransaction->id)),
                                          'update' => '#insurance',
                                        )),
                                    ));*/ ?>
                                  <hr>
                                  <div class="row">
                                    <div class="large-6 columns">
                                      <div class="row collapse prefix-radius">
                                        <div class="small-5 columns">
                                          <span class="prefix required">Insured's Name</span>
                                        </div>
                                        <div class="small-7 columns">
                                          <?php echo CHtml::activeHiddenField($registrationInsuranceData,"insurance_company_id"); ?>
                                          <?php echo CHtml::activeTextField($registrationInsuranceData,"insured_name"); ?>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="large-6 columns">
                                      <div class="row collapse postfix-radius">
                                        <div class="small-5 columns">
                                          <span class="prefix required">Email</span>
                                        </div>
                                        <div class="small-7 columns">
                                          <?php echo CHtml::activeTextField($registrationInsuranceData,"insured_email"); ?>
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="row">
                                    <div class="large-6 columns">
                                      <div class="row collapse prefix-radius">
                                        <div class="small-5 columns">
                                          <span class="prefix required">Insurance Policy Number</span>
                                        </div>
                                        <div class="small-7 columns">
                                          <?php echo CHtml::activeTextField($registrationInsuranceData,"insurance_policy_number"); ?>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="large-6 columns">
                                      <div class="row collapse postfix-radius">
                                        <div class="small-5 columns">
                                          <span class="prefix required">Address</span>
                                        </div>
                                        <div class="small-7 columns">
                                          <?php echo CHtml::activeTextArea($registrationInsuranceData,"insured_address"); ?>
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="row">
                                    <div class="large-6 columns">
                                      <div class="row collapse prefix-radius"></div>
                                    </div>
                                    <div class="large-6 columns">
                                      <div class="row collapse postfix-radius">
                                        <div class="small-5 columns">
                                          <span class="prefix required">Province</span>
                                        </div>
                                        <div class="small-7 columns">
                                          <?php echo CHtml::activeDropDownList($registrationInsuranceData, "insured_province_id", CHtml::listData(Province::model()->findAll(), 'id', 'name'),array(
                                                'prompt' => '[--Select Province--]',
                                                'onchange'=> '$.ajax({
                                                type: "POST",
                                                //dataType: "JSON",
                                                url: "' . CController::createUrl('ajaxGetCity') . '" ,

                                                data: $("form").serialize(),
                                                success: function(data){
                                                  console.log(data);
                                                  $("#RegistrationInsuranceData_insured_city_id").html(data);
                                                },
                                              });'
                                            )); ?>
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="row">
                                    <div class="large-6 columns">
                                      <div class="row collapse prefix-radius">
                                        <div class="small-5 columns">
                                          <span class="prefix ">Insurance Policy Start</span>
                                        </div>
                                        <div class="small-7 columns">
                                          <?php //echo CHtml::activeTextField($registrationInsuranceData,"insurance_policy_period_start"); ?>
                                          <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                              'model' => $registrationInsuranceData,
                                               'attribute' => "insurance_policy_period_start",
                                               // additional javascript options for the date picker plugin
                                               'options'=>array(
                                                // 'disabled'=>true,
                                                   'dateFormat' => 'yy-mm-dd',
                                                   'onClose'=>'js:function(date) {

                                                    $("#RegistrationInsuranceData_insurance_policy_period_end").datepicker( "option", "minDate", date);
                                                        // alert(date);
                                                     }',
                                               ),

                                           ));
                                          ?>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="large-6 columns">
                                      <div class="row collapse postfix-radius">
                                        <div class="small-5 columns">
                                          <span class="prefix required">City</span>
                                        </div>
                                        <div class="small-7 columns">

                                           <?php
                                                if ($registrationInsuranceData->insured_province_id == NULL) {
                                                  echo CHtml::activeDropDownList($registrationInsuranceData,"insured_city_id",array(),array('prompt'=>'[--Select City-]'));
                                                }
                                                else {
                                                  echo CHtml::activeDropDownList($registrationInsuranceData,"insured_city_id",CHtml::listData(City::model()->findAllByAttributes(array('province_id'=>$registrationInsuranceData->insured_province_id)), 'id', 'name'),array());
                                                }
                                              ?>
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="row">
                                    <div class="large-6 columns">
                                      <div class="row collapse prefix-radius">
                                        <div class="small-5 columns">
                                          <span class="prefix ">Insurance Policy End</span>
                                        </div>
                                        <div class="small-7 columns">
                                          <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                              'model' => $registrationInsuranceData,
                                               'attribute' => "insurance_policy_period_end",
                                               // additional javascript options for the date picker plugin
                                               'options'=>array(
                                                   'dateFormat' => 'yy-mm-dd',
                                               ),
                                           ));
                                          ?>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="large-6 columns">
                                      <div class="row collapse postfix-radius">
                                        <div class="small-5 columns">
                                          <span class="prefix">Zipcode</span>
                                        </div>
                                        <div class="small-7 columns">
                                          <?php echo CHtml::activeTextField($registrationInsuranceData,"insured_zipcode"); ?>
                                        </div>
                                      </div>
                                    </div>
                                  </div>  

                                  <div class="row">
                                    <div class="large-6 columns">
                                      <div class="row collapse prefix-radius">
                                        <div class="small-5 columns">
                                          <span class="prefix">Deductible / Own Risk</span>
                                        </div>
                                        <div class="small-7 columns">
                                          <?php echo CHtml::activeTextField($registrationInsuranceData,"deductible_own_risk"); ?>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="large-6 columns">
                                      <div class="row collapse postfix-radius">
                                        <div class="small-5 columns">
                                          <span class="prefix">Occupation</span>
                                        </div>
                                        <div class="small-7 columns">
                                          <?php echo CHtml::activeTextField($registrationInsuranceData,"insured_occupation"); ?>
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="row">
                                    <div class="large-6 columns">
                                      <div class="row collapse prefix-radius">
                                        <div class="small-5 columns">
                                          <span class="prefix ">Telephone</span>
                                        </div>
                                        <div class="small-7 columns">
                                          <?php echo CHtml::activeTextField($registrationInsuranceData,"insured_telephone"); ?>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="large-6 columns">
                                      <div class="row collapse postfix-radius">
                                        <div class="small-5 columns">
                                          <span class="prefix required">Handphone</span>
                                        </div>
                                        <div class="small-7 columns">
                                          <?php echo CHtml::activeTextField($registrationInsuranceData,"insured_handphone"); ?>
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                                  <h3>Accident Detail (Description)</h3>
                                  <hr>

                                  <div class="row">
                                    <div class="large-6 columns">
                                      <div class="row collapse prefix-radius">
                                        <div class="small-5 columns">
                                          <span class="prefix ">Driver's Name</span>
                                        </div>
                                        <div class="small-7 columns">
                                          <?php echo CHtml::activeTextField($registrationInsuranceData,"driver_name"); ?>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="large-6 columns">
                                      <div class="row collapse postfix-radius">
                                        <div class="small-5 columns">
                                          <span class="prefix ">Email</span>
                                        </div>
                                        <div class="small-7 columns">
                                          <?php echo CHtml::activeTextField($registrationInsuranceData,"driver_email"); ?>
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="row">
                                    <div class="large-6 columns">
                                      <div class="row collapse prefix-radius">
                                        <div class="small-5 columns">
                                          <span class="prefix ">ID Number</span>
                                        </div>
                                        <div class="small-7 columns">
                                          <?php echo CHtml::activeTextField($registrationInsuranceData,"driver_id_number"); ?>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="large-6 columns">
                                      <div class="row collapse postfix-radius">
                                        <div class="small-5 columns">
                                          <span class="prefix ">License Number</span>
                                        </div>
                                        <div class="small-7 columns">
                                          <?php echo CHtml::activeTextField($registrationInsuranceData,"driver_license_number"); ?>
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="row">
                                    <div class="large-6 columns">
                                      <div class="row collapse prefix-radius">
                                        <div class="small-5 columns">
                                          <span class="prefix ">Relation With Insured</span>
                                        </div>
                                        <div class="small-7 columns">
                                          <?php echo CHtml::activeTextField($registrationInsuranceData,"relation_with_insured"); ?>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="large-6 columns">
                                      <div class="row collapse postfix-radius">
                                        <div class="small-5 columns">
                                          <span class="prefix">Occupation</span>
                                        </div>
                                        <div class="small-7 columns">
                                          <?php echo CHtml::activeTextField($registrationInsuranceData,"driver_occupation"); ?>
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="row">
                                    <div class="large-6 columns">
                                      <div class="row collapse prefix-radius">
                                        <div class="small-5 columns">
                                          <span class="prefix ">Telephone</span>
                                        </div>
                                        <div class="small-7 columns">
                                          <?php echo CHtml::activeTextField($registrationInsuranceData,"driver_telephone"); ?>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="large-6 columns">
                                      <div class="row collapse postfix-radius">
                                        <div class="small-5 columns">
                                          <span class="prefix ">HandPhone</span>
                                        </div>
                                        <div class="small-7 columns">
                                          <?php echo CHtml::activeTextField($registrationInsuranceData,"driver_handphone"); ?>
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="row">
                                    <div class="large-6 columns">
                                      <div class="row collapse postfix-radius">
                                        <div class="small-5 columns">
                                          <span class="prefix ">Address</span>
                                        </div>
                                        <div class="small-7 columns">
                                          <?php echo CHtml::activeTextArea($registrationInsuranceData,"driver_address"); ?>
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="row">
                                    <div class="large-6 columns">
                                      <div class="row collapse prefix-radius">
                                        <div class="small-5 columns">
                                          <span class="prefix ">Other Passenger Name</span>
                                        </div>
                                        <div class="small-7 columns">
                                          <?php echo CHtml::activeTextField($registrationInsuranceData,"other_passenger_name"); ?>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="large-6 columns">
                                      <div class="row collapse postfix-radius">
                                        <div class="small-5 columns">
                                          <span class="prefix ">Province</span>
                                        </div>
                                        <div class="small-7 columns">

                                         <?php echo CHtml::activeDropDownList($registrationInsuranceData, "driver_province_id", CHtml::listData(Province::model()->findAll(), 'id', 'name'),array(
                                            'prompt' => '[--Select Province--]',
                                            'onchange'=> '$.ajax({
                                            type: "POST",
                                            //dataType: "JSON",
                                            url: "' . CController::createUrl('ajaxGetCityDriver') . '" ,

                                            data: $("form").serialize(),
                                            success: function(data){
                                              console.log(data);
                                              $("#RegistrationInsuranceData_driver_city_id").html(data);
                                            },
                                          });'
                                            )); ?>
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="row">
                                    <div class="large-6 columns">
                                      <div class="row collapse prefix-radius">
                                        <div class="small-5 columns">
                                          <span class="prefix ">Accident Place</span>
                                        </div>
                                        <div class="small-7 columns">
                                          <?php echo CHtml::activeTextField($registrationInsuranceData,"accident_place"); ?>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="large-6 columns">
                                      <div class="row collapse postfix-radius">
                                        <div class="small-5 columns">
                                          <span class="prefix ">City</span>
                                        </div>
                                        <div class="small-7 columns">
                                          <?php
                                                if ($registrationInsuranceData->driver_province_id == NULL) {
                                                  echo CHtml::activeDropDownList($registrationInsuranceData,"driver_city_id",array(),array('prompt'=>'[--Select City-]'));
                                                }
                                                else {
                                                  echo CHtml::activeDropDownList($registrationInsuranceData,"driver_city_id",CHtml::listData(City::model()->findAllByAttributes(array('province_id'=>$registrationInsuranceData->driver_province_id)), 'id', 'name'),array());
                                                }
                                              ?>
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="row">
                                    <div class="large-6 columns">
                                      <div class="row collapse prefix-radius">
                                        <div class="small-5 columns">
                                          <span class="prefix ">Accident Date and Time</span>
                                        </div>
                                        <div class="small-7 columns">
                                          <?php echo CHtml::activeTextField($registrationInsuranceData,"accident_date_time"); ?>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="large-6 columns">
                                      <div class="row collapse postfix-radius">
                                        <div class="small-5 columns">
                                          <span class="prefix ">Damage Description</span>
                                        </div>
                                        <div class="small-7 columns">
                                          <?php echo CHtml::activeTextField($registrationInsuranceData,"damage_description"); ?>
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="row">
                                    <div class="large-6 columns">
                                      <div class="row collapse prefix-radius">
                                        <div class="small-5 columns">
                                          <span class="prefix ">Speed</span>
                                        </div>
                                        <div class="small-7 columns">
                                          <?php echo CHtml::activeTextField($registrationInsuranceData,"speed"); ?>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="large-6 columns">
                                      <div class="row collapse postfix-radius">
                                        <div class="small-5 columns">
                                          <span class="prefix ">Witness</span>
                                        </div>
                                        <div class="small-7 columns">
                                          <?php echo CHtml::activeTextField($registrationInsuranceData,"witness"); ?>
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="row">
                                    <div class="large-6 columns">
                                      <div class="row collapse prefix-radius">
                                        <div class="small-5 columns">
                                          <span class="prefix ">Injury</span>
                                        </div>
                                        <div class="small-7 columns">
                                          <?php echo CHtml::activeTextField($registrationInsuranceData,"injury"); ?>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="large-6 columns">
                                      <div class="row collapse postfix-radius">
                                        <div class="small-5 columns">
                                          <span class="prefix ">Reported to Police?</span>
                                        </div>
                                        <div class="small-7 columns">
                                        <?php echo CHtml::activeDropDownList($registrationInsuranceData,"is_reported",array('0'=>"NO",'1'=>'YES')); ?>
                                        </div>
                                      </div>
                                    </div>
                                  </div>  

                                  <div class="row">
                                   <div class="large-12 columns">
                                    <label >Accident Description
                                      <?php echo CHtml::activeTextArea($registrationInsuranceData,"accident_description"); ?>
                                    </label>
                                    </div>
                                  </div>

                                  <h3>Other Details</h3>
                                  <hr />

                                  <div class="row">
                                    <div class="large-12 columns">
                                      <label>Insurance Surveyor Request
                                        <?php echo CHtml::activeTextArea($registrationInsuranceData,"insurance_surveyor_request"); ?>
                                      </label>
                                    </div>
                                  </div>

                                  <div class="row">
                                    <div class="large-12 columns">
                                      <label >Customer Request
                                        <?php echo CHtml::activeTextArea($registrationInsuranceData,"customer_request"); ?>
                                      </label>
                                    </div>
                                  </div> 
                                <?php //endforeach ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="medium-12 columns">
                    <div class="field buttons text-center">
                        <?php echo CHtml::hiddenField('_FormSubmit_', ''); ?>
                        <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
                        <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?', 'class'=>'button cbutton', 'onclick' => '$("#_FormSubmit_").val($(this).attr("name")); this.disabled = true')); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>