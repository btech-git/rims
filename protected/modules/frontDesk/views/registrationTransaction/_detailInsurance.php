

<?php foreach ($registrationTransaction->insuranceDetails as $i => $insuranceDetail): ?>
  <?php 
    $insuranceRates = InsuranceCompanyPricelist::model()->findAllByAttributes(array('insurance_company_id'=>$insuranceDetail->insurance_company_id));
    if (count($insuranceRates)> 0) : ?>
    <table>
      <caption>Insurance Company Service Exception Rate</caption>
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
            <td><?php echo $insuranceRate->price; ?></td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  <?php endif ?>
  <h3>Insurance Data</h3>
  <?php
    echo CHtml::button('X', array(
      'onclick' => CHtml::ajax(array(
          'type' => 'POST',
          'url' => CController::createUrl('ajaxHtmlRemoveInsuranceDetail', array('id' => $registrationTransaction->header->id, 'index' => $i)),
          'update' => '#insurance',
        )),
    ));
  ?>
  <hr>
  <div class="row">
  	<div class="large-6 columns">
      <div class="row collapse prefix-radius">
        <div class="small-5 columns">
          <span class="prefix required">Insured's Name</span>
        </div>
        <div class="small-7 columns">
          <?php echo CHtml::activeHiddenField($insuranceDetail,"[$i]insurance_company_id"); ?>
          <?php echo CHtml::activeTextField($insuranceDetail,"[$i]insured_name"); ?>
        </div>
      </div>
    </div>
    <div class="large-6 columns">
      <div class="row collapse postfix-radius">
        <div class="small-5 columns">
          <span class="prefix required">Email</span>
        </div>
        <div class="small-7 columns">
          <?php echo CHtml::activeTextField($insuranceDetail,"[$i]insured_email"); ?>
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
          <?php echo CHtml::activeTextField($insuranceDetail,"[$i]insurance_policy_number"); ?>
        </div>
      </div>
    </div>
    <div class="large-6 columns">
      <div class="row collapse postfix-radius">
        <div class="small-5 columns">
          <span class="prefix required">Address</span>
        </div>
        <div class="small-7 columns">
          <?php echo CHtml::activeTextArea($insuranceDetail,"[$i]insured_address"); ?>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="large-6 columns">
      <div class="row collapse prefix-radius">
        
       
      </div>
    </div>
    <div class="large-6 columns">
      <div class="row collapse postfix-radius">
        <div class="small-5 columns">
          <span class="prefix required">Province</span>
        </div>
        <div class="small-7 columns">
          <?php echo CHtml::activeDropDownList($insuranceDetail, "[$i]insured_province_id", CHtml::listData(Province::model()->findAll(), 'id', 'name'),array(
                    'prompt' => '[--Select Province--]',
                    'onchange'=> '$.ajax({
                    type: "POST",
                    //dataType: "JSON",
                    url: "' . CController::createUrl('ajaxGetCity') . '/index/'.$i.'" ,
                    
                    data: $("form").serialize(),
                    success: function(data){
                                  console.log(data);
                                  $("#RegistrationInsuranceData_'.$i.'_insured_city_id").html(data);
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
          <?php //echo CHtml::activeTextField($insuranceDetail,"[$i]insurance_policy_period_start"); ?>
          <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
              'model' => $insuranceDetail,
               'attribute' => "[$i]insurance_policy_period_start",
               // additional javascript options for the date picker plugin
               'options'=>array(
                // 'disabled'=>true,
                   'dateFormat' => 'yy-mm-dd',
                   'onClose'=>'js:function(date) {
                  
                    $("#RegistrationInsuranceData_'.$i.'_insurance_policy_period_end").datepicker( "option", "minDate", date);
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
                if($insuranceDetail->insured_province_id == NULL)
                {
                  echo CHtml::activeDropDownList($insuranceDetail,"[$i]insured_city_id",array(),array('prompt'=>'[--Select City-]'));
                }
                else
                {
                  echo CHtml::activeDropDownList($insuranceDetail,"[$i]insured_city_id",CHtml::listData(City::model()->findAllByAttributes(array('province_id'=>$insuranceDetail->insured_province_id)), 'id', 'name'),array());
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
          <?php //echo CHtml::activeTextField($insuranceDetail,"[$i]insurance_policy_period_end"); ?>
          <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
              'model' => $insuranceDetail,
               'attribute' => "[$i]insurance_policy_period_end",
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
          <?php echo CHtml::activeTextField($insuranceDetail,"[$i]insured_zipcode"); ?>
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
          <?php echo CHtml::activeTextField($insuranceDetail,"[$i]deductible_own_risk"); ?>
        </div>
      </div>
    </div>
    <div class="large-6 columns">
      <div class="row collapse postfix-radius">
        <div class="small-5 columns">
          <span class="prefix">Occupation</span>
        </div>
        <div class="small-7 columns">
          <?php echo CHtml::activeTextField($insuranceDetail,"[$i]insured_occupation"); ?>
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
          <?php echo CHtml::activeTextField($insuranceDetail,"[$i]insured_telephone"); ?>
        </div>
      </div>
    </div>
    <div class="large-6 columns">
      <div class="row collapse postfix-radius">
        <div class="small-5 columns">
          <span class="prefix required">Handphone</span>
        </div>
        <div class="small-7 columns">
          <?php echo CHtml::activeTextField($insuranceDetail,"[$i]insured_handphone"); ?>
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
          <?php echo CHtml::activeTextField($insuranceDetail,"[$i]driver_name"); ?>
        </div>
      </div>
    </div>
    <div class="large-6 columns">
      <div class="row collapse postfix-radius">
        <div class="small-5 columns">
          <span class="prefix ">Email</span>
        </div>
        <div class="small-7 columns">
          <?php echo CHtml::activeTextField($insuranceDetail,"[$i]driver_email"); ?>
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
          <?php echo CHtml::activeTextField($insuranceDetail,"[$i]driver_id_number"); ?>
        </div>
      </div>
    </div>
    <div class="large-6 columns">
      <div class="row collapse postfix-radius">
        <div class="small-5 columns">
          <span class="prefix ">License Number</span>
        </div>
        <div class="small-7 columns">
          <?php echo CHtml::activeTextField($insuranceDetail,"[$i]driver_license_number"); ?>
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
          <?php echo CHtml::activeTextField($insuranceDetail,"[$i]relation_with_insured"); ?>
        </div>
      </div>
    </div>
    <div class="large-6 columns">
      <div class="row collapse postfix-radius">
        <div class="small-5 columns">
          <span class="prefix">Occupation</span>
        </div>
        <div class="small-7 columns">
          <?php echo CHtml::activeTextField($insuranceDetail,"[$i]driver_occupation"); ?>
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
          <?php echo CHtml::activeTextField($insuranceDetail,"[$i]driver_telephone"); ?>
        </div>
      </div>
    </div>
    <div class="large-6 columns">
      <div class="row collapse postfix-radius">
        <div class="small-5 columns">
          <span class="prefix ">HandPhone</span>
        </div>
        <div class="small-7 columns">
          <?php echo CHtml::activeTextField($insuranceDetail,"[$i]driver_handphone"); ?>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="large-6 columns">
      <div class="row collapse prefix-radius">
        <div class="small-5 columns">
         
        </div>
        <div class="small-7 columns">
         
        </div>
      </div>
    </div>
    <div class="large-6 columns">
      <div class="row collapse postfix-radius">
        <div class="small-5 columns">
          <span class="prefix ">Address</span>
        </div>
        <div class="small-7 columns">
          <?php echo CHtml::activeTextArea($insuranceDetail,"[$i]driver_address"); ?>
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
          <?php echo CHtml::activeTextField($insuranceDetail,"[$i]other_passenger_name"); ?>
        </div>
      </div>
    </div>
    <div class="large-6 columns">
      <div class="row collapse postfix-radius">
        <div class="small-5 columns">
          <span class="prefix ">Province</span>
        </div>
        <div class="small-7 columns">
         
         <?php echo CHtml::activeDropDownList($insuranceDetail, "[$i]driver_province_id", CHtml::listData(Province::model()->findAll(), 'id', 'name'),array(
                    'prompt' => '[--Select Province--]',
                    'onchange'=> '$.ajax({
                    type: "POST",
                    //dataType: "JSON",
                    url: "' . CController::createUrl('ajaxGetCityDriver') . '/index/'.$i.'" ,
                    
                    data: $("form").serialize(),
                    success: function(data){
                                  console.log(data);
                                  $("#RegistrationInsuranceData_'.$i.'_driver_city_id").html(data);
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
          <?php echo CHtml::activeTextField($insuranceDetail,"[$i]accident_place"); ?>
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
                if($insuranceDetail->driver_province_id == NULL)
                {
                  echo CHtml::activeDropDownList($insuranceDetail,"[$i]driver_city_id",array(),array('prompt'=>'[--Select City-]'));
                }
                else
                {
                  echo CHtml::activeDropDownList($insuranceDetail,"[$i]driver_city_id",CHtml::listData(City::model()->findAllByAttributes(array('province_id'=>$insuranceDetail->driver_province_id)), 'id', 'name'),array());
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
          <?php echo CHtml::activeTextField($insuranceDetail,"[$i]accident_date_time"); ?>
        </div>
      </div>
    </div>
    <div class="large-6 columns">
      <div class="row collapse postfix-radius">
        <div class="small-5 columns">
          <span class="prefix ">Damage Description</span>
        </div>
        <div class="small-7 columns">
          <?php echo CHtml::activeTextField($insuranceDetail,"[$i]damage_description"); ?>
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
          <?php echo CHtml::activeTextField($insuranceDetail,"[$i]speed"); ?>
        </div>
      </div>
    </div>
    <div class="large-6 columns">
      <div class="row collapse postfix-radius">
        <div class="small-5 columns">
          <span class="prefix ">Witness</span>
        </div>
        <div class="small-7 columns">
          <?php echo CHtml::activeTextField($insuranceDetail,"[$i]witness"); ?>
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
          <?php echo CHtml::activeTextField($insuranceDetail,"[$i]injury"); ?>
        </div>
      </div>
    </div>
    <div class="large-6 columns">
      <div class="row collapse postfix-radius">
        <div class="small-5 columns">
          <span class="prefix ">Reported to Police?</span>
        </div>
        <div class="small-7 columns">
        <?php echo CHtml::activeDropDownList($insuranceDetail,"[$i]is_reported",array('0'=>"YES",'1'=>'NO')); ?>
        </div>
      </div>
    </div>
  </div>  

  <div class="row">
   <div class="large-12 columns">
    <label >Accident Description
      <?php echo CHtml::activeTextArea($insuranceDetail,"[$i]accident_description"); ?>
    </label>
    </div>
  </div>

  <h3>Other Details</h3>
  <hr>
  
  <div class="row">
    <div class="large-12 columns">
      <label>Insurance Surveyor Request
        <?php echo CHtml::activeTextArea($insuranceDetail,"[$i]insurance_surveyor_request"); ?>
      </label>
    </div>
  </div>

  <div class="row">
    <div class="large-12 columns">
      <label >Customer Request
        <?php echo CHtml::activeTextArea($insuranceDetail,"[$i]customer_request"); ?>
      </label>
    </div>
  </div> 
	
<?php endforeach ?>

