<?php
/* @var $this ProductSpecificationTireController */
/* @var $model ProductSpecificationTire */
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
							<?php echo $form->label($model,'serial_number', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'serial_number',array('size'=>30,'maxlength'=>30));?>
						</div>
					</div>
				</div>

				
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'type', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'type',array('size'=>30,'maxlength'=>30));?>
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
							<?php echo $form->label($model,'attribute', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'attribute',array('size'=>30,'maxlength'=>30));?>
						</div>
					</div>
				</div>

				
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'overall_diameter', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'overall_diameter');?>
						</div>
					</div>
				</div>

				
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'section_width_inches', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'section_width_inches');?>
						</div>
					</div>
				</div>

				
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'section_width_mm', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'section_width_mm');?>
						</div>
					</div>
				</div>

				
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'aspect_ration', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'aspect_ration');?>
						</div>
					</div>
				</div>

			</div>
			<div class="small-12 medium-6 columns">

				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'radial_type', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'radial_type',array('size'=>5,'maxlength'=>5));?>
						</div>
					</div>
				</div>

				
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'rim_diameter', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'rim_diameter');?>
						</div>
					</div>
				</div>

				
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'load_index', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'load_index');?>
						</div>
					</div>
				</div>

				
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'speed_symbol', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'speed_symbol',array('size'=>5,'maxlength'=>5));?>
						</div>
					</div>
				</div>

				
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'ply_rating', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'ply_rating');?>
						</div>
					</div>
				</div>

				
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'lettering', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'lettering',array('size'=>5,'maxlength'=>5));?>
						</div>
					</div>
				</div>

				
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'terrain', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'terrain',array('size'=>5,'maxlength'=>5));?>
						</div>
					</div>
				</div>

				
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'local_import', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'local_import',array('size'=>10,'maxlength'=>10));?>
						</div>
					</div>
				</div>

				
				<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->label($model,'car_type', array('class'=>'prefix'));?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($model,'car_type',array('size'=>10,'maxlength'=>10));?>
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