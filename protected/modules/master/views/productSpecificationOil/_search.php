<?php
/* @var $this ProductSpecificationOilController */
/* @var $model ProductSpecificationOil */
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
							<?php echo $form->label($model,'product_id', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'product_id');?>
						</div>
					</div>
				</div>

				
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'category_usage', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'category_usage',array('size'=>30,'maxlength'=>30));?>
						</div>
					</div>
				</div>

				
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'oil_type', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'oil_type',array('size'=>30,'maxlength'=>30));?>
						</div>
					</div>
				</div>

				
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'transmission', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'transmission');?>
						</div>
					</div>
				</div>

				
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'code_serial', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'code_serial',array('size'=>30,'maxlength'=>30));?>
						</div>
					</div>
				</div>

				
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'sub_brand_id', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'sub_brand_id');?>
						</div>
					</div>
				</div>

				
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'sub_brand_series_id', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'sub_brand_series_id');?>
						</div>
					</div>
				</div>

				
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'fuel', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'fuel',array('size'=>30,'maxlength'=>30));?>
						</div>
					</div>
				</div>

				
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'dot_code', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'dot_code');?>
						</div>
					</div>
				</div>

			</div>
			<div class="small-12 medium-6 columns">

				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'viscosity_low_t', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'viscosity_low_t',array('size'=>10,'maxlength'=>10));?>
						</div>
					</div>
				</div>

				
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'viscosity_high', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'viscosity_high',array('size'=>10,'maxlength'=>10));?>
						</div>
					</div>
				</div>

				
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'api_code', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'api_code',array('size'=>10,'maxlength'=>10));?>
						</div>
					</div>
				</div>

				
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'size_measurements', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'size_measurements',array('size'=>10,'maxlength'=>10));?>
						</div>
					</div>
				</div>

				
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'size', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'size',array('size'=>10,'maxlength'=>10));?>
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
							<?php echo $form->label($model,'car_use', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textArea($model,'car_use',array('rows'=>6, 'cols'=>50));?>
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