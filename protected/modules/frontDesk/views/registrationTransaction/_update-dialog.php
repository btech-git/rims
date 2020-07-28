<?php
/* @var $this LevelController */
/* @var $model Level */


?>


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
		      <span class="prefix">Checked</span>
		    </div>
		    <div class="small-9 columns">
		       <label class="sufix"><?php echo CHtml::activeCheckBox($model,'checked', array(1=>1)); ?></label>
		    </div>
		  </div>
		</div>
	</div>

	<div class="row">
		<div class="large-6 columns">
		  <div class="row collapse prefix-radius">
		    <div class="small-3 columns">
		      <span class="prefix">Detail</span>
		    </div>
		    <div class="small-9 columns">
		      <?php echo CHtml::activeTextArea($model,'detail'); ?>
		    </div>
		  </div>	
		</div>
	</div>

	<?php if($model->name == 'Epoxy' || $model->name == 'Lain-lain(STNK,Polisi,etc)') : ?>
	<div class="row">
		<div class="large-6 columns">
		  <div class="row collapse prefix-radius">
		    <div class="small-3 columns">
		      <span class="prefix">Images</span>
		    </div>
		    <div class="small-9 columns">
		      	<?php echo $form->error($model,'images'); ?>
						
							<?php $insImages = RegistrationRealizationImages::model()->findAllByAttributes(array('registration_realization_id' => $model->id)) ?>
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
								<?php	if ($realizationImages !== null): ?>
									<?php
										//$criteria = new CDbCriteria;
										//$criteria->select = 'max(`order`) AS max_order';
										//$row = ArticlesImages::model()->findByAttributes(array('article_id' => $model->id, 'status' => 1));

										//$count_banners = count($restaurantImages);

										//$down = SKINS . 'arrow_down.png';
										//$up = SKINS . 'arrow_up.png';
									?>

									<?php foreach ($realizationImages as $realizationImage):
										if($model->name == 'Epoxy'){
											$dir = dirname(Yii::app()->request->scriptFile) . '/images/uploads/epoxy/' . $model->id . '/' . $realizationImage->filename;
											$src = Yii::app()->baseUrl . '/images/uploads/epoxy/' . $model->id . '/' . $realizationImage->filename;
										}
										else
										{
											$dir = dirname(Yii::app()->request->scriptFile) . '/images/uploads/after_service/' . $model->id . '/' . $realizationImage->filename;
											$src = Yii::app()->baseUrl . '/images/uploads/after_service/' . $model->id . '/' . $realizationImage->filename;
										}
										
									?>
									<div class="row">
										<div class="small-3 columns">
											<div style="margin-bottom:.5rem">
												<?php echo CHTml::image($src, $model->name . "Image", array("class" => "image")); ?>
											</div>
										</div>
										<div class="small-8 columns">
											<div style="padding:.375rem .5rem; border:1px solid #ccc; background:#fff; font-size:.8125rem; line-height:1.4; margin-bottom:.5rem;">
												<?php echo (Yii::app()->baseUrl . '/images/uploads/post/' . $model->id . '/' . $realizationImage->filename); ?>
											</div>
										</div>
										<div class="small-1 columns">
											<?php echo CHtml::link('x', array('deleteImageRealization', 'id' => $realizationImage->id, 'post_id' => $model->id), array('class'=>'deleteImg right','confirm' => 'Are you sure you want to delete this image?')); ?>
										</div>
									</div>
									<?php endforeach; ?>
								<?php endif;?>
							
		    </div>
		  </div>
		</div>
	</div>
	<?php endif; ?>
	<div class="row buttons text-center">
				<?php echo CHtml::submitButton('Save', array('class'=>'button cbutton')); ?>

<?php $this->endWidget(); ?>
</div> <!-- endform -->
