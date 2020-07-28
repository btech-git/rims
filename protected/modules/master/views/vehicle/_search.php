<?php
/* @var $this VehicleController */
/* @var $model Vehicle */
/* @var $form CActiveForm */
?>


	<div class="wide form" id="advSearch">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'action'=>Yii::app()->createUrl($this->route),
		'method'=>'get',
	)); ?>

	<div class="row">
		<div class="small-12 medium-6 columns">

      <!-- BEGIN field -->
      <div class="field">
         <div class="row collapse">
            <div class="small-4 columns">
					<?php echo $form->label($model,'plate_number', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">	
					<?php echo $form->textField($model,'plate_number',array('size'=>10,'maxlength'=>10)); ?>           
				</div>
			</div>
		</div>
		
	<!-- BEGIN field -->
      <div class="field">
         <div class="row collapse">
            <div class="small-4 columns">
					<?php echo $form->label($model,'machine_number', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">	
					<?php echo $form->textField($model,'machine_number',array('size'=>30,'maxlength'=>30)); ?>           
				</div>
			</div>
		</div>

	<div class="field">
         <div class="row collapse">
            <div class="small-4 columns">
					<?php echo $form->label($model,'frame_number', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">	
					<?php echo $form->textField($model,'frame_number',array('size'=>30,'maxlength'=>30)); ?>           
				</div>
			</div>
		</div>

	<!-- BEGIN field -->
		<div class="field">
			 <div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($model,'color_id', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">
					<?php echo $form->dropDownList($model,'color_id', CHtml::listData(Colors::model()->findAll(),'id','name'),  array('prompt' => 'Select',)); ?>
				</div>
			</div>
		</div>

	<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($model,'year', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">	
					<?php echo $form->textField($model,'year'); ?>           
				</div>
			</div>
		</div>

	</div>
	<div class="small-12 medium-6 columns">
				
			<!-- BEGIN field -->
		<div class="field">
			 <div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($model,'car_make_id', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">
					<?php echo $form->dropDownList($model,'car_make_id', CHtml::listData(VehicleCarMake::model()->findAll(),'id','name'),  array('prompt' => 'Select',)); ?>
				</div>
			</div>
		</div>	

		<!-- BEGIN field -->
		<div class="field">
			 <div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($model,'car_model_id', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">
					<?php echo $form->dropDownList($model,'car_model_id', CHtml::listData(VehicleCarModel::model()->findAll(),'id','name'),  array('prompt' => 'Select',)); ?>
				</div>
			</div>
		</div>	
	
	<!-- BEGIN field -->
		<div class="field">
			 <div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($model,'car_sub_model_id', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">
					<?php echo $form->dropDownList($model,'car_sub_model_id', CHtml::listData(VehicleCarSubModel::model()->findAll(),'id','name'),  array('prompt' => 'Select',)); ?>
				</div>
			</div>
		</div>	

	<!-- BEGIN field -->
		<div class="field">
			 <div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($model,'customer_id', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">
					<?php echo $form->dropDownList($model,'customer_id', CHtml::listData(Customer::model()->findAll(),'id','name'),  array('prompt' => 'Select',)); ?>
				</div>
			</div>
		</div>

		<!-- BEGIN field -->
		<div class="field">
			 <div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($model,'customer_pic_id', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">
					<?php echo $form->dropDownList($model,'customer_pic_id', CHtml::listData(CustomerPic::model()->findAll(),'id','name'),  array('prompt' => 'Select',)); ?>
				</div>
			</div>
		</div>
		
	</div>
</div>

<div class="field buttons text-right">
   <?php echo CHtml::submitButton('Search', array('class' => 'button cbutton')); ?>
</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->


 