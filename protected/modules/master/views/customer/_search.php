<?php
/* @var $this CustomerController */
/* @var $model Customer */
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
							<?php echo $form->label($model,'name', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">	
							<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>100)); ?>            
						</div>
					</div>
				</div>

				<!-- BEGIN field -->
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'address', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">						
							<?php echo $form->textArea($model,'address',array('rows'=>6, 'cols'=>50)); ?>
						</div>
					</div>
				</div>


				<!-- BEGIN field -->
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">

						</div>
						<div class="small-8 columns">						

						</div>
					</div>
				</div>	      

				<!-- BEGIN field -->
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'city_id', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">						
							<?php echo $form->textField($model,'city_id',array('size'=>30,'maxlength'=>30)); ?>
						</div>
					</div>
				</div>	

				<!-- BEGIN field -->
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'zipcode', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">						
							<?php echo $form->textField($model,'zipcode',array('size'=>10,'maxlength'=>10)); ?>
						</div>
					</div>
				</div>				

				<!-- BEGIN field -->
     <!--  <div class="field">
         <div class="row collapse">
            <div class="small-4 columns">
		<?php //echo $form->label($model,'phone', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">						
		<?php //echo $form->textField($model,'phone',array('size'=>20,'maxlength'=>20)); ?>
				</div>
			</div>
		</div>				 -->

		<!-- BEGIN field -->
     <!--  <div class="field">
         <div class="row collapse">
            <div class="small-4 columns">
		<?php //echo $form->label($model,'mobile_phone', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">						
		<?php //echo $form->textField($model,'mobile_phone',array('size'=>20,'maxlength'=>20)); ?>
				</div>
			</div>
		</div>	 -->	

		<!-- BEGIN field -->
		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($model,'fax', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">						
					<?php echo $form->textField($model,'fax',array('size'=>20,'maxlength'=>20)); ?>
				</div>
			</div>
		</div>						

		<!-- BEGIN field -->
		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($model,'email', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">						
					<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>100)); ?>
				</div>
			</div>
		</div>	

	</div>

	<div class="small-12 medium-6 columns">

		<!-- BEGIN field -->
		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($model,'note', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">						
					<?php echo $form->textArea($model,'note',array('rows'=>6, 'cols'=>50)); ?>
				</div>
			</div>
		</div>	


		<!-- BEGIN field -->
		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($model,'customer_type', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">						
					<?php echo  $form->dropDownList($model, 'customer_type', array('Company' => 'Company',
					'Individual' => 'Individual', ), array('prompt' => 'Select',)); ?>
				</div>
			</div>
		</div>	

		<!-- BEGIN field -->
		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($model,'tenor', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">						
					<?php echo $form->textField($model,'tenor'); ?>
				</div>
			</div>
		</div>	

		<!-- BEGIN field -->
		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($model,'status', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">						
					<?php echo  $form->dropDownList($model, 'status', array('Active' => 'Active', 'Inactive' => 'Inactive', ), array('prompt' => 'Select',)); ?>
				</div>
			</div>
		</div>	

		<!-- BEGIN field -->
		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($model,'birthdate', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">						
					<?php //echo $form->textField($model,'birthdate'); ?>
					<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
						'model' => $model,
						'attribute' => "birthdate",
						'options'=>array(
							'dateFormat' => 'yy-mm-dd',
							'changeMonth'=>true,
							'changeYear'=>true,
							'yearRange'=>'1900:2020'
							),
						
						));
						?>
					</div>
				</div>
			</div>	

			<!-- BEGIN field -->
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->label($model,'flat_rate', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">						
						<?php echo $form->textField($model,'flat_rate',array('size'=>10,'maxlength'=>10)); ?>
					</div>
				</div>
			</div>	

			<div class="field buttons text-right">
				<?php echo CHtml::submitButton('Search', array('class' => 'button cbutton')); ?>
			</div>

		</div>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- search-form -->


