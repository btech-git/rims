<?php
/* @var $this WorkOrderController */
/* @var $model WorkOrder */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'work-order-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	 <?php $registrationData = RegistrationTransaction::model()->findByPk($model->registration_transaction_id); ?>
	 <div class="row">
    <div class="large-6 columns">
      <div class="row collapse prefix-radius">
        <div class="small-3 columns">
          <span class="prefix"><?php echo $form->labelEx($model,'work_order_number'); ?></span>
        </div>
        <div class="small-9 columns">
          <?php echo $form->textField($model,'work_order_number',array('size'=>30,'maxlength'=>30,'readonly'=>'true')); ?>
					<?php echo $form->error($model,'work_order_number'); ?>
        </div>
      </div>
    </div>
    <div class="large-6 columns">
      <div class="row collapse prefix-radius">
        <div class="small-3 columns">
          <span class="prefix">Customer</span>
        </div>
        <div class="small-9 columns">
           <?php echo $form->textField($model,'customer_name',array('size'=>30,'maxlength'=>30,'readonly'=>'true','value'=>$model->registration_transaction_id != "" ? $registrationData->customer->name : '')); ?>
        </div>
      </div>
    </div>
   </div>

   <div class="row">
    <div class="large-6 columns">
      <div class="row collapse prefix-radius">
        <div class="small-3 columns">
          <span class="prefix"><?php echo $form->labelEx($model,'work_order_date'); ?></span>
        </div>
        <div class="small-9 columns">
          <?php echo $form->textField($model,'work_order_date',array('readonly'=>'true')); ?>
					<?php echo $form->error($model,'work_order_date'); ?>
        </div>
      </div>
    </div>
    <div class="large-6 columns">
      <div class="row collapse prefix-radius">
        <div class="small-3 columns">
          <span class="prefix">PIC</span>
        </div>
        <div class="small-9 columns">
          <?php echo $form->textField($model,'pic_name',array('size'=>30,'maxlength'=>30,'readonly'=>'true','value'=>$model->registration_transaction_id != "" ? $registrationData->pic->name : '')); ?>
        </div>
      </div>
    </div>
   </div>

	<div class="row">
    <div class="large-6 columns">
      <div class="row collapse prefix-radius">
        <div class="small-3 columns">
          <span class="prefix"><?php echo $form->labelEx($model,'registration_transaction_id'); ?></span>
        </div>
        <div class="small-9 columns">
          <?php echo $form->textField($model,'registration_transaction_id',array('readonly'=>'true')); ?>
					<?php echo $form->error($model,'registration_transaction_id'); ?>
        </div>
      </div>
    </div>
    <div class="large-6 columns">
      <div class="row collapse prefix-radius">
        <div class="small-3 columns">
          <span class="prefix">User</span>
        </div>
        <div class="small-9 columns">
          <?php echo $form->textField($model,'user_id'); ?>
        </div>
      </div>
    </div>
   </div>
   <?php $registrationData = RegistrationTransaction::model()->findByPk($model->registration_transaction_id); ?>
   <div class="row">
    <div class="large-6 columns">
      <div class="row collapse prefix-radius">
        <div class="small-3 columns">
          <span class="prefix">Registration Date</span>
        </div>
        <div class="small-9 columns">
          <?php echo $form->textField($model,'registration_transaction_date',array('readonly'=>'true','value'=>$model->registration_transaction_id != "" ? $registrationData->transaction_date : '')); ?>
					
        </div>
      </div>
    </div>
    <div class="large-6 columns">
      <div class="row collapse prefix-radius">
        <div class="small-3 columns">
          <span class="prefix">Branch</span>
        </div>
        <div class="small-9 columns">
          <?php echo $form->textField($model,'branch_id'); ?>
        </div>
      </div>
    </div>
   </div>
	
	<fieldset>
	  <legend>Vehicle</legend>
	    <div class="row">
	      <div class="large-6 columns">
	        <div class="row collapse prefix-radius">
	          <div class="small-3 columns">
	            <span class="prefix">Plate Number</span>
	          </div>
	          <div class="small-9 columns">
	           	<?php echo $form->textField($model,'plate',array('readonly'=>'true','value'=>$model->registration_transaction_id != "" ? $registrationData->vehicle->plate_number : '')); ?>
	          </div>
	        </div>
	      </div>
	      <div class="large-6 columns">
	        <div class="row collapse prefix-radius">
	          <div class="small-3 columns">
	            <span class="prefix">Car Sub Model</span>
	          </div>
	          <div class="small-9 columns">
	            <?php echo $form->textField($model,'carSubModel',array('readonly'=>'true','value'=>$model->registration_transaction_id != "" ? $registrationData->vehicle->carSubModel->name : '')); ?>
	          </div>
	        </div>
	      </div>
	    </div>
	    <div class="row">
	      <div class="large-6 columns">
	        <div class="row collapse prefix-radius">
	          <div class="small-3 columns">
	            <span class="prefix">Machine Number</span>
	          </div>
	          <div class="small-9 columns">
	           	<?php echo $form->textField($model,'machine',array('readonly'=>'true','value'=>$model->registration_transaction_id != "" ? $registrationData->vehicle->machine_number : '')); ?>
	          </div>
	        </div>
	      </div>
	      <div class="large-6 columns">
	        <div class="row collapse prefix-radius">
	          <div class="small-3 columns">
	            <span class="prefix">Color</span>
	          </div>
	          <div class="small-9 columns">
	            <?php echo $form->textField($model,'color',array('readonly'=>'true','value'=>$model->registration_transaction_id != "" ? $registrationData->vehicle->color_id : '')); ?>
	          </div>
	        </div>
	      </div>
	    </div>
	    <div class="row">
	      <div class="large-6 columns">
	        <div class="row collapse prefix-radius">
	          <div class="small-3 columns">
	            <span class="prefix">Frame Number</span>
	          </div>
	          <div class="small-9 columns">
	           	<?php echo $form->textField($model,'frame',array('readonly'=>'true','value'=>$model->registration_transaction_id != "" ? $registrationData->vehicle->frame_number : '')); ?>
	          </div>
	        </div>
	      </div>
	      <div class="large-6 columns">
	        <div class="row collapse prefix-radius">
	          <div class="small-3 columns">
	            <span class="prefix">Year</span>
	          </div>
	          <div class="small-9 columns">
	            <?php echo $form->textField($model,'year',array('readonly'=>'true','value'=>$model->registration_transaction_id != "" ? $registrationData->vehicle->year : '')); ?>
	          </div>
	        </div>
	      </div>
	    </div>
	    <div class="row">
	      <div class="large-6 columns">
	        <div class="row collapse prefix-radius">
	          <div class="small-3 columns">
	            <span class="prefix">Car Make</span>
	          </div>
	          <div class="small-9 columns">
	           	<?php echo $form->textField($model,'carMake',array('readonly'=>'true','value'=>$model->registration_transaction_id != "" ? $registrationData->vehicle->carMake->name : '')); ?>
	          </div>
	        </div>
	      </div>
	      <div class="large-6 columns">
	        <div class="row collapse prefix-radius">
	          <div class="small-3 columns">
	            <span class="prefix">Chasis code</span>
	          </div>
	          <div class="small-9 columns">
	            <?php echo $form->textField($model,'chasis',array('readonly'=>'true','value'=>$model->registration_transaction_id != "" ? $registrationData->vehicle->chasis_code : '')); ?>
	          </div>
	        </div>
	      </div>
	    </div>
	    <div class="row">
	      <div class="large-6 columns">
	        <div class="row collapse prefix-radius">
	          <div class="small-3 columns">
	            <span class="prefix">Car Model</span>
	          </div>
	          <div class="small-9 columns">
	           	<?php echo $form->textField($model,'carModel',array('readonly'=>'true','value'=>$model->registration_transaction_id != "" ? $registrationData->vehicle->carModel->name : '')); ?>
	          </div>
	        </div>
	      </div>
	      <div class="large-6 columns">
	        <div class="row collapse prefix-radius">
	          <div class="small-3 columns">
	            <span class="prefix">Power CC</span>
	          </div>
	          <div class="small-9 columns">
	            <?php echo $form->textField($model,'power',array('readonly'=>'true','value'=>$model->registration_transaction_id != "" ? $registrationData->vehicle->power : '')); ?>
	          </div>
	        </div>
	      </div>
	    </div>
	    
	</fieldset>
		
	<div class="row">
		<div class="large-12 columns">
			<?php $this->renderPartial('_detail', array('workOrder'=>$model->id)); ?>
		</div>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->