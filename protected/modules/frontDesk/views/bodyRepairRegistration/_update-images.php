<div class="form">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'registration-transaction-form',
		'htmlOptions' => array('enctype' => 'multipart/form-data'),
		'enableAjaxValidation'=>false,
		)); ?>

		<div class="row">
			<div class="large-6 columns">
				<div class="row collapse prefix-radius">
					<div class="small-3 columns">
						<span class="prefix">Accident Images</span>
					</div>
					<div class="small-9 columns">
						<?php echo $form->error($model,'images'); ?>
						
						<?php $insImages = RegistrationInsuranceImages::model()->findAllByAttributes(array('registration_insurance_data_id' => $model->id)) ?>
						<?php if (count($insImages) == 0): ?>
							<?php
							$this->widget('CMultiFileUpload', array(
								'model' => $model,
									//'name' => 'RegistrationInsuranceImages[images]',
								'attribute' => 'images',
								'accept' => 'jpg|jpeg|png|gif',
								'denied' => 'Only jpg, jpeg, png and gif are allowed',
								'max' => 10,
								'remove' => 'x',
								'duplicate' => 'Already Selected',

								));
								?>
							<?php else:
							if ($allowedImages != 0): ?>
							<?php //echo $form->labelEx($model, 'images', array('class' => 'label')); ?>
							<?php
							$this->widget('CMultiFileUpload', array(
								'model' => $model,
								'attribute' => 'images',
								'accept' => 'jpg|jpeg|png|gif',
								'denied' => 'Only jpg, jpeg, png and gif are allowed',
								'max' => 10,
								'remove' => 'x',
								'duplicate' => 'Already Selected',

								
								));
								?>
							<?php endif; ?>
							
						<?php endif;?>
						
					</div>
				</div>
			</div>
		</div>

		<div class="row buttons text-center">
			<?php echo CHtml::submitButton('Save', array('class'=>'button cbutton')); ?>
		</div>
		<?php $this->endWidget(); ?>
	</div> <!-- endform -->

