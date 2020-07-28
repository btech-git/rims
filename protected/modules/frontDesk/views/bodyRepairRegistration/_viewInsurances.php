

<?php foreach ($insurances as $insurance): ?>
  <div class="row">
    
  
  
  </div>
 
  <div class="row">
  	<div class="large-6 columns">
      <div class="row collapse prefix-radius">
        <div class="small-3 columns">
          <span class="prefix">Insured's Name</span>
        </div>
        <div class="small-9 columns">
        <input type="text" readonly="true" value="<?php echo $insurance->insured_name; ?>">
          
        </div>
      </div>
    </div>
    <div class="large-6 columns">
      <div class="row collapse postfix-radius">
        <div class="small-3 columns">
          <span class="prefix">Email</span>
        </div>
        <div class="small-9 columns">
          <input type="text" readonly="true" value="<?php echo $insurance->insured_email; ?>">
           
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="large-6 columns">
      <div class="row collapse prefix-radius">
        <div class="small-3 columns">
          <span class="prefix">Insurance Policy Number</span>
        </div>
        <div class="small-9 columns">
          <input type="text" readonly="true" value="<?php echo $insurance->insurance_policy_number; ?>">

           
        </div>
      </div>
    </div>
    <div class="large-6 columns">
      <div class="row collapse postfix-radius">
        <div class="small-3 columns">
          <span class="prefix">Address</span>
        </div>
        <div class="small-9 columns">
          <input type="text" readonly="true" value="<?php echo $insurance->insured_address; ?>">
          
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="large-6 columns">
      <div class="row collapse prefix-radius">
        <div class="small-3 columns">
          <span class="prefix">SPK Insurance</span>
         
        </div>
        <div class="small-9 columns">
         <div class="row">
            <?php if (Yii::app()->user->checkAccess("transaction.registrationTrasaction.updateSpk")): ?>
              <?php echo CHtml::button('Update SPK', array(
                'id' => 'real-button',
                'name' => 'Real',
                'class'=>'button cbutton left',
                'style'=>'margin-right:10px',
                'onclick' => ' 
                 // window.location.href = "updateSpk?id='.$insurance->id .'";
                 // javascript:window.open("/frontDesk/registrationTransaction/updateSpk?id='.$insurance->id .'","x","width=200,height=100"); return false;
                  javascript:window.open("'. CController::createUrl('updateSpk', array('id'=> $insurance->id)) .'","x","height=600,width=600,left=100"); return false;
                  '
                )); ?>
            <?php endif ?>
            
          </div>
          <?php if($insurance->spk_insurance != null) :?>
            <div style="margin-bottom:.5rem;">
            <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/uploads/insurance/' . $insurance->id . '/' . $insurance->Featuredname,$insurance->insuranceCompany->name . "Image", array('class'=>'image')); ?>
          </div>
           <div class="row">
                <div class="small-11 columns">
                  <div class="filename">
                    <?php echo (Yii::app()->baseUrl . '/images/uploads/insurance/' . $insurance->id . '/' . $insurance->Featuredname); ?>  
                  </div>
                </div>
                <div class="small-1 columns">
                  <?php echo CHtml::link('x', array('deleteFeatured', 'id' => $insurance->id), array('class'=>'deleteImg right','confirm' => 'Are you sure you want to delete this image?')); ?>
                </div>
              </div>
          <?php endif ?>
        </div>
      </div>
    </div>
    <div class="large-6 columns">
      <div class="row collapse postfix-radius">
        <div class="small-3 columns">
          <span class="prefix">Province</span>
        </div>
        <div class="small-9 columns">
          <input type="text" readonly="true" value="<?php echo $insurance->insured_province_id; ?>">
           
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="large-6 columns">
      <div class="row collapse prefix-radius">
        <div class="small-3 columns">
          <span class="prefix">Insurance Policy Start</span>
        </div>
        <div class="small-9 columns">
          <input type="text" readonly="true" value="<?php echo $insurance->insurance_policy_period_start; ?>">
           
        </div>
      </div>
    </div>
    <div class="large-6 columns">
      <div class="row collapse postfix-radius">
        <div class="small-3 columns">
          <span class="prefix">City</span>
        </div>
        <div class="small-9 columns">
          <input type="text" readonly="true" value="<?php echo $insurance->insured_city_id; ?>">
           
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="large-6 columns">
      <div class="row collapse prefix-radius">
        <div class="small-3 columns">
          <span class="prefix">Insurance Policy End</span>
        </div>
        <div class="small-9 columns">
          <input type="text" readonly="true" value="<?php echo $insurance->insurance_policy_period_end; ?>">
          
        </div>
      </div>
    </div>
    <div class="large-6 columns">
      <div class="row collapse postfix-radius">
        <div class="small-3 columns">
          <span class="prefix">Zipcode</span>
        </div>
        <div class="small-9 columns">
        <input type="text" readonly="true" value="<?php echo $insurance->insured_zipcode; ?>">
          
        </div>
      </div>
    </div>
  </div>  

  <div class="row">
    <div class="large-6 columns">
      <div class="row collapse prefix-radius">
        <div class="small-3 columns">
          <span class="prefix">Deductible / Own Risk</span>
        </div>
        <div class="small-9 columns">
        <input type="text" readonly="true" value="<?php echo $insurance->deductible_own_risk; ?>">
           
        </div>
      </div>
    </div>
    <div class="large-6 columns">
      <div class="row collapse postfix-radius">
        <div class="small-3 columns">
          <span class="prefix">Occupation</span>
        </div>
        <div class="small-9 columns">
        <input type="text" readonly="true" value="<?php echo $insurance->insured_occupation; ?>">
           
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="large-6 columns">
      <div class="row collapse prefix-radius">
        <div class="small-3 columns">
          <span class="prefix">Telephone</span>
        </div>
        <div class="small-9 columns">
        <input type="text" readonly="true" value="<?php echo $insurance->insured_telephone; ?>">
           
        </div>
      </div>
    </div>
    <div class="large-6 columns">
      <div class="row collapse postfix-radius">
        <div class="small-3 columns">
          <span class="prefix">Handphone</span>
        </div>
        <div class="small-9 columns">
        <input type="text" readonly="true" value="<?php echo $insurance->insured_handphone; ?>">
           
        </div>
      </div>
    </div>
  </div>

  <h3>Accident Detail (Description)</h3>
  <hr>
  
  <div class="row">
    <div class="large-6 columns">
      <div class="row collapse prefix-radius">
        <div class="small-3 columns">
          <span class="prefix">Driver's Name</span>
        </div>
        <div class="small-9 columns">
        <input type="text" readonly="true" value="<?php echo $insurance->driver_name; ?>">
           
        </div>
      </div>
    </div>
    <div class="large-6 columns">
      <div class="row collapse postfix-radius">
        <div class="small-3 columns">
          <span class="prefix">Email</span>
        </div>
        <div class="small-9 columns">
        <input type="text" readonly="true" value="<?php echo $insurance->driver_email; ?>">
           
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="large-6 columns">
      <div class="row collapse prefix-radius">
        <div class="small-3 columns">
          <span class="prefix">ID Number</span>
        </div>
        <div class="small-9 columns">
        <input type="text" readonly="true" value="<?php echo $insurance->driver_id_number; ?>">
           
        </div>
      </div>
    </div>
    <div class="large-6 columns">
      <div class="row collapse postfix-radius">
        <div class="small-3 columns">
          <span class="prefix">License Number</span>
        </div>
        <div class="small-9 columns">
        <input type="text" readonly="true" value="<?php echo $insurance->driver_license_number; ?>">
           
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="large-6 columns">
      <div class="row collapse prefix-radius">
        <div class="small-3 columns">
          <span class="prefix">Relation With Insured</span>
        </div>
        <div class="small-9 columns">
        <input type="text" readonly="true" value="<?php echo $insurance->relation_with_insured; ?>">
           
        </div>
      </div>
    </div>
    <div class="large-6 columns">
      <div class="row collapse postfix-radius">
        <div class="small-3 columns">
          <span class="prefix">Occupation</span>
        </div>
        <div class="small-9 columns">
        <input type="text" readonly="true" value="<?php echo $insurance->driver_occupation; ?>">
           
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="large-6 columns">
      <div class="row collapse prefix-radius">
        <div class="small-3 columns">
          <span class="prefix">Telephone</span>
        </div>
        <div class="small-9 columns">
        <input type="text" readonly="true" value="<?php echo $insurance->driver_telephone; ?>">
           
        </div>
      </div>
    </div>
    <div class="large-6 columns">
      <div class="row collapse postfix-radius">
        <div class="small-3 columns">
          <span class="prefix">HandPhone</span>
        </div>
        <div class="small-9 columns">
        <input type="text" readonly="true" value="<?php echo $insurance->driver_handphone; ?>">
           
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="large-6 columns">
      <div class="row collapse prefix-radius">
        <div class="small-3 columns">
         
        </div>
        <div class="small-9 columns">
         
        </div>
      </div>
    </div>
    <div class="large-6 columns">
      <div class="row collapse postfix-radius">
        <div class="small-3 columns">
          <span class="prefix">Address</span>
        </div>
        <div class="small-9 columns">
        <input type="text" readonly="true" value="<?php echo $insurance->driver_address; ?>">
           
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="large-6 columns">
      <div class="row collapse prefix-radius">
        <div class="small-3 columns">
          <span class="prefix">Other Passenger Name</span>
        </div>
        <div class="small-9 columns">
        <input type="text" readonly="true" value="<?php echo $insurance->other_passenger_name; ?>">
           
        </div>
      </div>
    </div>
    <div class="large-6 columns">
      <div class="row collapse postfix-radius">
        <div class="small-3 columns">
          <span class="prefix">Province</span>
        </div>
        <div class="small-9 columns">
        <input type="text" readonly="true" value="<?php echo $insurance->driver_province_id; ?>">
          
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="large-6 columns">
      <div class="row collapse prefix-radius">
        <div class="small-3 columns">
          <span class="prefix">Accident Place</span>
        </div>
        <div class="small-9 columns">
        <input type="text" readonly="true" value="<?php echo $insurance->accident_place; ?>">
           
        </div>
      </div>
    </div>
    <div class="large-6 columns">
      <div class="row collapse postfix-radius">
        <div class="small-3 columns">
          <span class="prefix">City</span>
        </div>
        <div class="small-9 columns">
        <input type="text" readonly="true" value="<?php echo $insurance->driver_city_id; ?>">
          
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="large-6 columns">
      <div class="row collapse prefix-radius">
        <div class="small-3 columns">
          <span class="prefix">Accident Date and Time</span>
        </div>
        <div class="small-9 columns">
        <input type="text" readonly="true" value="<?php echo $insurance->accident_date_time; ?>">
          
        </div>
      </div>
    </div>
    <div class="large-6 columns">
      <div class="row collapse postfix-radius">
        <div class="small-3 columns">
          <span class="prefix">Damage Description</span>
        </div>
        <div class="small-9 columns">
        <input type="text" readonly="true" value="<?php echo $insurance->damage_description; ?>">
           
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="large-6 columns">
      <div class="row collapse prefix-radius">
        <div class="small-3 columns">
          <span class="prefix">Speed</span>
        </div>
        <div class="small-9 columns">
        <input type="text" readonly="true" value="<?php echo $insurance->speed; ?>">
           
        </div>
      </div>
    </div>
    <div class="large-6 columns">
      <div class="row collapse postfix-radius">
        <div class="small-3 columns">
          <span class="prefix">Witness</span>
        </div>
        <div class="small-9 columns">
          
          <input type="text" readonly="true" value="<?php echo $insurance->witness;?>"> 
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="large-6 columns">
      <div class="row collapse prefix-radius">
        <div class="small-3 columns">
          <span class="prefix">Injury</span>
        </div>
        <div class="small-9 columns">
        <input type="text" readonly="true" value="<?php echo $insurance->injury; ?>">
           
        </div>
      </div>
    </div>
    <div class="large-6 columns">
      <div class="row collapse postfix-radius">
        <div class="small-3 columns">
          <span class="prefix">Reported to Police?</span>
        </div>
        <div class="small-9 columns">
        <input type="text" readonly="true" value="<?php echo $insurance->is_reported == 0 ? 'NO' : 'YES'; ?>">
         
        </div>
      </div>
    </div>
  </div>  

  <div class="row">
   <div class="large-12 columns">
    <label>Accident Description
    <textarea readonly="true"><?php echo $insurance->accident_description; ?></textarea>
    
      
    </label>
    </div>
  </div>

  <h3>Other Details</h3>
  <hr>
  
  <div class="row">
    <div class="large-12 columns">
      <label>Insurance Surveyor Request
      <textarea readonly="true"><?php echo $insurance->insurance_surveyor_request; ?></textarea>
      
         
      </label>
    </div>
  </div>

  <div class="row">
    <div class="large-12 columns">
      <label>Customer Request
      <textarea readonly="true"><?php echo $insurance->customer_request; ?></textarea>
         
      </label>
    </div>
  </div> 
  <?php $insuranceImages = RegistrationInsuranceImages::model()->findAllByAttributes(array('registration_insurance_data_id'=>$insurance->id, 'is_inactive'=>$insurance::STATUS_ACTIVE)); ?>
  <div class="row">
    <div class="large-12 columns">
      <label> Images</label>
      <div class="row">
        <?php if (Yii::app()->user->checkAccess("transaction.registrationTrasaction.updateImages")): ?>
          <?php echo CHtml::button('Update Images', array(
                'id' => 'real-button',
                'name' => 'Real',
                'class'=>'button cbutton left',
                'onclick' => ' 
                  javascript:window.open("'. CController::createUrl('updateImages', array('id'=> $insurance->id)) .'","x","height=600,width=600,left=100"); return false;
                 '
                )); ?>
        <?php endif ?>
        
      </div>
      <?php if (count($insuranceImages) != 0): ?>
        <?php foreach ($insuranceImages as $insuranceImage):
        $dir = dirname(Yii::app()->request->scriptFile) . '/images/uploads/insurance/accident/' . $insurance->id . '/' . $insuranceImage->filename;
        $src = Yii::app()->baseUrl . '/images/uploads/insurance/accident/' . $insurance->id . '/' . $insuranceImage->filename;
        ?>
      
        <div class="row">
          <div class="small-3 columns">
            <div style="margin-bottom:.5rem">
              <?php echo CHTml::image($src, $insurance->insuranceCompany->name . "Image", array("class" => "image")); ?>
            </div>
          </div>
          <div class="small-8 columns">
            <div style="padding:.375rem .5rem; border:1px solid #ccc; background:#fff; font-size:.8125rem; line-height:1.4; margin-bottom:.5rem;">
              <?php echo (Yii::app()->baseUrl . '/images/uploads/insurance/accident/' . $insurance->id . '/' . $insuranceImage->filename); ?>
            </div>
          </div>
          <div class="small-1 columns">
            <?php if (Yii::app()->user->checkAccess("transaction.registrationTrasaction.deleteImage")): ?>
              <?php echo CHtml::link('x', array('deleteImage', 'id' => $insuranceImage->id, 'post_id' => $insurance->id), array('class'=>'deleteImg right','confirm' => 'Are you sure you want to delete this image?')); ?>
            <?php endif ?>
            
          </div>
        </div>
        <?php endforeach; ?>
      <?php else : ?>
        <?php echo 'No Images' ?>
      <?php endif ?>
    </div>
  </div>
	
<?php endforeach ?>

