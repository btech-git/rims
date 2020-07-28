<?php
/* @var $this VehicleCarSubDetailController */
/* @var $model VehicleCarSubDetail */
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
							<?php echo $form->label($model,'id', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'id'); ?>
						</div>
					</div>
				</div>	

				<!-- BEGIN field -->
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'name', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'name'); ?>
						</div>
					</div>
				</div>	

				<!-- BEGIN field -->
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'assembly_year_start', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'assembly_year_start'); ?>
						</div>
					</div>
				</div>	


				<!-- BEGIN field -->
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'transmission', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
							<?php echo  $form->dropDownList($model, 'transmission', array('Manual' => 'Manual',
							'Automatic' => 'Automatic','Sports' => 'Sports','Other' => 'Other',), array('prompt' => 'Select',)); ?>
						</div>
					</div>
				</div>	


				<!-- BEGIN field -->
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'fuel_type', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
							<?php echo  $form->dropDownList($model, 'fuel_type', array('Diesel' => 'Diesel',
							'Electric' => 'Electric','Gas' => 'Gas','Gasoline' => 'Gasoline', 'Hybrid' => 'Hybrid',), array('prompt' => 'Select',)); ?>

						</div>
					</div>
				</div>	



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

			</div>

			<div class="small-12 medium-6 columns">

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
							<?php echo $form->label($model,'power', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'power'); ?>
						</div>
					</div>
				</div>	
				<!-- BEGIN field -->
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'drivetrain', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'drivetrain',array('size'=>10,'maxlength'=>10)); ?>
						</div>
					</div>
				</div>


				<!-- BEGIN field -->
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'chasis_code', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'chasis_code'); ?>
						</div>
					</div>
				</div>	



				<!-- BEGIN field -->
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'description', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'description',array('size'=>60,'maxlength'=>60)); ?>
						</div>
					</div>
				</div>	

				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'luxury_value', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">

							<?php echo CHtml::activeTextField($model,'luxury_value',array('size'=>8,'maxlength'=>8)); ?>

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
							<?php echo  $form->dropDownList($model, 'status', array('Active' => 'Active',
							'Inactive' => 'Inactive', ), array('prompt' => 'Select',)); ?>
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
