<?php
/* @var $this VehicleCarSubModelDetailController */
/* @var $model VehicleCarSubModelDetail */
/* @var $form CActiveForm */
?>

<div class="wide form" id="advSearch">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'action'=>Yii::app()->createUrl($this->route),
		'method'=>'get',
		)); ?>
		<div class="row">
			<div class="small-12 medium-6 columns">

				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'id', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'id');?>
						</div>
					</div>
				</div>




				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'car_sub_model_id', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'car_sub_model_id');?>
						</div>
					</div>
				</div>


				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'name', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'name',array('size'=>50,'maxlength'=>50));?>
						</div>
					</div>
				</div>


				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'chasis_code', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'chasis_code',array('size'=>10,'maxlength'=>10));?>
						</div>
					</div>
				</div>


				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'assembly_year_start', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'assembly_year_start',array('size'=>10,'maxlength'=>10));?>
						</div>
					</div>
				</div>


				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'assembly_year_end', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'assembly_year_end',array('size'=>10,'maxlength'=>10));?>
						</div>
					</div>
				</div>

			</div>
			<div class="small-12 medium-6 columns">

				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'transmission', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'transmission',array('size'=>30,'maxlength'=>30));?>
						</div>
					</div>
				</div>


				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'fuel_type', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'fuel_type',array('size'=>20,'maxlength'=>20));?>
						</div>
					</div>
				</div>


				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'power', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'power');?>
						</div>
					</div>
				</div>


				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'drivetrain', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'drivetrain',array('size'=>10,'maxlength'=>10));?>
						</div>
					</div>
				</div>


				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'description', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50));?>
						</div>
					</div>
				</div>


				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'status', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo  $form->dropDownList($model, 'status', array( 
									'Active' => 'Active','Inactive' => 'Inactive', 
								), array('prompt' => 'Select',)); 
							?>
						</div>
					</div>
				</div>


				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'luxury_value', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'luxury_value',array('size'=>8,'maxlength'=>8));?>
						</div>
					</div>
				</div>

				<div class="row buttons text-right">
					<?php echo CHtml::submitButton('Search', array('class'=>'button cbutton'));?>
				</div>
			</div>
		</div>

		<?php $this->endWidget(); ?>

</div><!-- search-form -->